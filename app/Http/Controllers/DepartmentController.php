<?php

namespace RPSEMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use RPSEMS\Models\Department;

class DepartmentController extends AbstractController
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct('department');
    }

    /**
     * @return View
     */
    public function index()
    {
        return view(
            $this->getView('index'),
            [
                'departments' => Department::where('parent_id', null)->orderBy('name')->get()
            ]
        );
    }

    /**
     * @param Department $department
     *
     * @return View
     */
    public function show(Department $department)
    {
        return view(
            $this->getView('show'),
            [
                'department' => $department,
                'subDepartments' => $department->departments()->orderBy('name')->get()
            ]
        );
    }

    /**
     * @param Department $parent
     *
     * @return View
     */
    public function create(Department $parent = null)
    {
        return view(
            $this->getView('create'),
            [
                'parent' => $parent,
                'departments' => $this->getAllowedParents(),
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = $this->validateForm($request);
        if ($validator->fails()) {
            return redirect()->action('DepartmentController@create')->withErrors($validator)->withInput();
        }

        $department = new Department();
        $this->setData($department);
        $department->save();
        $department->path .= $department->id . '/';
        $department->update();

        $parentId = (int)$department->parent_id;
        if ($parentId) {
            $redirect = redirect()->action('DepartmentController@show', ['department' => $parentId]);
        } else {
            $redirect = redirect()->action('DepartmentController@index');
        }

        return $redirect->with('message', 'Department created');
    }

    /**
     * @param Department $department
     *
     * @return View
     */
    public function edit(Department $department)
    {
        return view(
            $this->getView('edit'),
            [
                'department' => $department,
                'departments' => $this->getAllowedParents($department),
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $id = $request->get('id');
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = $this->validateForm($request);
        if ($validator->fails()) {
            return redirect()
                ->action('DepartmentController@edit', ['department' => $id])
                ->withErrors($validator)->withInput();
        }

        /** @var Department $department */
        $department = Department::find($id);
        $oldPath = $department->path;
        $this->setData($department);
        $department->save();

        $newPath = $department->path;
        if ($oldPath != $newPath) {
            if ((int)$department->hasSubDepartments()) {
                $this->generalService->updatePath($department->getTable(), $oldPath, $newPath);
            }
        }

        return redirect()->action('DepartmentController@show', ['id' => $department->id])->with('message',
                'Department updated');
    }

    /**
     * @return RedirectResponse
     */
    public function delete()
    {
        $id = Input::get('id');
        /** @var Department $department */
        $department = Department::find($id);

        $path = $department->path;
        $name = $department->name;
        $table = $department->getTable();
        $parentId = (int)$department->parent_id;
        $hasSubDepartments = (int)$department->hasSubDepartments();
        $department->delete();

        $newPath = '';
        $msg = $name . ' department deleted!';
        if ($hasSubDepartments) {
            if (Input::get('deleteType') == 'all') {
                $affectedRows = $this->generalService->deleteAll($table, $path);
                $msg = $name . ' department and all its ' . $affectedRows . ' sub departments were deleted!';
            } else {
                $this->generalService->updatePath($table, $path, $newPath);
            }
        }

        if ($parentId) {
            $redirect = redirect()->action('DepartmentController@show', ['department' => $parentId]);
        } else {
            $redirect = redirect()->action('DepartmentController@index');
        }

        return $redirect->with('message', $msg);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function validateForm($request)
    {
        return Validator::make($request->all(), ['name' => 'required']);
    }

    /**
     * @param Department $department
     */
    protected function setData(&$department)
    {
        $isNew = (int)$department->id ? false : true;
        $department->name = Input::get('name');
        $parentId = (int)Input::get('parent_id');
        $parentPath = '';

        if ($parentId) {
            $parent = Department::find($parentId);
            $parentPath = $parent->path;
        }

        if ($isNew) {
            $department->path = $parentPath;
        } elseif ($department->parent_id != $parentId) {
            $department->path = $parentPath . $department->id . '/';
        }

        $department->parent_id = $parentId ? $parentId : null;
    }

    /**
     * @param Department $department
     *
     * @return array
     */
    protected function getAllowedParents($department = null)
    {
        $query = Department::query()->orderBy('path');
        if ($department) {
            $query->where('path', 'NOT LIKE', $department->path . '%');
        }
        $departments = $query->get();

        return $departments;
    }
}

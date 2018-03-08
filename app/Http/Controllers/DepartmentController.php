<?php

namespace RPSHRMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use RPSHRMS\Models\Department;

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
                'departments' => Department::where('parent_id', null)->withCount('subDepartments')->orderBy('name')->get()
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
                'subDepartments' => $department->subDepartments()->withCount('subDepartments')->orderBy('name')->get()
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
            $this->getFormData(null, $parent)
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

        return $redirect->with('message', 'Department ' . $department->name . ' created');
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
            $this->getFormData($department)
        );
    }

    /**
     * @param Request $request
     * @param Department $department
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Department $department)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = $this->validateForm($request);
        if ($validator->fails()) {
            return redirect()
                ->action('DepartmentController@edit', ['department' => $department->id])
                ->withErrors($validator)->withInput();
        }

        $oldPath = $department->path;
        $this->setData($department);
        $department->save();

        $newPath = $department->path;
        if ($oldPath != $newPath) {
            if ((int)$department->hasSubDepartments()) {
                $this->generalService->updatePath($department->getTable(), $oldPath, $newPath);
            }
        }

        return redirect()->action('DepartmentController@show', ['id' => $department->id])
            ->with('message', 'Department ' . $department->name . ' updated');
    }

    /**
     * @param Department $department
     *
     * @return RedirectResponse
     */
    public function destroy(Department $department)
    {
        $path = $department->path;
        $name = $department->name;
        $table = $department->getTable();
        $parentId = (int)$department->parent_id;
        $hasSubDepartments = (int)$department->hasSubDepartments();
        $department->delete();

        $newPath = '';
        $msg = $name . ' department deleted!';
        if ($hasSubDepartments) {
            if (request('deleteType') == 'all') {
                $affectedRows = $this->generalService->deleteAll($table, $path);
                $msg = $name . ' department ';
                if ($affectedRows > 1) {
                    $msg .= 'and all it\'s ' . $affectedRows . ' sub departments were deleted!';
                } else {
                    $msg .= 'and it\'s sub department were deleted!';
                }
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
     * @param Department $department
     * @param Department $parent
     *
     * @return array
     */
    protected function getFormData($department = null, $parent = null)
    {
        $departments = $this->getAllowedParents($department);
        $department = $department ? $department : new Department();
        return [
            'parent' => $parent,
            'department' => $department,
            'departments' => $departments,
            'selectedParent' => old('parent_id', empty($parent) ? $department->parent_id : $parent->id),
        ];
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
        $department->name = request('name');
        $parentId = (int)request('parent_id');
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
        $query = Department::orderBy('name');
        if (is_object($department) && $department->path) {
            $query->where('path', 'NOT LIKE', $department->path . '%');
        }
        return $query->get();
    }
}

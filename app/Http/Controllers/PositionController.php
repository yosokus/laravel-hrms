<?php

namespace RPSEMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use RPSEMS\Models\Position;

class PositionController extends AbstractController
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct('position');
    }

    /**
     * @return View
     */
    public function index()
    {
        return view(
            $this->getView('index'),
            [
                'positions' => Position::where('parent_id', null)->orderBy('name')->get()
            ]
        );
    }

    /**
     * @param Position $position
     *
     * @return View
     */
    public function show(Position $position)
    {
        return view(
            $this->getView('show'),
            [
                'position' => $position,
                'subPositions' => $position->positions()->orderBy('name')->get()
            ]
        );
    }

    /**
     * @param Position $parent
     *
     * @return View
     */
    public function create(Position $parent = null)
    {
        return view(
            $this->getView('create'),
            [
                'parent' => $parent,
                'positions' => $this->getAllowedParents(),
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
            return redirect()->action('PositionController@create')->withErrors($validator)->withInput();
        }

        $position = new Position();
        $this->setData($position);
        $position->save();
        $position->path .= $position->id . '/';
        $position->update();

        $parentId = (int)$position->parent_id;
        if ($parentId) {
            $redirect = redirect()->action('PositionController@show', ['position' => $parentId]);
        } else {
            $redirect = redirect()->action('PositionController@index');
        }

        return $redirect->with('message', 'Position created');
    }

    /**
     * @param Position $position
     *
     * @return View
     */
    public function edit(Position $position)
    {
        return view(
            $this->getView('edit'),
            [
                'position' => $position,
                'positions' => $this->getAllowedParents($position),
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
                ->action('PositionController@edit', ['position' => $id])
                ->withErrors($validator)->withInput();
        }

        /** @var Position $position */
        $position = Position::find($id);
        $oldPath = $position->path;
        $this->setData($position);
        $position->save();

        $newPath = $position->path;
        if ($oldPath != $newPath) {
            if ((int)$position->hasSubPositions()) {
                $this->generalService->updatePath($position->getTable(), $oldPath, $newPath);
            }
        }

        return redirect()->action('PositionController@show', ['id' => $position->id])
            ->with('message', 'Position updated');
    }

    /**
     * @return RedirectResponse
     */
    public function delete()
    {
        $id = Input::get('id');
        /** @var Position $position */
        $position = Position::find($id);

        $path = $position->path;
        $name = $position->name;
        $table = $position->getTable();
        $parentId = (int)$position->parent_id;
        $hasSubPositions = (int)$position->hasSubPositions();
        $position->delete();

        $newPath = '';
        $msg = $name . ' position deleted!';
        if ($hasSubPositions) {
            if (Input::get('deleteType') == 'all') {
                $affectedRows = $this->generalService->deleteAll($table, $path);
                $msg = $name . ' position and all its ' . $affectedRows . ' sub positions were deleted!';
            } else {
                $this->generalService->updatePath($table, $path, $newPath);
            }
        }

        if ($parentId) {
            $redirect = redirect()->action('PositionController@show', ['position' => $parentId]);
        } else {
            $redirect = redirect()->action('PositionController@index');
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
     * @param Position $position
     */
    protected function setData(&$position)
    {
        $isNew = (int)$position->id ? false : true;
        $position->name = Input::get('name');
        $parentId = (int)Input::get('parent_id');
        $parentPath = '';

        if ($parentId) {
            $parent = Position::find($parentId);
            $parentPath = $parent->path;
        }

        if ($isNew) {
            $position->path = $parentPath;
        } elseif ($position->parent_id != $parentId) {
            $position->path = $parentPath . $position->id . '/';
        }

        $position->parent_id = $parentId ? $parentId : null;
    }

    /**
     * @param Position $position
     *
     * @return array
     */
    protected function getAllowedParents($position = null)
    {
        $query = Position::query()->orderBy('path');
        if ($position) {
            $query->where('path', 'NOT LIKE', $position->path . '%');
        }
        $positions = $query->get();

        return $positions;
    }
}

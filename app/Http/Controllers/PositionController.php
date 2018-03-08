<?php

namespace RPSHRMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use RPSHRMS\Models\Position;

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
                'positions' => Position::where('parent_id', null)->withCount('subPositions')->orderBy('name')->get()
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
                'subPositions' => $position->subPositions()->withCount('subPositions')->orderBy('name')->get()
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

        return $redirect->with('message', 'Position ' . $position->name . ' created');
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
            $this->getFormData($position)
        );
    }

    /**
     * @param Request $request
     * @param Position $position
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Position $position)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = $this->validateForm($request);
        if ($validator->fails()) {
            return redirect()
                ->action('PositionController@edit', ['position' => $position->id])
                ->withErrors($validator)->withInput();
        }

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
            ->with('message', 'Position ' . $position->name . ' updated');
    }

    /**
     * @param Position $position
     *
     * @return RedirectResponse
     */
    public function destroy(Position $position)
    {
        $path = $position->path;
        $name = $position->name;
        $table = $position->getTable();
        $parentId = (int)$position->parent_id;
        $hasSubPositions = (int)$position->hasSubPositions();
        $position->delete();

        $newPath = '';
        $msg = $name . ' position deleted!';
        if ($hasSubPositions) {
            if (request('deleteType') == 'all') {
                $affectedRows = $this->generalService->deleteAll($table, $path);
                $msg = $name . ' position ';
                if ($affectedRows > 1) {
                    $msg .= 'and all it\'s ' . $affectedRows . ' sub positions were deleted!';
                } else {
                    $msg .= 'and it\'s sub position were deleted!';
                }
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
     * @param Position $position
     * @param Position $parent
     *
     * @return array
     */
    protected function getFormData($position = null, $parent = null)
    {
        $positions = $this->getAllowedParents($position);
        $position = $position ? $position : new Position();
        return [
            'parent' => $parent,
            'position' => $position,
            'positions' => $positions,
            'selectedParent' => old('parent_id', empty($parent) ? $position->parent_id : $parent->id),
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
     * @param Position $position
     */
    protected function setData(&$position)
    {
        $isNew = (int)$position->id ? false : true;
        $position->name = request('name');
        $parentId = (int)request('parent_id');
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
        $query = Position::orderBy('name');
        if (is_object($position) && $position->path) {
            $query->where('path', 'NOT LIKE', $position->path . '%');
        }
        return $query->get();
    }
}

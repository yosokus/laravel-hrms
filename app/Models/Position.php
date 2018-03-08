<?php

namespace RPSHRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $path
 */

class Position extends Model
{
    /**
     * Get the parent Position.
     */
    public function parent()
    {
        return $this->belongsTo('RPSHRMS\Models\Position', 'parent_id');
    }

    /**
     * Get the sub-positions.
     */
    public function subPositions()
    {
        return $this->hasMany('RPSHRMS\Models\Position', 'parent_id');
    }

    /**
     * @return int
     */
    public function hasSubPositions()
    {
        return $this->subPositions()->count();
    }

    /**
     * Get employees.
     */
    public function employees()
    {
        return $this->hasMany('RPSHRMS\Models\Employee');
    }
}

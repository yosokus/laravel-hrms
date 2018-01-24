<?php

namespace RPSEMS\Models;

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
        return $this->belongsTo('RPSEMS\Models\Position', 'parent_id');
    }

    /**
     * Get the sub-positions.
     */
    public function positions()
    {
        return $this->hasMany('RPSEMS\Models\Position', 'parent_id');
    }

    /**
     * @return int
     */
    public function hasSubPositions()
    {
        return $this->positions()->count();
    }
}

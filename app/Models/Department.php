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

class Department extends Model
{
    /**
     * Get the parent Department.
     */
    public function parent()
    {
        return $this->belongsTo('RPSHRMS\Models\Department', 'parent_id');
    }

    /**
     * Get the sub-departments.
     */
    public function subDepartments()
    {
        return $this->hasMany('RPSHRMS\Models\Department', 'parent_id');
    }

    /**
     * @return int
     */
    public function hasSubDepartments()
    {
        return $this->subDepartments()->count();
    }

    /**
     * Get department employees.
     */
    public function employees()
    {
        return $this->hasMany('RPSHRMS\Models\Employee');
    }
}

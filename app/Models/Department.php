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

class Department extends Model
{
    /**
     * Get the parent Department.
     */
    public function parent()
    {
        return $this->belongsTo('RPSEMS\Models\Department', 'parent_id');
    }

    /**
     * Get the sub-departments.
     */
    public function departments()
    {
        return $this->hasMany('RPSEMS\Models\Department', 'parent_id');
    }

    /**
     * @return int
     */
    public function hasSubDepartments()
    {
        return $this->departments()->count();
    }
}

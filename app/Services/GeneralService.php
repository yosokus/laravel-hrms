<?php

namespace RPSEMS\Services;

use Illuminate\Support\Facades\DB;

class GeneralService
{
    /**
     * @param string $table
     * @param string $oldPath
     * @param string $newPath
     *
     * @return int
     */
    public function updatePath($table, $oldPath, $newPath)
    {
        return DB::update(
            'UPDATE ' . $table . ' SET path = REPLACE(path, ?, ?) WHERE path LIKE ?',
            [$oldPath, $newPath, $oldPath . '%']
        );
    }

    /**
     * @param string $table
     * @param string $path
     *
     * @return int
     */
    public function deleteAll($table, $path)
    {
        return DB::update('DELETE FROM ' . $table . ' WHERE path LIKE ?', [$path . '%']);
    }
}

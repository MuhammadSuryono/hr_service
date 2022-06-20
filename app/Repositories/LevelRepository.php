<?php

namespace App\Repositories;

use App\Models\Level;

class LevelRepository extends Controller implements Interfaces\Level
{

    /**
     * @inheritDoc
     */
    public function list_level()
    {
        return Level::paginate($this->getLimit());
    }

    /**
     * @inheritDoc
     */
    public function read_level(int $id): object
    {
        $level = Level::find($id);
        if ($level == null) return $this->callback(false, 'Level not found');
        return $this->callback(true, 'Level found', $level);
    }

    /**
     * @inheritDoc
     */
    public function add_level(): object
    {
        $level = new Level();
        $level->name = $this->request->name;
        $isSaved = $level->save();
        return $this->callback($isSaved, $isSaved ? 'Level added' : 'Level not added');
    }

    /**
     * @inheritDoc
     */
    public function update_level(int $id): object
    {
        $level = Level::find($id);
        if ($level == null) return $this->callback(false, 'Level not found');
        $level->name = $this->request->name;
        $isSaved = $level->save();
        return $this->callback($isSaved, $isSaved ? 'Level updated' : 'Level not updated');
    }

    /**
     * @inheritDoc
     */
    public function delete_level(int $id): object
    {
        $level = Level::find($id);
        if ($level == null) return $this->callback(false, 'Level not found');
        $isDeleted = $level->delete();
        return $this->callback($isDeleted, $isDeleted ? 'Level deleted' : 'Level not deleted');
    }
}

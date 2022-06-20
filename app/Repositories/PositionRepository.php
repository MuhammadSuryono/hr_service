<?php

namespace App\Repositories;

use App\Models\Position;

class PositionRepository extends Controller implements Interfaces\Position
{

    /**
     * @inheritDoc
     */
    public function list_position()
    {
        return Position::paginate($this->getLimit());
    }

    /**
     * @inheritDoc
     */
    public function read_position(int $id): object
    {
        $position = Position::find($id);
        if ($position == null) return $this->callback(false, 'Position not found');
        return $this->callback(true, 'Position found', $position);
    }

    /**
     * @inheritDoc
     */
    public function add_position(): object
    {
        $position = new Position();
        $position->name = $this->request->name;
        $isSaved = $position->save();
        return $this->callback($isSaved, $isSaved ? 'Position added' : 'Position not added');
    }

    /**
     * @inheritDoc
     */
    public function update_position(int $id): object
    {
        $position = Position::find($id);
        if ($position == null) return $this->callback(false, 'Position not found');
        $position->name = $this->request->name;
        $isSaved = $position->save();
        return $this->callback($isSaved, $isSaved ? 'Position updated' : 'Position not updated');
    }

    /**
     * @inheritDoc
     */
    public function delete_position(int $id): object
    {
        $position = Position::find($id);
        if ($position == null) return $this->callback(false, 'Position not found');
        $isDeleted = $position->delete();
        return $this->callback($isDeleted, $isDeleted ? 'Position deleted' : 'Position not deleted');
    }
}

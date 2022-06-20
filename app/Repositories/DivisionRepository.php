<?php

namespace App\Repositories;

use App\Models\Division;

class DivisionRepository extends Controller implements Interfaces\Division
{

    /**
     * @inheritDoc
     */
    public function list_division()
    {
        return Division::paginate($this->getLimit());
    }

    /**
     * @inheritDoc
     */
    public function read_division(int $id): object
    {
        $division = Division::find($id);
        if ($division == null) return $this->callback(false, 'Division not found');
        return $this->callback(true, 'Division found', $division);
    }

    /**
     * @inheritDoc
     */
    public function add_division(): object
    {
        $division = new Division();
        $division->name = $this->request->name;
        $isSaved = $division->save();
        return $this->callback($isSaved, $isSaved ? 'Division added' : 'Division not added');
    }

    /**
     * @inheritDoc
     */
    public function update_division(int $id): object
    {
        $division = Division::find($id);
        if ($division == null) return $this->callback(false, 'Division not found');
        $division->name = $this->request->name;
        $isSaved = $division->save();
        return $this->callback($isSaved, $isSaved ? 'Division updated' : 'Division not updated');
    }

    /**
     * @inheritDoc
     */
    public function delete_division(int $id): object
    {
        $division = Division::find($id);
        if ($division == null) return $this->callback(false, 'Division not found');
        $isDeleted = $division->delete();
        return $this->callback($isDeleted, $isDeleted ? 'Division deleted' : 'Division not deleted');
    }
}

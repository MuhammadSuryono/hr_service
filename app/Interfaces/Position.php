<?php

namespace App\Repositories\Interfaces;

interface Position
{
    /**
     * @return mixed
     */
    public function list_position();

    /**
     * @param int $id
     * @return object
     */
    public function read_position(int $id): object;

    /**
     * @return object
     */
    public function add_position(): object;

    /**
     * @param int $id
     * @return object
     */
    public function update_position(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function delete_position(int $id): object;
}

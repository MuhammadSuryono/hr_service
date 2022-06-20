<?php

namespace App\Repositories\Interfaces;

interface Level
{
    /**
     * @return mixed
     */
    public function list_level();

    /**
     * @param int $id
     * @return object
     */
    public function read_level(int $id): object;

    /**
     * @return object
     */
    public function add_level(): object;

    /**
     * @param int $id
     * @return object
     */
    public function update_level(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function delete_level(int $id): object;
}

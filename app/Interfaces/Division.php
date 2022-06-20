<?php

namespace App\Repositories\Interfaces;

interface Division
{
    /**
     * @return mixed
     */
    public function list_division();

    /**
     * @param int $id
     * @return object
     */
    public function read_division(int $id): object;

    /**
     * @return object
     */
    public function add_division(): object;

    /**
     * @param int $id
     * @return object
     */
    public function update_division(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function delete_division(int $id): object;
}

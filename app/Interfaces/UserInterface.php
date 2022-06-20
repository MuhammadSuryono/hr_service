<?php

namespace App\Interfaces;

use App\Http\Requests\UserFamilyCreate;

Interface UserInterface
{
    /**
     * @return object
     */
    public function list_users(): object;

    /**
     * @return object
     */
    public function create_user(): object;

    /**
     * @param int $id
     * @return object
     */
    public function update_user(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function delete_user(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function add_detail_user(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function add_bank_account(int $id): object;

    /**
     * @return object
     */
    public function add_document(): object;

    /**
     * @param int $bankAccountId
     * @return object
     */
    public function update_bank_account(int $bankAccountId): object;

    /**
     * @param int $bankAccountId
     * @return object
     */
    public function delete_bank_account(int $bankAccountId): object;

    /**
     * @param int $id
     * @return object
     */
    public function read_detail_user(int $id): object;

    /**
     * @param int $id
     * @return object
     */
    public function delete_document(int $id): object;

    /**
     * @param UserFamilyCreate $request
     * @return object
     */
    public function add_member_family(UserFamilyCreate $request): object;
}

<?php


namespace App\Services;


use App\Models\User;

class UserService extends AbstractBaseService
{
    /**
     * UserService constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}

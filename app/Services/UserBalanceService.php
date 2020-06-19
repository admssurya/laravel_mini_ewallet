<?php


namespace App\Services;


use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;

class UserBalanceService extends AbstractBaseService
{
    private $userService;

    public function __construct(UserBalance $userBalance, UserService $userService)
    {
        $this->model = $userBalance;
        $this->userService = $userService;
    }

    public function create(Request $request)
    {
        // relation
        $this->model->user()->associate($this->userService->getById($request->get('user_id')));

        return parent::create($request);
    }

    public function update(Request $request, $id)
    {
        // relation
        $this->model->user()->associate($this->userService->getById($request->get('user_id')));

        return parent::update($request, $id);
    }
}

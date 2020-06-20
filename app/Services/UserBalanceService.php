<?php


namespace App\Services;


use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBalanceService extends AbstractBaseService
{
    private $userService;

    public function __construct(UserBalance $userBalance, UserService $userService)
    {
        $this->model = $userBalance;
        $this->userService = $userService;
    }

    public function getAll()
    {
        return $this->model->where('user_id', Auth::user()->id)->get();
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

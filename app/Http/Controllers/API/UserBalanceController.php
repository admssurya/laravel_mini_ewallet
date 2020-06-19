<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserBalance\CreateUserBalanceRequest;
use App\Http\Requests\UserBalance\UpdateUserBalanceRequest;
use App\Services\UserBalanceService;
use App\Transformers\UserBalanceTransformer;
use Illuminate\Http\Request;

class UserBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserBalanceService $userBalanceService
     * @return array
     */
    public function index(UserBalanceService $userBalanceService)
    {
        $userBalances = $userBalanceService->getAll();

        return [
            'payload' => fractal($userBalances, new UserBalanceTransformer())->parseIncludes('user_balance_history')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserBalanceRequest $request
     * @param UserBalanceService $userBalanceService
     * @return array
     */
    public function store(CreateUserBalanceRequest $request, UserBalanceService $userBalanceService)
    {
        $userBalance = $userBalanceService->create($request);

        return [
            'payload' => fractal($userBalance, new UserBalanceTransformer())
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param UserBalanceService $userBalanceService
     * @return array
     * @throws \App\Exceptions\APIException
     */
    public function show($id, UserBalanceService $userBalanceService)
    {
        $userBalance = $userBalanceService->getById($id);

        return [
            'payload' => fractal($userBalance, new UserBalanceTransformer())->parseIncludes('user_balance_history')
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserBalanceRequest $request
     * @param int $id
     * @param UserBalanceService $userBalanceService
     * @return array
     */
    public function update(UpdateUserBalanceRequest $request, $id, UserBalanceService $userBalanceService)
    {
        $userBalance = $userBalanceService->update($request, $id);

        return [
            'payload' => fractal($userBalance, new UserBalanceTransformer())
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param UserBalanceService $userBalanceService
     * @return array
     */
    public function destroy($id, UserBalanceService $userBalanceService)
    {
        $userBalance = $userBalanceService->delete($id);

        return [
            'payload' => fractal($userBalance, new UserBalanceTransformer())
        ];
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Exceptions\APIException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserBalanceHistory\CreateUserBalanceHistoryRequest;
use App\Http\Requests\UserBalanceHistory\UpdateUserBalanceHistoryRequest;
use App\Services\UserBalanceHistoryService;
use App\Transformers\UserBalanceHistoryTransformer;

class UserBalanceHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserBalanceHistoryService $userBalanceHistoryService
     * @return array
     */
    public function index(UserBalanceHistoryService $userBalanceHistoryService)
    {
        $userBalanceHistories = $userBalanceHistoryService->getAll();

        return [
            'payload' => fractal($userBalanceHistories, new UserBalanceHistoryTransformer())
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserBalanceHistoryRequest $request
     * @param UserBalanceHistoryService $userBalanceHistoryService
     * @return array
     */
    public function store(CreateUserBalanceHistoryRequest $request, UserBalanceHistoryService $userBalanceHistoryService)
    {
        $userBalanceHistory = $userBalanceHistoryService->create($request);

        return [
            'payload' => fractal($userBalanceHistory, new UserBalanceHistoryTransformer())
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param UserBalanceHistoryService $userBalanceHistoryService
     * @return array
     * @throws APIException
     */
    public function show($id, UserBalanceHistoryService $userBalanceHistoryService)
    {
        $userBalanceHistory = $userBalanceHistoryService->getById($id);

        return [
            'payload' => fractal($userBalanceHistory, new UserBalanceHistoryTransformer())
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserBalanceHistoryRequest $request
     * @param int $id
     * @param UserBalanceHistoryService $userBalanceHistoryService
     * @return array
     */
    public function update(UpdateUserBalanceHistoryRequest $request, $id, UserBalanceHistoryService $userBalanceHistoryService)
    {
        $userBalanceHistory = $userBalanceHistoryService->update($request, $id);

        return [
            'payload' => fractal($userBalanceHistory, new UserBalanceHistoryTransformer())
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param UserBalanceHistoryService $userBalanceHistoryService
     * @return array
     */
    public function destroy($id, UserBalanceHistoryService $userBalanceHistoryService)
    {
        $userBalanceHistory = $userBalanceHistoryService->delete($id);

        return [
            'payload' => fractal($userBalanceHistory, new UserBalanceHistoryTransformer())
        ];
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Exceptions\APIException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BalanceBankHistory\CreateBalanceBankHistoryRequest;
use App\Http\Requests\BalanceBankHistory\UpdateBalanceBankHistoryRequest;
use App\Services\BalanceBankHistoryService;
use App\Transformers\BalanceBankHistoryTransformer;
use Illuminate\Http\Request;

class BalanceBankHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BalanceBankHistoryService $balanceBankHistoryService
     * @return array
     */
    public function index(BalanceBankHistoryService $balanceBankHistoryService)
    {
        $balanceBankHistories = $balanceBankHistoryService->getAll();

        return [
            'payload' => fractal($balanceBankHistories, new BalanceBankHistoryTransformer())
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBalanceBankHistoryRequest $request
     * @param BalanceBankHistoryService $balanceBankHistoryService
     * @return array
     */
    public function store(CreateBalanceBankHistoryRequest $request, BalanceBankHistoryService $balanceBankHistoryService)
    {
        $balanceBankHistory = $balanceBankHistoryService->create($request);

        return [
            'payload' => fractal($balanceBankHistory, new BalanceBankHistoryTransformer())
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param BalanceBankHistoryService $balanceBankHistoryService
     * @return array
     * @throws APIException
     */
    public function show($id, BalanceBankHistoryService $balanceBankHistoryService)
    {
        $balanceBankHistory = $balanceBankHistoryService->getById($id);

        return [
            'payload' => fractal($balanceBankHistory, new BalanceBankHistoryTransformer())
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBalanceBankHistoryRequest $request
     * @param int $id
     * @param BalanceBankHistoryService $balanceBankHistoryService
     * @return array
     */
    public function update(UpdateBalanceBankHistoryRequest $request, $id, BalanceBankHistoryService $balanceBankHistoryService)
    {
        $balanceBankHistory = $balanceBankHistoryService->update($request, $id);

        return [
            'payload' => fractal($balanceBankHistory, new BalanceBankHistoryTransformer())
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param BalanceBankHistoryService $balanceBankHistoryService
     * @return array
     */
    public function destroy($id, BalanceBankHistoryService $balanceBankHistoryService)
    {
        $balanceBankHistory = $balanceBankHistoryService->delete($id);

        return [
            'payload' => fractal($balanceBankHistory, new BalanceBankHistoryTransformer())
        ];
    }
}

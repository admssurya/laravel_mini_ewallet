<?php

namespace App\Http\Controllers\API;

use App\Exceptions\APIException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BalanceBank\CreateBalanceBankRequest;
use App\Http\Requests\BalanceBank\UpdateBalanceBankRequest;
use App\Services\BalanceBankService;
use App\Transformers\BalanceBankTransformer;

class BalanceBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BalanceBankService $balanceBankService
     * @return array
     */
    public function index(BalanceBankService $balanceBankService)
    {
        $balanceBanks = $balanceBankService->getAll();

        return [
            'payload' => fractal($balanceBanks, new BalanceBankTransformer())->parseIncludes('balance_bank_history')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBalanceBankRequest $request
     * @param BalanceBankService $balanceBankService
     * @return array
     */
    public function store(CreateBalanceBankRequest $request, BalanceBankService $balanceBankService)
    {
        $balanceBank = $balanceBankService->create($request);

        return [
            'payload' => fractal($balanceBank, new BalanceBankTransformer())->parseIncludes('balance_bank_history')
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param BalanceBankService $balanceBankService
     * @return array
     * @throws APIException
     */
    public function show($id, BalanceBankService $balanceBankService)
    {
        $balanceBank = $balanceBankService->getById($id);

        return [
            'payload' => fractal($balanceBank, new BalanceBankTransformer())->parseIncludes('balance_bank_history')
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBalanceBankRequest $request
     * @param int $id
     * @param BalanceBankService $balanceBankService
     * @return array
     */
    public function update(UpdateBalanceBankRequest $request, $id, BalanceBankService $balanceBankService)
    {
        $balanceBank = $balanceBankService->update($request, $id);

        return [
            'payload' => fractal($balanceBank, new BalanceBankTransformer())->parseIncludes('balance_bank_history')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param BalanceBankService $balanceBankService
     * @return array
     */
    public function destroy($id, BalanceBankService $balanceBankService)
    {
        $balanceBank = $balanceBankService->delete($id);

        return [
            'payload' => fractal($balanceBank, new BalanceBankTransformer())->parseIncludes('balance_bank_history')
        ];
    }
}

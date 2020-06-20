<?php

namespace App\Http\Controllers\API;

use App\Exceptions\APIException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TopUpRequest;
use App\Http\Requests\Transaction\TransferRequest;
use App\Services\TransactionService;
use App\Transformers\BalanceBankTransformer;
use App\Transformers\UserBalanceTransformer;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @param TopUpRequest $request
     * @param TransactionService $transactionService
     * @return array
     * @throws APIException
     */
    public function topUp(TopUpRequest $request, TransactionService $transactionService)
    {
        $topUp = $transactionService->topUp($request);

        return [
            "payload"   => (object) [
                'user_balance' => fractal($topUp['user_balance'], new UserBalanceTransformer())->parseIncludes('user_balance_history'),
                'balance_bank' => fractal($topUp['balance_bank'], new BalanceBankTransformer())->parseIncludes('balance_bank_history')
            ]
        ];
    }

    /**
     * @param TransferRequest $request
     * @param TransactionService $transactionService
     * @return array
     * @throws APIException
     */
    public function transfer(TransferRequest $request, TransactionService $transactionService)
    {
        $transfer = $transactionService->transfer($request);

        return [
            "payload"   => (object) [
                'user_balance' => fractal($transfer['user_balance'], new UserBalanceTransformer())->parseIncludes('user_balance_history'),
                'balance_bank' => fractal($transfer['balance_bank'], new BalanceBankTransformer())->parseIncludes('balance_bank_history')
            ]
        ];
    }

    public function balanceCheck(Request $request, TransactionService $transactionService)
    {
        $history = $transactionService->balanceCheck($request);

        return [
            "payload"   => (object) [
                'user_balance' => fractal($history['user_balance'], new UserBalanceTransformer())->parseIncludes('user_balance_history'),
                'balance_bank' => fractal($history['balance_bank'], new BalanceBankTransformer())->parseIncludes('balance_bank_history')
            ]
        ];
    }
}

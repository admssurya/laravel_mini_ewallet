<?php


namespace App\Services;


use App\Constants\TypeConstant;
use App\Exceptions\APIException;
use App\Models\BalanceBank;
use App\Models\UserBalance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected $userBalanceService;
    protected $userBalanceHistoryService;
    protected $balanceBankService;
    protected $balanceBankHistoryService;

    public function __construct(UserBalanceService $userBalanceService, UserBalanceHistoryService $userBalanceHistoryService, BalanceBankService $balanceBankService, BalanceBankHistoryService $balanceBankHistoryService)
    {
        $this->userBalanceService = $userBalanceService;
        $this->userBalanceHistoryService = $userBalanceHistoryService;
        $this->balanceBankService = $balanceBankService;
        $this->balanceBankHistoryService = $balanceBankHistoryService;
    }

    public function topUp(Request $request)
    {
        $lastUserBalance = UserBalance::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $lastBalanceBank = BalanceBank::orderBy('created_at','DESC')
            ->first();

        // validation
        if (!$lastBalanceBank) :
            throw new APIException('Balance Bank Empty');
        endif;

        if ($lastBalanceBank->balance < $request->get('amount')) :
            throw new APIException('Your Balance Not Enough');
        endif;

        if (!$lastBalanceBank->enable) :
            throw new APIException('Bank Not Available Right Now');
        endif;

        $balanceBeforeUserBalanceHistory = @$lastUserBalance->balance;
        $balanceAfterUserBalanceHistory = $balanceBeforeUserBalanceHistory + $request->get('amount');

        $balanceBeforeBalanceBankHistory = $lastBalanceBank->balance;
        $balanceAfterBalanceBankHistory = $balanceBeforeBalanceBankHistory - $request->get('amount');

        // fill user balance
        $fillUserBalance = $this->fillUserBalance($request, $balanceAfterUserBalanceHistory);
        // fill user balance history
        $fillUserBalanceHistory = $this->fillUserBalanceHistory($request, TypeConstant::DEBIT, $balanceBeforeUserBalanceHistory, $balanceAfterUserBalanceHistory);
        // fill balance bank
        $fillBalanceBank = $this->fillBalanceBank($request, $lastBalanceBank, $balanceAfterBalanceBankHistory);
        // fill balance bank history
        $fillBalanceBankHistory = $this->fillBalanceBankHistory($request, TypeConstant::CREDIT, $balanceBeforeBalanceBankHistory, $balanceAfterBalanceBankHistory);

        try {
            DB::beginTransaction();

            // create user balance
            $userBalance = $this->userBalanceService->create($fillUserBalance);

            // create user balance history
            $fillUserBalanceHistory->merge(['user_balance_id' => $userBalance->id]);
            $userBalanceHistory = $this->userBalanceHistoryService->create($fillUserBalanceHistory);

            // create balance bank
            $balanceBank = $this->balanceBankService->create($fillBalanceBank);

            // create balance bank history
            $fillBalanceBankHistory->merge(['balance_bank_id' => $balanceBank->id]);
            $balanceBankHistory = $this->balanceBankHistoryService->create($fillBalanceBankHistory);

            DB::commit();

            return [
                'user_balance'  => $userBalance,
                'balance_bank' => $balanceBank
            ];

        } catch (\Exception $ex) {
            DB::rollBack();
            throw new APIException($ex->getMessage());
        }
    }

    public function transfer(Request $request)
    {
        $lastUserBalance = UserBalance::orderBy('created_at', 'DESC')->first();
        $lastBalanceBank = BalanceBank::orderBy('created_at','DESC')->first();

        // validation
        if (!$lastUserBalance) :
            throw new APIException('User Balance Empty');
        endif;

        if ($lastUserBalance->balance < $request->get('amount')) :
            throw new APIException('Your Balance Not Enough');
        endif;

        $balanceBeforeUserBalanceHistory = @$lastUserBalance->balance;
        $balanceAfterUserBalanceHistory = $balanceBeforeUserBalanceHistory - $request->get('amount');

        $balanceBeforeBalanceBankHistory = $lastBalanceBank->balance;
        $balanceAfterBalanceBankHistory = $balanceBeforeBalanceBankHistory + $request->get('amount');

        // fill user balance
        $fillUserBalance = $this->fillUserBalance($request, $balanceAfterUserBalanceHistory);
        // fill user balance history
        $fillUserBalanceHistory = $this->fillUserBalanceHistory($request, TypeConstant::CREDIT, $balanceBeforeUserBalanceHistory, $balanceAfterUserBalanceHistory);
        // fill balance bank
        $fillBalanceBank = $this->fillBalanceBank($request, $lastBalanceBank, $balanceAfterBalanceBankHistory);
        // fill balance bank history
        $fillBalanceBankHistory = $this->fillBalanceBankHistory($request, TypeConstant::DEBIT, $balanceBeforeBalanceBankHistory, $balanceAfterBalanceBankHistory);

        try {
            DB::beginTransaction();

            // create user balance
            $userBalance = $this->userBalanceService->create($fillUserBalance);

            // create user balance history
            $fillUserBalanceHistory->merge(['user_balance_id' => $userBalance->id]);
            $userBalanceHistory = $this->userBalanceHistoryService->create($fillUserBalanceHistory);

            // create balance bank
            $balanceBank = $this->balanceBankService->create($fillBalanceBank);

            // create balance bank history
            $fillBalanceBankHistory->merge(['balance_bank_id' => $balanceBank->id]);
            $balanceBankHistory = $this->balanceBankHistoryService->create($fillBalanceBankHistory);

            DB::commit();

            return [
                'user_balance'  => $userBalance,
                'balance_bank' => $balanceBank
            ];

        } catch (\Exception $ex) {
            DB::rollBack();
            throw new APIException($ex->getMessage());
        }
    }

    public function fillUserBalance(Request $request, $balanceAfterUserBalanceHistory)
    {
        // fill User Balance
        $fillUserBalance = new Request();
        $fillUserBalance->merge([
            'balance' => $balanceAfterUserBalanceHistory,
            'balance_achieve' => $request->get('amount')
        ]);

        return $fillUserBalance;
    }

    public function fillUserBalanceHistory(Request $request, $type, $balanceBeforeUserBalanceHistory, $balanceAfterUserBalanceHistory)
    {
        // fill User Balance History
        $fillUserBalanceHistory = new Request();
        $fillUserBalanceHistory->merge([
            'balance_before' => $balanceBeforeUserBalanceHistory,
            'balance_after' => $balanceAfterUserBalanceHistory,
            'activity' => $request->get('activity'),
            'type' => $type,
            'ip' => $request->get('ip'),
            'location' => $request->get('location'),
            'user_agent' => $request->get('user_agent'),
            'author' => $request->get('author')
        ]);

        return $fillUserBalanceHistory;
    }

    public function fillBalanceBank(Request $request, Model $lastBalanceBank, $balanceAfterBalanceBankHistory)
    {
        // fill balance bank
        $fillBalanceBank = new Request();
        $fillBalanceBank->merge([
            'balance' => $balanceAfterBalanceBankHistory,
            'balance_achieve' => $request->get('amount'),
            'code' => $request->get('code') ?: $lastBalanceBank->code,
            'enable' => $lastBalanceBank->enable
        ]);

        return $fillBalanceBank;
    }

    public function fillBalanceBankHistory(Request $request, $type, $balanceBeforeBalanceBankHistory, $balanceAfterBalanceBankHistory)
    {
        $fillBalanceBankHistory = new Request();
        $fillBalanceBankHistory->merge([
            'balance_before' => $balanceBeforeBalanceBankHistory,
            'balance_after' => $balanceAfterBalanceBankHistory,
            'activity' => $request->get('activity'),
            'type' => $type,
            'ip' => $request->get('ip'),
            'location' => $request->get('location'),
            'user_agent' => $request->get('user_agent'),
            'author' => $request->get('author')
        ]);

        return $fillBalanceBankHistory;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function balanceCheck(Request $request)
    {
        $userBalance = UserBalance::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $balanceBank = BalanceBank::orderBy('created_at', 'DESC')
            ->first();

        return [
            'user_balance'  => $userBalance,
            'balance_bank' => $balanceBank
        ];
    }
}

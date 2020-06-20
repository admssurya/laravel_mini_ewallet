<?php


namespace App\Services;


use App\Constants\TypeConstant;
use App\Exceptions\APIException;
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
        $balanceBanks = collect($this->balanceBankService->getAll());
        $userBalances = collect($this->userBalanceService->getAll());

        $lastBalanceBank = $balanceBanks->sortBy('created_at')->last();
        $lastUserBalance = $userBalances->sortBy('created_at')->last();

        // validation
        if (!$balanceBanks) :
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

        // fill User Balance
        $fillUserBalance = new Request();
        $fillUserBalance->merge([
            'balance' => $balanceAfterUserBalanceHistory,
            'balance_achieve' => $request->get('amount')
        ]);

        // fill User Balance History
        $fillUserBalanceHistory = new Request();
        $fillUserBalanceHistory->merge([
            'balance_before' => $balanceBeforeUserBalanceHistory,
            'balance_after' => $balanceAfterUserBalanceHistory,
            'activity' => $request->get('activity'),
            'type' => TypeConstant::DEBIT,
            'ip' => $request->get('ip'),
            'location' => $request->get('location'),
            'user_agent' => $request->get('user_agent'),
            'author' => $request->get('author')
        ]);

        $balanceBeforeBalanceBankHistory = $lastBalanceBank->balance;
        $balanceAfterBalanceBankHistory = $balanceBeforeBalanceBankHistory - $request->get('amount');

        // fill balance bank
        $fillBalanceBank = new Request();
        $fillBalanceBank->merge([
            'balance' => $balanceAfterBalanceBankHistory,
            'balance_achieve' => $request->get('amount'),
            'code' => $lastBalanceBank->code,
            'enable' => $lastBalanceBank->enable
        ]);

        // fill balance bank history
        $fillBalanceBankHistory = new Request();
        $fillBalanceBankHistory->merge([
            'balance_before' => $balanceBeforeBalanceBankHistory,
            'balance_after' => $balanceAfterBalanceBankHistory,
            'activity' => $request->get('activity'),
            'type' => TypeConstant::CREDIT,
            'ip' => $request->get('ip'),
            'location' => $request->get('location'),
            'user_agent' => $request->get('user_agent'),
            'author' => $request->get('author')
        ]);

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

    }
}

<?php


namespace App\Services;


use App\Models\BalanceBankHistory;
use Illuminate\Http\Request;

class BalanceBankHistoryService extends AbstractBaseService
{
    private $balanceBankService;

    public function __construct(BalanceBankHistory $balanceBankHistory, BalanceBankService $balanceBankService)
    {
        $this->model = $balanceBankHistory;
        $this->balanceBankService = $balanceBankService;
    }

    public function create(Request $request)
    {
        $this->model->balanceBank()->associate($this->balanceBankService->getById($request->input('balance_bank_id')));
        return parent::create($request); // TODO: Change the autogenerated stub
    }

    public function update(Request $request, $id)
    {
        return parent::update($request, $id); // TODO: Change the autogenerated stub
    }
}

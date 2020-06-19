<?php

namespace App\Http\Requests\BalanceBankHistory;

use App\Constants\TypeConstant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBalanceBankHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'balance_bank_id' => 'required',
            'balance_before' => 'required',
            'balance_after' => 'required',
            'activity' => 'required',
            'type' => 'required|in:'.TypeConstant::CREDIT.','.TypeConstant::DEBIT,
            'ip' => 'required',
            'location' => 'required',
            'user_agent' => 'required',
            'author' => 'required'
        ];
    }
}

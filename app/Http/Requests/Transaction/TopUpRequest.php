<?php

namespace App\Http\Requests\Transaction;

use App\Constants\TypeConstant;
use Illuminate\Foundation\Http\FormRequest;

class TopUpRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'activity' => 'required',
            'ip' => 'required',
            'location' => 'required',
            'user_agent' => 'required',
            'author' => 'required'
        ];
    }
}

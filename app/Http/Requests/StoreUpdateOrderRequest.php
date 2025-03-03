<?php

namespace App\Http\Requests;

use App\Rules\DateRequestRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        $rules = [
            'destiny'  => ['required', 'min:3', 'max:255', 'unique:orders'],
            'going_date' => ['required', 'min:1', 'max:10', 'unique:orders', new DateRequestRule],
            'back_date' => ['required', 'min:1', 'max:10', new DateRequestRule],
            'status' => 'required',
            'id_user' => 'required'
        ];

        if ($this->method() === 'PUT') {
            $rules['destiny'] = [
                'required',
                'min:3',
                'max:255',
                Rule::unique('orders')->ignore($this->orders ?? $this->id),
            ];
            $rules['going_date'] = [
                'required',
                'min:1',
                'max:10',
                Rule::unique('orders')->ignore($this->orders ?? $this->id),
                new DateRequestRule,
            ];
            $rules['back_date'] = [
                'required',
                'min:1',
                'max:10',
                Rule::unique('orders')->ignore($this->orders ?? $this->id),
                new DateRequestRule,
            ];
        }
        return $rules;
    }
}

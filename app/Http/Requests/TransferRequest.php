<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'from_wallet_id' => 'required|integer|exists:wallets,id|different:to_wallet_id',
            'to_wallet_id' => 'required|integer|exists:wallets,id',
            'amount' => 'required|integer|min:1',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->header('Idempotency-Key')) {
            abort(422, 'Idempotency-Key header is required');
        }
    }
}

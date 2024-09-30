<?php

namespace App\Http\Requests\Payment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClosedTransactionRequest extends FormRequest
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
            'method' => 'required|string',
            'merchant_ref' => 'required',
            'amount' => 'required|numeric|min:0',
            'customer_name' => 'required|string',
            'customer_email' => 'required|string',
            'customer_phone' => 'required|numeric|min:8',
            'order_items' => 'required',
            'sku' => 'required',
            'premium_name' => 'required',
            'qty' => 'required',
            'price' => 'nullable',
            'subtotal' => 'nullable',
            'product_url' => 'nullable',
            'return_url' => 'nullable',
            'expired_time' => 'nullable',
            'signature' => 'required|string',
            'tax' => 'sometimes|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'method.required' => 'Metode pembayaran harus diisi',
            'merchant_ref.required' => 'Merchant reference harus diisi',
            'amount.required' => 'Harga harus diisi',
            'amount.numeric' => 'Harga harus berupa number',
            'amount.min' => 'Harga tidak boleh kurang dari 0',
            'customer_name.required' => 'Nama pembeli harus diisi',
            'customer_email.required' => 'Email pembeli harus diisi',
            'customer_phone.required' => 'Nomor telefon pembeli harus diisi',
            'customer_phone.numeric' => 'Forma tomor telefon pembeli harus berupa angka',
            'customer_phone.min' => 'Format omor telefon pembeli harus lebih dari 8 angka',
            'order_items.required' => 'Detail item harus diisi',
            'sku.required' => 'SKU item harus diisi',
            'premium_name.required' => 'Nama item harus diisi',
            'qty.required' => 'Jumlah item harus diisi',
        ];
    }

    public function prepareForValidation()
    {
        if(!$this->signature) $this->merge(['signature' => '-']);
        if(!$this->merchant_ref) $this->merge(['merchant_ref' => '-']);
        if(!$this->customer_phone) $this->merge(['customer_phone' => $this->phone ?? '00000000']);
        if(!$this->amount) $this->merge(['amount' => 0]);
        if($this->order_items) {
            $price = 0;
            if (strtolower($this->sku) == 'prem-smt') $price = 149999;
            else if (strtolower($this->sku) == 'prem-thn') $price = 279999;
            else if (strtolower($this->sku) == 'prem-bln') $price = 29999;

            $this->merge([
                'order_items' => [
                    [
                        'sku' => $this->sku,
                        'name' => $this->premium_name,
                        'quantity' => $this->qty,
                        'price' => $price,
                        'product_url' => '-',
                        'image_url' => '-'
                    ]
                ],
                'amount' => $price * $this->qty
            ]);
        }
    }

    public function failedValidation(Validator $validator)
    {
        if($this->type == "mobile"){
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Invalid request, please check again',
                'data'    => $validator->errors()
            ], 422));
        } else {
            return redirect()->back()->withError($validator)->withInput();
        }
    }
}

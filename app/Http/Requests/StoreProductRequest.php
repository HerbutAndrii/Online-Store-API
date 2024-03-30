<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
            'name' => ['string', 'required'],
            'description' => ['string', 'required'],
            'price' => ['numeric', 'required'],
            'company' => ['numeric', 'exists:companies,id', 'required'],
            'category' => ['numeric', 'exists:categories,id', 'required'],
        ];
    }

    protected function passedValidation()
    {
        if(! $this->user()->hasCompany($this->company)) {
            return abort(403, 'You are not the owner of the company');
        }
    }

    protected function failedValidation(Validator $validator) 
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}

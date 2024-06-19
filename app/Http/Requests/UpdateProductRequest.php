<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'name' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
            'price' => ['numeric', 'nullable'],
            'company_id' => ['numeric', 'exists:companies,id', 'nullable'],
            'category_id' => ['numeric', 'exists:categories,id', 'nullable'],
            'tags' => ['array', 'nullable'],
        ];
    }

    protected function passedValidation()
    {
        if($this->company_id && ! $this->user()->hasCompany($this->company_id)) {
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

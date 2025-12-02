<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CriarDenunciaRequest extends FormRequest
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
            'denuncia' => 'required|string|max:1000',
            //'senha' => 'required|string|max:20',
            'departamentos_id' => 'required',
            'anexos.*' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'denuncia.required' => 'Obrigatório campo denuncia.',
           // 'senha.required' => 'Obrigatório campo senha.',
            'departamentos_id.required' => 'Obrigatório campo departamentos id.',

            //'anexos.*' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erro de validação',
            'errors' => $validator->errors()
        ], 422));
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Gate;

class CriarUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('permission-adm');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|max:255',
            'name' => 'required|max:256',
            'login' => 'required|unique:users|max:50',
            'is_admin' => 'boolean',
            'enable' => 'boolean',
            'departamentos_id' => 'required|string'
        ];
    }

    public function messages()
    {
        return[
            'email.required' => 'Obrigatório campo email.',
            'password.required' => 'Obrigatório campo password.',
            'name.required' => 'Obrigatório campo name.',
            'login.required' => 'Obrigatório campo login.',
            'departamentos_id.required' => 'Obrigatório campo departamentos_id.',
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

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "message" => "Usuário não tem permissão"
        ], 403));
    }
}

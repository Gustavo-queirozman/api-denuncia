<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Validation\Validator;

class EditarUsuarioRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            //'password' => 'required|string|min:8',
            'is_admin' => 'boolean',
            'enable' => 'boolean',
            'departamentos_id' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Obrigatório campo name.',
            'email.required' => 'Obrigatório campo email.',
           // 'password.required' => 'Obrigatório campo password.',
            'is_admin.boolean' => 'Obrigatório campo is admin ser do tipo boolean.',
            'enable.boolean' => 'Obrigatório campo enable ser do tipo boolean.',
            'departamentos_id' => 'Obrigatório campo departamento ser do tipo boolean.',
        ];
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "message" => "Usuário não tem permissão"
        ], 403));
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

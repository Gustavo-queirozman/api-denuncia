<?php

namespace App\Http\Requests;

use App\Rules\DenunciaExiste;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CriarRespostaRequest extends FormRequest
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
            'protocolo' => 'required|exists:denuncias,protocolo',
            //'senha' => ['required', new DenunciaExiste($this->protocolo, $this->senha)],
            'resposta' => 'required'
        ];
    }

    public function messages(){
        return [
            'protocolo.required' => 'Obrigatório campo protocolo.',
            'protocolo.exists' => 'Esse protocolo não existe.',
            'senha.required' => 'Obrigatório campo senha.',
            'resposta.required' => 'Obrigatório campo resposta.',
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

<?php

namespace App\Rules;

use App\Models\Denuncia;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class DenunciaExiste implements ValidationRule
{
    protected $protocolo;
    protected $senha;


    public function __construct($protocolo, $senha)
    {
        $this->protocolo = $protocolo;
        $this->senha = $senha;
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $denuncia = Denuncia::where('protocolo', $this->protocolo)->first();

        if (!$denuncia || !Hash::check($this->senha, $denuncia->senha)) {
            $fail('Senha inválida.');
        }

        request()->merge(['denuncia' => $denuncia]);
    }
}

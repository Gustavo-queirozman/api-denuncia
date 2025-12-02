<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Resposta;

class Denuncia extends Model
{
    use HasFactory;

    protected $table = 'denuncias';

    protected $fillable = [
        'denuncia',
        'status_id',
        'protocolo',
        'senha',
        'departamentos_id',
        'user_status'
    ];

    protected $hidden= ['senha'];

    public $timestamp = true;

    // Adiciona mutator para atributos específicos, como a senha
    public function setSenhaAttribute($value)
    {
        // Verifique se a senha precisa ser rehash
        if (Hash::needsRehash($value)) {
            $this->attributes['senha'] = Hash::make($value);
        } else {
            $this->attributes['senha'] = $value;
        }
    }

    // Mapeia a senha para a coluna 'senha'
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class, 'denuncias_id', 'id'); 
    }

  

    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'denuncias_id'); 
    }

}

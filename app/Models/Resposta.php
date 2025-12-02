<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Denuncia;

class Resposta extends Model
{
    use HasFactory;

    protected $table = 'respostas';

    protected $fillable = [
        'protocolo',
        'senha',
        'resposta',
        'users_id',
        'denuncias_id'
    ];

    public $timestamp = true;

    public function denuncia()
{
    return $this->belongsTo(Denuncia::class, 'denuncias_id'); 
}
}

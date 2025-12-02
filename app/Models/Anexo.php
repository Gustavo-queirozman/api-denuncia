<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $table = 'anexos';

    protected $fillable = [
        'nome_anexo',
        'denuncias_id'
    ];

    public $timestamp = true;

    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class, 'denuncias_id', 'id');
    }
}

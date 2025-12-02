<?php

namespace App\Repository;

use App\Models\Denuncia;
use App\Repository\Contract\RespostasIRepository;

class RespostasRepository  implements RespostasIRepository{
    
    public function getRespostasByDenunciaProtocolo($protocolo){
        return Denuncia::where('protocolo', $protocolo)
        ->with('respostas:id,denuncias_id,resposta')
        ->first();
    }
}
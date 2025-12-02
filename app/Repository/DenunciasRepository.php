<?php

namespace App\Repository;

use App\Models\Denuncia;
use App\Repository\Contract\DenunciasIRepository;

class DenunciasRepository  implements DenunciasIRepository
{

    public function getAllDenuncias($id)
    {
        return Denuncia::where('departamentos_id', '!=', $id)->get();
    }

    public function getDenunciaById($id)
    {
        return Denuncia::where('id', $id)->first();
    }

    public function getDenunciaByProtocolo($protocolo)
    {
        return Denuncia::where('protocolo', $protocolo)->first();
    }

    public function getDenunciaAndAnexos($protocolo)
    {
        return Denuncia::where('protocolo', $protocolo)
            ->with('anexos:id,denuncias_id,nome_anexo')
            ->first();
    }
}

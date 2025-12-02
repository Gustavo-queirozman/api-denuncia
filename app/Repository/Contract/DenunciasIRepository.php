<?php

namespace App\Repository\Contract;

interface DenunciasIRepository {
    public function getDenunciaById($id);
    public function getDenunciaByProtocolo($protocolo);
    public function getAllDenuncias($id);
    public function getDenunciaAndAnexos($protocolo);
}
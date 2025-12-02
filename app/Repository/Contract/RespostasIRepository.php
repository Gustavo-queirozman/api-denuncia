<?php

namespace App\Repository\Contract;

interface RespostasIRepository {
    public function getRespostasByDenunciaProtocolo($protocolo);
}
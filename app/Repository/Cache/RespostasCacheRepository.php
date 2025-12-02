<?php

namespace App\Repository\Cache;

use App\Repository\Contract\RespostasIRepository;
use App\Repository\RespostasRepository;
use Illuminate\Cache\CacheManager;

class RespostasCacheRepository implements RespostasIRepository{
    protected $repo;
    protected $cache;

    const TTL_ONE_DAY = 1440; # 1 day
    const TTL_SIX_HOUR = 360; # 6 Hour
    const TTL_ONE_MINUTES = 1; # 1 minutoes

    public function __construct(CacheManager $cache, RespostasRepository $repo)
    { 
        $this->cache = $cache;
        $this->repo = $repo;
    }

    public function getRespostasByDenunciaProtocolo($protocolo){
        return $this->cache->remember('get-all-respostas-denuncia-protocolo-'.$protocolo, self::TTL_ONE_DAY, function () use($protocolo) {
            return $this->repo->getRespostasByDenunciaProtocolo($protocolo);
        });
    }
}
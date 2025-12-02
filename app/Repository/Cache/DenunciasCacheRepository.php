<?php

namespace App\Repository\Cache;

use App\Repository\Contract\DenunciasIRepository;
use App\Repository\DenunciasRepository;
use Illuminate\Cache\CacheManager;

class DenunciasCacheRepository implements DenunciasIRepository{
    protected $repo;
    protected $cache;

    const TTL_ONE_DAY = 1440; # 1 day
    const TTL_SIX_HOUR = 360; # 6 Hour
    const TTL_ONE_MINUTES = 1; # 1 minutoes

    public function __construct(CacheManager $cache, DenunciasRepository $repo)
    { 
        $this->cache = $cache;
        $this->repo = $repo;
    }

    public function getAllDenuncias($id){
        return $this->cache->remember('get-all-denuncias-departamento', self::TTL_ONE_DAY, function () use($id) {
            return $this->repo->getAllDenuncias($id);
        });
    }

    public function getDenunciaById($id){
        return $this->cache->remember('get-by-denuncia-id-'.$id, self::TTL_ONE_DAY, function () use($id) {
            return $this->repo->getDenunciaById($id);
        });
    }

    public function getDenunciaByProtocolo($protocolo)
    {
        return $this->cache->remember('get-by-denuncia-protocolo-'.$protocolo, self::TTL_ONE_DAY, function () use($protocolo)  {
            return $this->repo->getDenunciaByProtocolo($protocolo);
        });
    }

    public function getDenunciaAndAnexos($protocolo){
        return $this->cache->remember('get-denuncia-and-anexos-protocolo-'.$protocolo, self::TTL_ONE_DAY, function () use($protocolo)  {
            return $this->repo->getDenunciaAndAnexos($protocolo);
        });
    }
}
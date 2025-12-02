<?php

namespace App\Repository\Cache;

use App\Repository\Contract\UsuariosIRepository;
use App\Repository\UsuariosRepository;
use Illuminate\Cache\CacheManager;

class UsuariosCacheRepository implements UsuariosIRepository{
    protected $repo;
    protected $cache;

    const TTL_ONE_DAY = 1440; # 1 day
    const TTL_SIX_HOUR = 360; # 6 Hour
    const TTL_ONE_MINUTES = 1; # 1 minutoes

    public function __construct(CacheManager $cache, UsuariosRepository $repo)
    { 
        $this->cache = $cache;
        $this->repo = $repo;
    }

    public function getUserById($id)
    {
        return $this->cache->remember('get-by-user-'.$id, self::TTL_ONE_DAY, function () use ($id)  {
            return $this->repo->getUserById($id);
        });
    }

    public function getAllUsers(){
        return $this->cache->remember('get-all-users', self::TTL_ONE_DAY, function ()  {
            return $this->repo->getAllUsers();
        });
    }
}
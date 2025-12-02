<?php

namespace App\Providers;

use App\Models\User;
use App\Repository\Cache\DenunciasCacheRepository;
use App\Repository\Cache\UsuariosCacheRepository;
use App\Repository\Cache\RespostasCacheRepository;
use App\Repository\Contract\DenunciasIRepository;
use App\Repository\Contract\UsuariosIRepository;
use App\Repository\Contract\RespostasIRepository;
use App\Repository\UsuariosRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API de Denúncias",
 *     version="1.0",
 *     description="Documentação da API para gerenciamento de denúncias.",
 *     @OA\Contact(
 *         email="suporte@seudominio.com"
 *     )
 * )
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsuariosIRepository::class, UsuariosCacheRepository::class);
        $this->app->bind(DenunciasIRepository::class, DenunciasCacheRepository::class);
        $this->app->bind(RespostasIRepository::class, RespostasCacheRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::define('permission-adm', function (User $user) {

            return Auth::user()->is_admin === 1;
        });
    }
}

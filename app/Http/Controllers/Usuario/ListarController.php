<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Requests\ListarUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Repository\Contract\UsuariosIRepository;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class ListarController
{
    use AsAction;

    private $repo_user;

    public function __construct(UsuariosIRepository $repo_user)
    {
        $this->repo_user = $repo_user;
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     summary="Lista todos os usuários registrados",
     *     description="Retorna uma lista de todos os usuários cadastrados no sistema.",
     *     operationId="Usuario/ListarController",
     *     tags={"Usuários"},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários retornada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="login", type="string", example="gustavo.queiroz"),
     *                     @OA\Property(property="email", type="string", example="suporteti3@unimednoroesteminas.coop.br"),
     *                     @OA\Property(property="name", type="string", example="Gustavodd Queiroz"),
     *                     @OA\Property(property="is_admin", type="integer", example=1),
     *                     @OA\Property(property="enable", type="integer", example=1),
     *                     @OA\Property(property="departamentos_id", type="integer", example=1),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-16T03:27:16.000000Z"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-13T11:44:10.000000Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function __invoke(ListarUsuarioRequest $request)
    {
        $data = $this->repo_user->getAllUsers();
        return  new UsuarioResource($data);
    }
}

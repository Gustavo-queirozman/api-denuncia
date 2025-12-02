<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Resources\UsuarioResource;
use App\Repository\Contract\UsuariosIRepository;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class ExcluirController
{
    use AsAction;

    private $repo_user;

    public function __construct(UsuariosIRepository $repo_user)
    {
        $this->repo_user = $repo_user;
    }
    /**
     * @OA\Post(
     *     path="/api/usuario",
     *     summary="Cria um novo usuário",
     *     description="Cria um novo usuário e retorna os dados cadastrados.",
     *     operationId="Usuario/ExcluirController",
     *     tags={"Usuários"},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=10)
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="login", type="string", example="dd.queiroz"),
     *                 @OA\Property(property="email", type="string", format="email", example="dd@dsd.coop.br"),
     *                 @OA\Property(property="name", type="string", example="Gustavo Queiroz"),
     *                 @OA\Property(property="is_admin", type="integer", example=1),
     *                 @OA\Property(property="enable", type="integer", example=1),
     *                 @OA\Property(property="departamentos_id", type="integer", example=1),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-15T21:43:22.000000Z"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-15T21:43:22.000000Z")
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação - Campos obrigatórios ausentes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Erro de validação"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="id", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo id.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function __invoke(Request $request)
    {
        $usuario = $this->repo_user->getUserById($request['id']);
        $usuario->delete();
        return  new UsuarioResource($usuario);
    }
}

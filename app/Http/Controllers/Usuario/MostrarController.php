<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Resources\UsuarioResource;
use App\Repository\Contract\UsuariosIRepository;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class MostrarController
{
    use AsAction;

    private $repo_user;

    public function __construct(UsuariosIRepository $repo_user)
    {
        $this->repo_user = $repo_user;
    }

    /**
     * @OA\Get(
     *     path="/api/usuario",
     *     summary="Exibe o usuário que está logado.",
     *     description="Retorna os detalhes de um usuário.",
     *     operationId="getUser",
     *     tags={"Usuários"},
     * 
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Usuário encontrado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=6),
     *                 @OA\Property(property="login", type="string", example="teste2.queiroz"),
     *                 @OA\Property(property="email", type="string", example="gggg@unimednoroesteminas.coop.br"),
     *                 @OA\Property(property="name", type="string", example="Gustavo-kljkjkj"),
     *                 @OA\Property(property="is_admin", type="integer", example=1),
     *                 @OA\Property(property="enable", type="integer", example=1),
     *                 @OA\Property(property="departamentos_id", type="integer", example=1),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-16T13:31:15.000000Z"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-14T14:18:28.000000Z")
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuário não encontrado")
     *         )
     *     )
     * )
     */

    public function __invoke()
    {
        $id = Auth::check()? Auth::user()->id : null;
        $data = $this->repo_user->getUserById($id);
        return new UsuarioResource($data);
    }
}

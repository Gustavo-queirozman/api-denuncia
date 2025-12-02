<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Requests\EditarUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Repository\Contract\UsuariosIRepository;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class EditarController
{
    use AsAction;

    private $repo_user;

    public function __construct(UsuariosIRepository $repo_user)
    {
        $this->repo_user = $repo_user;
    }



    /**
     * @OA\Post(
     *     path="/api/usuario/{id}",
     *     summary="Atualiza um usuário.",
     *     description="Atualiza os dados de um usuário específico com base no ID fornecido.",
     *     operationId="Usuario/EditarController",
     *     tags={"Usuários"},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário a ser atualizado",
     *         @OA\Schema(type="integer", example=6)
     *     ),
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "is_admin", "enable", "departamentos_id"},
     *             @OA\Property(property="name", type="string", example="Gustavo-kljkjkj"),
     *             @OA\Property(property="email", type="string", format="email", example="gggg@unimednoroesteminas.coop.br"),
     *             @OA\Property(property="is_admin", type="integer", example=1),
     *             @OA\Property(property="enable", type="integer", example=1),
     *             @OA\Property(property="departamentos_id", type="integer", example=1)
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=6),
     *                 @OA\Property(property="name", type="string", example="Gustavo-kljkjkj"),
     *                 @OA\Property(property="email", type="string", format="email", example="gggg@unimednoroesteminas.coop.br"),
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
     *         response=422,
     *         description="Erro de validação - Campos obrigatórios ausentes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Erro de validação"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo name.")
     *                 ),
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo email.")
     *                 )
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
     *             @OA\Property(property="message", type="string", example="Usuário não encontrado.")
     *         )
     *     )
     * )
     */



    public function __invoke(EditarUsuarioRequest $request, $id)
    {
        $usuario = $this->repo_user->getUserById($id);


        if (!$usuario) {
            return response()->json([
                "success" => false,
                "error" => "Usuário não encontrado."
            ], 404);
        }

        /*$usuario = User::find($id);
            if (!$usuario) {
                return response()->json([
                    "success" => false,
                    "error" => "Usuário não encontrado."
                ], 404);
            }*/


        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        //$usuario->password = bcrypt($request->input('password'));
        $usuario->is_admin = $request->input('is_admin', false);
        $usuario->enable = $request->input('enable');
        $usuario->departamentos_id = $request->input('departamentos_id');
        $usuario->save();

        return  new UsuarioResource($usuario);
    }
}

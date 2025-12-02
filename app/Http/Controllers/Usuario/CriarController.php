<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Requests\CriarUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class CriarController
{
    use AsAction;

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registra um novo usuário",
     *     description="Cria um novo usuário e retorna um token de autenticação junto com os dados do usuário.",
     *     operationId="register",
     *     tags={"Usuários"},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "login", "departamentos_id"},
     *             @OA\Property(property="name", type="string", example="Daniel Queiroz"),
     *             @OA\Property(property="email", type="string", format="email", example="daniel.queiroz@email.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *             @OA\Property(property="login", type="string", example="daniel.queiroz"),
     *             @OA\Property(property="departamentos_id", type="integer", example=1)
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Usuário registrado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."),
     *                 @OA\Property(property="user", type="string", example="dd.queiroz")
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação - Campos obrigatórios ausentes ou já cadastrados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Erro de validação"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo email.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo password.")
     *                 ),
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo name.")
     *                 ),
     *                 @OA\Property(property="login", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo login.")
     *                 ),
     *                 @OA\Property(property="departamentos_id", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo departamentos_id.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(CriarUsuarioRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $input['login'];
        return new UsuarioResource($success);
    }
}

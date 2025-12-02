<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Resources\DenunciaResource;
use App\Repository\Contract\DenunciasIRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class EditarController
{
    use AsAction;

    private $repo_denuncia;

    public function __construct(DenunciasIRepository $repo_denuncia)
    {
        $this->repo_denuncia = $repo_denuncia;
    }

    /**
 * @OA\Post(
 *     path="/api/denuncia/{id}",
 *     summary="Atualiza o status de uma denúncia",
 *     description="Atualiza o status de uma denúncia com base no ID",
 *     operationId="updateDenunciaStatus",
 *     tags={"Denúncias"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID da denúncia",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="status_id", type="integer", example=1)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operação realizada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="protocolo", type="string", example="20250213170258650"),
 *                 @OA\Property(property="user_status", type="integer", example=6),
 *                 @OA\Property(property="departamentos_id", type="integer", example=1),
 *                 @OA\Property(property="status_id", type="integer", example=1),
 *                 @OA\Property(property="denuncia", type="string", example="gustavo"),
 *                 @OA\Property(property="created_at", type="string", example="2025-02-13T17:14:59.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", example="2025-02-16T12:57:24.000000Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro ao processar a solicitação",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Erro na requisição")
 *         )
 *     )
 * )
 */

 
    public function __invoke(Request $request, $id)
    {
        $denuncia = $this->repo_denuncia->getDenunciaById($request['id']);
        $denuncia->status_id = $request->input('status_id');
        $denuncia->user_status = (Auth::check()) ? Auth::user()->id : null;
        $denuncia->save();
        return new DenunciaResource($denuncia);
    }
}

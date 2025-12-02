<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Requests\MostrarDenunciaRequest;
use App\Http\Resources\DenunciaResource;
use App\Repository\Contract\DenunciasIRepository;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class MostrarController
{
    use AsAction;

    private $repo_denuncia;

    public function __construct(DenunciasIRepository $repo_denuncia)
    {
        $this->repo_denuncia = $repo_denuncia;
    }

    /**
     * @OA\Get(
     *     path="/api/denuncia",
     *     summary="Mostra a denúncia",
     *     description="Mostra a denúncia e retorna os detalhes da denúncia registrada.",
     *     operationId="denuncia",
     *     tags={"Denúncias"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"protocolo"},
     *             @OA\Property(property="protocolo", type="string", example="20250213150250265"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Denúncia registrada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="protocolo", type="string", example="20250213150250265"),
     *                 @OA\Property(property="user_status", type="string", example="6"),
     *                 @OA\Property(property="departamentos_id", type="integer", example=1),
     *                 @OA\Property(property="status_id", type="integer", example=2),
     *                 @OA\Property(property="denuncia", type="string", example="gustavo"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-13T15:02:50.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-16T03:30:06.000000Z"),
     *                 @OA\Property(property="anexos", type="array", @OA\Items(type="string"))
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
     *                 @OA\Property(property="protocolo", type="array",
     *                     @OA\Items(type="string", example="Obrigatório campo protocolo.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function __invoke(MostrarDenunciaRequest $request)
    {
        $data = $this->repo_denuncia->getDenunciaAndAnexos($request['protocolo']);
        return new DenunciaResource($data);
    }
}

<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListarRespostasRequest;
use App\Http\Resources\RespostaResource;
use App\Models\Denuncia;
use App\Models\Resposta;
use App\Repository\Contract\RespostasIRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class ListarController
{
    use AsAction;

    private $repo_resposta;

    public function __construct(RespostasIRepository $repo_resposta)
    {
        $this->repo_resposta = $repo_resposta;
    }

    /**
     * @OA\Get(
     *     path="/api/respostas",
     *     summary="Obter respostas de uma denúncia",
     *     description="Retorna as respostas associadas a uma denúncia pelo protocolo",
     *     operationId="getRespostasByProtocolo",
     *     tags={"Respostas"},
     *     @OA\Parameter(
     *         name="protocolo",
     *         in="query",
     *         description="Protocolo da denúncia",
     *         required=true,
     *         @OA\Schema(type="string", example="20250213150250265")
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
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="protocolo", type="string", example="20250213150250265"),
     *                 @OA\Property(property="user_status", type="string", example="6"),
     *                 @OA\Property(property="departamentos_id", type="integer", example=1),
     *                 @OA\Property(property="status_id", type="integer", example=2),
     *                 @OA\Property(property="denuncia", type="string", example="gustavo"),
     *                 @OA\Property(property="created_at", type="string", example="2025-02-13T15:02:50.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-02-16T03:30:06.000000Z"),
     *                 @OA\Property(
     *                     property="respostas",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="denuncias_id", type="integer", example=1),
     *                         @OA\Property(property="resposta", type="string", example="asdasdasd asdsad assda as asdas asdsa assa asdssa assa assa")
     *                     )
     *                 )
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

    public function __invoke(ListarRespostasRequest $request)
    {
        $data = $this->repo_resposta->getRespostasByDenunciaProtocolo($request['protocolo']);
        return new RespostaResource($data);
    }
}

<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Requests\CriarRespostaRequest;
use App\Http\Resources\RespostaResource;
use App\Models\Resposta;
use App\Repository\Contract\DenunciasIRepository;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class CriarRespostaController
{
    use AsAction;

    private $repo_denuncia;

    public function __construct(DenunciasIRepository $repo_denuncia)
    {
        $this->repo_denuncia = $repo_denuncia;
    }
    /**
     * @OA\Post(
     *     path="/api/resposta",
     *     summary="Adicionar uma resposta à denúncia",
     *     description="Adiciona uma nova resposta associada a uma denúncia pelo protocolo",
     *     operationId="addResposta",
     *     tags={"Respostas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="protocolo", type="string", example="20250213150250265"),
     *                 @OA\Property(property="resposta", type="string", example="asdasdasd asdsad assda as asdas asdsa assa asdssa assa assa")
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
     *                 @OA\Property(property="users_id", type="integer", example=6),
     *                 @OA\Property(property="denuncias_id", type="integer", example=1),
     *                 @OA\Property(property="resposta", type="string", example="asdasdasd asdsad assda as asdas asdsa assa asdssa assa assa"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-02-17T00:24:57.000000Z"),
     *                 @OA\Property(property="created_at", type="string", example="2025-02-17T00:24:57.000000Z"),
     *                 @OA\Property(property="id", type="integer", example=16)
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

    public function __invoke(CriarRespostaRequest $request)
    {
        $usersId =  (Auth::check()) ? Auth::user()->id : null;

        $denuncia = $this->repo_denuncia->getDenunciaByProtocolo($request['protocolo']);
        $resposta = [
            'users_id' => $usersId,
            'denuncias_id' => $denuncia->id,
            'resposta' => $request->input('resposta')
        ];
        $resposta = Resposta::create($resposta);

        return new RespostaResource($resposta);
    }
}

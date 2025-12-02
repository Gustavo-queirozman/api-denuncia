<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Requests\ListarDenunciaRequest;
use App\Http\Resources\DenunciaResource;
use App\Repository\Contract\DenunciasIRepository;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class ListarController
{
    use AsAction;

    private $repo_denuncia;

    public function __construct(DenunciasIRepository $repo_denuncia)
    {
        $this->repo_denuncia = $repo_denuncia;
    }

    /**
     * @OA\Get(
     *     path="/api/denuncias",
     *     summary="Lista todas as denúncias disponíveis",
     *     description="Retorna a lista de denúncias disponíveis para o usuário requisitante. Caso não existam denúncias disponíveis, retorna um erro 404.",
     *     operationId="getDenuncias",
     *     tags={"Denúncias"},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Lista de denúncias retornada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="protocolo", type="string", example="20250213150250265"),
     *                     @OA\Property(property="user_status", type="integer", example=6),
     *                     @OA\Property(property="departamentos_id", type="integer", example=1),
     *                     @OA\Property(property="status_id", type="integer", example=2),
     *                     @OA\Property(property="denuncia", type="string", example="Descrição da denúncia"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-13T15:02:50.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-16T03:30:06.000000Z"),
     *                     @OA\Property(property="anexos", type="array", @OA\Items(type="string"))
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=404,
     *         description="Nenhuma denúncia encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Nenhuma denúncia encontrada para o seu departamento."),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     )
     * )
     */

    public function __invoke(ListarDenunciaRequest $request)
    {
        $departamentosId = Auth::user()->departamentos_id;
        $data = $this->repo_denuncia->getAllDenuncias($departamentosId);

        return new DenunciaResource($data);
    }
}

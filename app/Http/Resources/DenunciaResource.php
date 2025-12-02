<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class DenunciaResource extends JsonResource
{
    public $success;
    public $message;
    public $resourceCollection;

    /**
     * Construtor para customizar sucesso e mensagem.
     */
    public function __construct($resource, $message = 'Operação realizada com sucesso!', $success = true)
    {
        parent::__construct($resource);

        $this->resourceCollection = $resource instanceof Collection ? $resource : collect($resource);

        $this->success = !$this->resourceCollection->isEmpty() && $success;
        $this->message = $message;
       
    }

    /**
     * Transforma o recurso em um array.
     */
    public function toArray($request): array
    {

        return [
            'success' =>  $this->success,
            'message' => $this->success === false? 'Error':$this->message,
            'data' => $this->resourceCollection->isEmpty() ? null : parent::toArray($request)
        ];
    }

    /**
     * Personaliza a resposta JSON e inclui status code.
     */
    public function toResponse($request): JsonResponse
    {
        $statusCode = $this->resourceCollection->isEmpty() ? 404 : 200;

        return response()->json($this->toArray($request), $statusCode);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class UsuarioResource extends JsonResource
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


class UserResource extends JsonResource
{
    private bool $success;
    private string $message;
    private mixed $data;

    public function __construct(mixed $resource, string $message = 'Operação realizada com sucesso!', bool $success = true)
    {
        parent::__construct($resource);

        $this->data = is_iterable($resource) ? collect($resource) : $resource;
        $this->success = !empty($this->data) && $success;
        $this->message = $message;
    }

    public function toArray($request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data ?: null, 
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request), $this->success ? 200 : 404);
    }
}

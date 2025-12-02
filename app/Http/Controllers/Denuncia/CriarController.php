<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Requests\CriarDenunciaRequest;
use App\Models\Anexo;
use App\Models\Denuncia;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class CriarController
{
    use AsAction;
    public function __invoke(CriarDenunciaRequest $request)
    {
     
        $protocolo = $this->geraProtocolo();
        $denuncia = $request->all();

        try {
            $denuncia['protocolo'] = $protocolo;
            $idDenuncia = Denuncia::create($denuncia)->id;
        } catch (\Exception $error) {
            return response()->json([
                "succes" => false,
                "error" => "Erro ao criar a denúncia: " . $error->getMessage()
            ], 500);
        }

        if ($request->hasFile('anexos')) {
            $anexos = $request->file('anexos');

            // Garante que 'anexos' é sempre um array
            if (!is_array($anexos)) {
                $anexos = [$anexos];
            }

            for ($i = 0; $i < count($anexos); $i++) {
                
                if ($anexos[$i]->isValid()) {
                    $extensaoAnexo = $anexos[$i]->getClientOriginalExtension();
                    $nomeAnexo = $this->nomearAnexo() . '.' . $extensaoAnexo;

                    // Salvar o anexo no sistema de arquivos
                    try {
                        $anexos[$i]->storeAs('anexos', $nomeAnexo, 'public');

                        $anexoData = [
                            'nome_anexo' => $nomeAnexo,
                            'denuncias_id' => $idDenuncia
                        ];

                        Anexo::create($anexoData);
                    } catch (\Exception $error) {
                        return response()->json([
                            "success" => false,
                            "error" => "Erro ao salvar o anexo: " . $error->getMessage()
                        ], 500);
                    }
                }

            }
        }

        return response()->json([
            "success" => true,
            "message" => "Denúncia criada com sucesso",
            "data" => ["protocolo" => $protocolo/*, "senha" => $request->senha*/]
        ]);
    }

    private function geraProtocolo()
    {
        return now()->format('YmdHmsv');
    }

    private function nomearAnexo()
    {
        return now()->format('YmdHmsv');
    }
}

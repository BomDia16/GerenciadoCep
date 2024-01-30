<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Historics extends Model
{
    use HasFactory;

    protected $table = 'historics';

    protected $fillable = [
        'cep', 'logradouro', 'bairro', 'localidade', 'uf', 'user_id'
    ];

    private function consultar($dados) {
        $response = Http::withOptions(['verify' => false])
            ->get("https://viacep.com.br/ws/{$dados['cep']}/json/");

        if ($response->ok()) {
            return [
                'status'    => true,
                'message'   => 'Sucesso ao fazer a consulta',
                'object'    => $response->json(),
            ];
        }

        return [
            'status'    => false,
            'message'   => 'Falha ao fazer a consulta',
        ];
    }

    public function inserir($dados) {
        try {
            $consulta = $this->consultar($dados);

            if (!$consulta['status']) {
                return $consulta;
            }

            $cep = $this->updateOrCreate(
                [
                    'cep' => $consulta['object']['cep']
                ],
                [
                    'logradouro'    => $consulta['object']['logradouro'],
                    'bairro'        => $consulta['object']['bairro'],
                    'localidade'    => $consulta['object']['localidade'],
                    'uf'            => $consulta['object']['uf'],
                    'user_id'       => Auth::user()->id,
                ]
            );

            return [
                'success' => true,
                'message' => 'Sucesso ao enviar o CEP',
                redirect()->route('historics.index'),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Falha ao enviar o CEP',
                redirect()->back(),
            ];
        }
    }
}

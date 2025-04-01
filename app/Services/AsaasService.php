<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('services.asaas.api_url'), '/');
        $this->apiKey = config('services.asaas.api_key');
    }

    public function enviarRequisicao(string $endpoint, array $dados = [], string $metodo)
    {
        try {
            $url = "{$this->apiUrl}/{$endpoint}";
            Log::info('Enviando requisição para o Asaas', [
                'url' => $url,
                'dados' => $dados,
                'headers' => $this->headers()
            ]);
            $response = match ($metodo) {
                'POST' => Http::withHeaders($this->headers())->post($url, $dados),
                'GET' => Http::withHeaders($this->headers())->get($url, $dados),
                'PUT' => Http::withHeaders($this->headers())->put($url, $dados),
                'DELETE' => Http::withHeaders($this->headers())->delete($url, $dados),
                default => throw new \Exception("Método HTTP não suportado: {$metodo}")
            };
            Log::info('Código de status da requisição', ['status_code' => $response->status()]);

            if ($response->failed()) {
                Log::error('Erro na requisição para o Asaas', [
                    'status_code' => $response->status(),
                    'body' => $response->body(),
                ]);
                return ['error' => 'Erro na requisição', 'details' => $response->body()];
            }
            Log::info('Resposta da requisição do Asaas', ['response_body' => $response->body()]);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Erro ao enviar requisição', ['erro' => $e->getMessage(), 'endpoint' => $endpoint]);
            return ['error' => 'Erro ao enviar requisição', 'details' => $e->getMessage()];
        }
    }

    protected function headers(): array
    {
        Log::info('Cabeçalhos para a requisição', [
            'access_token' => $this->apiKey
        ]);

        return [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'access_token' => $this->apiKey,
        ];
    }
}

//melhorar os logs
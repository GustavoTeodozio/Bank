<?php

namespace App\Services;

use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AccountService

{

    protected ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
        
    }

    public function criarConta(array $dados)
    {
        return $this->apiService->enviarRequisicao('accounts', $dados, 'POST');
    }

    public function pegarSaldo (array $dados)
    {
        return $this->apiService->enviarRequisicao('finance/balance', $dados, 'GET');
    }

    //extrato

    //transferir
    
    //outras operações
}

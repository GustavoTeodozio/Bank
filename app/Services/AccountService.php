<?php

namespace App\Services;

use App\Services\AsaasService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AccountService

{

    protected AsaasService $asaas;

    public function __construct(AsaasService $asaas)
    {
        $this->asaas = $asaas;
        
    }

    public function criarConta(array $dados)
    {
        return $this->asaas->enviarRequisicao('accounts', $dados, 'POST');
    }

    public function pegarSaldo (array $dados)
    {
        return $this->asaas->enviarRequisicao('finance/balance', $dados, 'GET');
    }

    //extrato

    //transferir
    
    //outras operações
}

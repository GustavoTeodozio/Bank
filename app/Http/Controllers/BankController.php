<?php

namespace App\Http\Controllers;


use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BankController extends Controller
{
    protected  AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    // private function getApiKey()
    // {
    //     $user = Auth::user();
    //     if (!$user || !$user->apiKey)
    //     {
    //         abort(403, 'usuario nao encontrado');
    //     }
    //     return $user->apiKey;
    // }
    

    // public function pegarSaldo()
    // {
    //     $apiKey = $this->getApiKey();
    //     $saldo = $this->accountService->pegarSaldo($apiKey);
    //     return response()->json(['saldo' => $saldo]);
    // }


}

//mudar nomes

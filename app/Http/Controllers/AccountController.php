<?php

namespace App\Http\Controllers;


use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AccountController extends Controller
{
    protected  AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }
    

    public function dashboard(Request $request)
    {
        $apiKey = $request->api_key;

        $saldo = $this->accountService->pegarSaldo([
            'apiKey' => $apiKey, 
        ]);

        return view ('dashboard', [
            'saldo' => $saldo,
            'nome' => Auth::user()->name
        ]);
    }


}

//mudar nomes

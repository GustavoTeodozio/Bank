<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccountService;

class PixController extends Controller
{
    public function __construct(protected AccountService $accountService) {}

    public function index(Request $request)
    {
        $apiKey = $request->api_key;

        $rawSaldo = $this->accountService->pegarSaldo([
            'apiKey' => $apiKey,
        ]);

        $saldoFormatado = number_format($rawSaldo['balance'], 2, ',', '.');

        return view('pix', [
            'saldo' => $saldoFormatado,
        ]);
    }
}

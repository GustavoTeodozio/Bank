<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Services\AccountService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected AccountService $accountService
    ) {}

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        event(new Registered($user));

        $asaasData = collect($data)->only([
            'name',
            'email',
            'cpfCnpj',
            'birthDate',
            'mobilePhone',
            'incomeValue',
            'address',
            'addressNumber',
            'complement',
            'province',
            'postalCode'
        ])->toArray();

        $apiResponse = $this->accountService->criarConta($asaasData);

        if (isset($apiResponse['error'])) {
            Log::error('Erro ao criar conta no Asaas', ['error' => $apiResponse]);
            $user->delete();
            throw new \Exception("Erro ao registrar usuário no Asaas: " . json_encode($apiResponse));
        }

        $updateData = [
            'asaas_id' => $apiResponse['id'] ?? null,
            'address' => $apiResponse['address'] ?? '',
            'addressNumber' => $apiResponse['addressNumber'] ?? '',
            'province' => $apiResponse['province'] ?? '',
            'postalCode' => $apiResponse['postalCode'] ?? '',
            'cpfCnpj' => $apiResponse['cpfCnpj'] ?? '',
            'birthDate' => $apiResponse['birthDate'] ?? '',
            'wallet_id' => $apiResponse['walletId'] ?? '',
            'account_number' => isset($apiResponse['accountNumber']) ? json_encode($apiResponse['accountNumber']) : null,
            'mobilePhone' => $apiResponse['mobilePhone'] ?? '',
            'incomeValue' => $apiResponse['incomeValue'] ?? 0.00,
            'apiKey' => $apiResponse['apiKey'] ?? '',
        ];

        $this->userRepository->update($user, $updateData);

        Auth::login($user);

        return $user;
    }
}

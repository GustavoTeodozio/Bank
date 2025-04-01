<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Http\Request;
use App\Services\AsaasService;
use App\Services\AccountService;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $cpfCnpj = '';
    public string $birthDate = '';
    public string $companyType = '';
    public string $mobilePhone = '';
    public string $incomeValue = '';
    public string $address = '';
    public string $addressNumber = '';
    public string $complement = '';
    public string $province = '';
    public string $postalCode = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(AccountService $accountService): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'cpfCnpj' => ['required', 'string', 'unique:' . User::class],
            'birthDate' => ['required', 'date'],
            'mobilePhone' => ['required', 'string'],
            'incomeValue' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'addressNumber' => ['required', 'string'],
            'complement' => ['nullable', 'string'],
            'province' => ['required', 'string'],
            'postalCode' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],

        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $asaasData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cpfCnpj' => $validated['cpfCnpj'],
            'birthDate' => $validated['birthDate'],
            'mobilePhone' => $validated['mobilePhone'],
            'incomeValue' => $validated['incomeValue'],
            'address' => $validated['address'],
            'addressNumber' => $validated['addressNumber'],
            'complement' => $validated['complement'] ?? '',
            'province' => $validated['province'],
            'postalCode' => $validated['postalCode'],
            
        ];

        $asaasResponse = $accountService->criarConta($asaasData);

        if (isset($asaasResponse['error'])) {
            \Log::error('Erro ao criar conta no Asaas', ['error' => $asaasResponse]);


            $user->delete();

            throw new \Exception("Erro ao registrar usuário no Asaas: " . json_encode($asaasResponse));
        }


        if (isset($asaasResponse['id'])) {
            $user->asaas_id = $asaasResponse['id'] ?? null;
            $user->address = $asaasResponse['address'] ?? '';
            $user->addressNumber = $asaasResponse['addressNumber'] ?? ''; 
            $user->province = $asaasResponse['province'] ?? ''; 
            $user->postal_code = $asaasResponse['postalCode'] ?? '';
            $user->cpfCnpj = $asaasResponse['cpfCnpj'] ?? ''; 
            $user->birthDate = $asaasResponse['birthDate'] ?? '';
            $user->wallet_id = $asaasResponse['walletId'] ?? '';
            $user->account_number = isset($asaasResponse['accountNumber']) ? json_encode($asaasResponse['accountNumber']) : null;
            $user->mobilePhone = $asaasResponse['mobilePhone'] ?? '';
            $user->incomeValue = $asaasResponse['incomeValue'] ?? 0.00;

            $user->save();
        }


        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Name -->
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" class="w-full" />

        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" class="w-full" />

        <!-- CPF/CNPJ -->
        <flux:input wire:model="cpfCnpj" :label="__('CPF/CNPJ')" type="text" required autocomplete="cpfCnpj"
            :placeholder="__('CPF/CNPJ')" class="w-full" />

        <!-- Birth Date -->
        <flux:input wire:model="birthDate" :label="__('Date of Birth')" type="date" required autocomplete="bday"
            :placeholder="__('YYYY-MM-DD')" class="w-full" />

        <!-- Mobile Phone -->
        <flux:input wire:model="mobilePhone" :label="__('Mobile Phone')" type="tel" required autocomplete="tel"
            :placeholder="__('(XX) XXXXX-XXXX')" class="w-full" />

        <!-- Income Value -->
        <flux:input wire:model="incomeValue" :label="__('Income Value')" type="number" required step="0.01"
            :placeholder="__('0.00')" class="w-full" />


        <!-- Address -->
        <flux:input wire:model="address" :label="__('Address')" type="text" required autocomplete="street-address"
            :placeholder="__('Street name, Avenue, etc.')" class="w-full" />

        <!-- Address Number -->
        <flux:input wire:model="addressNumber" :label="__('Address Number')" type="text" required
            autocomplete="address-line2" :placeholder="__('123')" class="w-full" />

        <!-- Complement -->
        <flux:input wire:model="complement" :label="__('Complement')" type="text" autocomplete="address-line3"
            :placeholder="__('Apartment, floor, etc.')" class="w-full" />

        <!-- Province -->
        <flux:input wire:model="province" :label="__('Province/State')" type="text" required autocomplete="region"
            :placeholder="__('State or province')" class="w-full" />

        <!-- Postal Code -->
        <flux:input wire:model="postalCode" :label="__('Postal Code')" type="text" required autocomplete="postal-code"
            :placeholder="__('XXXXX-XXX')" class="w-full" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" class="w-full" />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" class="w-full" />

        <!-- Botão de Criar Conta ocupa toda a linha -->
        <div class="col-span-1 md:col-span-2 flex justify-end">
            <flux:button type="submit" variant="primary" class="w-full md:w-auto">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Http\Request;
use App\Services\AccountService;

new #[Layout('components.layouts.auth')] class extends Component {

}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        <!-- Name -->
        <flux:input name="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" class="w-full" />

        <!-- Email Address -->
        <flux:input name="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" class="w-full" />

        <!-- CPF/CNPJ -->
        <flux:input name="cpfCnpj" :label="__('CPF/CNPJ')" type="text" required autocomplete="cpfCnpj"
            :placeholder="__('CPF/CNPJ')" class="w-full" />

        <!-- Birth Date -->
        <flux:input name="birthDate" :label="__('Date of Birth')" type="date" required autocomplete="bday"
            :placeholder="__('YYYY-MM-DD')" class="w-full" />

        <!-- Mobile Phone -->
        <flux:input name="mobilePhone" :label="__('Mobile Phone')" type="tel" required autocomplete="tel"
            :placeholder="__('(XX) XXXXX-XXXX')" class="w-full" />

        <!-- Income Value -->
        <flux:input name="incomeValue" :label="__('Income Value')" type="number" required step="0.01"
            :placeholder="__('0.00')" class="w-full" />

        <!-- Address -->
        <flux:input name="address" :label="__('Address')" type="text" required autocomplete="street-address"
            :placeholder="__('Street name, Avenue, etc.')" class="w-full" />

        <!-- Address Number -->
        <flux:input name="addressNumber" :label="__('Address Number')" type="text" required autocomplete="address-line2"
            :placeholder="__('123')" class="w-full" />

        <!-- Complement -->
        <flux:input name="complement" :label="__('Complement')" type="text" autocomplete="address-line3"
            :placeholder="__('Apartment, floor, etc.')" class="w-full" />

        <!-- Province -->
        <flux:input name="province" :label="__('Province/State')" type="text" required autocomplete="region"
            :placeholder="__('State or province')" class="w-full" />

        <!-- Postal Code -->
        <flux:input name="postalCode" :label="__('Postal Code')" type="text" required autocomplete="postal-code"
            :placeholder="__('XXXXX-XXX')" class="w-full" />

        <!-- Password -->
        <flux:input name="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" class="w-full" />

        <!-- Confirm Password -->
        <flux:input name="password_confirmation" :label="__('Confirm password')" type="password" required
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
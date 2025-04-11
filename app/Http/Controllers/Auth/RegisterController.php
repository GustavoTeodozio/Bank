<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'cpfCnpj' => ['required', 'string', 'unique:users'],
            'birthDate' => ['required', 'date'],
            'mobilePhone' => ['required', 'string'],
            'incomeValue' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'addressNumber' => ['required', 'string'],
            'complement' => ['nullable', 'string'],
            'province' => ['required', 'string'],
            'postalCode' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ])->validate();

        $this->userService->register($validated);

        return redirect()->route('dashboard');
    }

}
<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function login()
    {
        $credentials = $this->validate();

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $this->remember)) {
            $this->addError('email', 'Email atau password salah.');

            return;
        }

        request()->session()->regenerate();

        if (auth()->user()->isSuperadmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->route('tenant.dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
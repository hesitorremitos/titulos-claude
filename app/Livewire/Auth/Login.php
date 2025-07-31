<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|string')]
    public string $ci = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['ci' => $this->ci, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            
            return $this->redirect('/dashboard', navigate: true);
        }

        $this->addError('ci', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }
}

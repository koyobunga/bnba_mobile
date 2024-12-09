<?php

namespace App\Livewire;

use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{

    use Toast;

    #[Validate('required')]
    public $username;

    #[Validate('required')]
    public $password;


    public function login(){
        // Simulate authentication logic
        $user = $this->validate();
        if(Auth::attempt($user)){
            // $req->session()->regenerate();
            return redirect()->to('/');
        }else{
            $this->warning('Login failed', 'Username and password incorrect');
        }
    }

    public function render()
    {
        return view('livewire.login')
            ->layout('layouts.login');
    }
}

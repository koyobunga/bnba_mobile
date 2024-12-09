<?php

namespace App\Livewire\Keluarga;

use Livewire\Component;

class Individu extends Component
{
    public $title = 'Individu';

    public $url = '';

    public $modalAddIndividu = false;


    public function mount()
    {   
        $this->url =url('/individu?id=');
    }

    public function render()
    {
        return view('livewire.keluarga.individu')
            ->layout('layouts.detail');
    }
}

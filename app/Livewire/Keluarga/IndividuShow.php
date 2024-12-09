<?php

namespace App\Livewire\Keluarga;

use Livewire\Component;

class IndividuShow extends Component
{

    public $modalHapus = false;
    public $myModal2 = false;
    public $selectedTab = 'users-tab';
    public function render()
    {
        return view('livewire.keluarga.individu-show')->layout('layouts.detail');
    }
}

<?php

namespace App\Livewire\Keluarga;

use Livewire\Component;

class Aset extends Component
{

    public $selectedTab = 'program-tab';
    public function render()
    {
        return view('livewire.keluarga.aset')->layout('layouts.detail');
    }
}

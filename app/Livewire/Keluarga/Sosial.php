<?php

namespace App\Livewire\Keluarga;

use Livewire\Component;

class Sosial extends Component
{

    public $selectedTab = 'users-tab';
    public $perijinan = [1,2];
    public $internet = [];
    public function render()
    {
        return view('livewire.keluarga.sosial')->layout('layouts.detail');
    }
}

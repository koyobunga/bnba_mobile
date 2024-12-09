<?php

namespace App\Livewire\Keluarga;

use Livewire\Component;

class Perumahan extends Component
{
    public $title = 'Perumahan';

    public $myModal1 = true;
    
    public function render()
    {
        return view('livewire.keluarga.perumahan')->layout('layouts.detail');
    }
}

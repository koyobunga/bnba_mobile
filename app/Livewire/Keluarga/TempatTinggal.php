<?php

namespace App\Livewire\Keluarga;

use Livewire\Component;

class TempatTinggal extends Component
{
    public $prov;
    
    public $kab;
    
    public $kec;
    
    public $desa;
    
    public $dusun;
    
    public $rw;
    public $rt;


    public $latitude;
    public $longitude;

    protected $listeners = ['updateLocation'];

    public function updateLocation($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function render()
    {
        return view('livewire.keluarga.tempat-tinggal')->layout('layouts.detail');
    }
}

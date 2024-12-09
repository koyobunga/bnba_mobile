<?php

namespace App\Livewire\Keluarga;

use Livewire\Component;

class Keluarga extends Component
{

    public $title = 'Keluarga';
    public $judul = 'Keluarga';

    public $url ='';
    public $urlperuhan ='';
    public $urlsosial ='';
    public $urlaset ='';
    public $urlindividu ='';
    public $modalHapus = false;


    public function mount(){
        $this->url = url('/tempattinggal?id=');
        $this->urlperuhan = url('/perumahan?id=');
        $this->urlsosial = url('/sosial?id=');
        $this->urlaset = url('/aset?id=');
        $this->urlindividu = url('/individu?id=');
    }
    public function render()
    {
        return view('livewire.keluarga.keluarga')->layout('layouts.detail');
    }
}

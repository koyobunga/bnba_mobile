<?php

use App\Http\Middleware\is_admin;
use App\Livewire\Components\Loaddata;
use App\Livewire\Home;
use App\Livewire\Keluarga\Aset;
use App\Livewire\Keluarga\Individu;
use App\Livewire\Keluarga\IndividuShow;
use App\Livewire\Keluarga\Keluarga;
use App\Livewire\Keluarga\Perumahan;
use App\Livewire\Keluarga\Sosial;
use App\Livewire\Keluarga\TempatTinggal;
use App\Livewire\Login;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/user', function () {
    dd(User::all());
});

Route::middleware(is_admin::class)->group(function() { 
    Route::get('/', Home::class)->name('home');
    Route::get('/keluarga', Keluarga::class);
    Route::get('/individu', Individu::class);
    Route::get('/tempattinggal', TempatTinggal::class);
    Route::get('/perumahan', Perumahan::class);
    Route::get('/sosial', Sosial::class);
    Route::get('/aset', Aset::class);
    Route::get('/individu/show', IndividuShow::class);

    
    Route::get('/logout', function(){
        Auth::logout();
        return redirect('/login');
    });
});

Route::get('/login', Login::class);


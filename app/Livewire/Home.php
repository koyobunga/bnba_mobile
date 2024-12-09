<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Mary\Traits\Toast;
use Livewire\Component;
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;

class Home extends Component
{
    use Toast;

    public $title = 'Data Keluarga';

    public $name;
    public $email;
    public $kelurahan;
    public $modalConfirm = false;
    public $modalConfirmtwo = false;
    public $modalAddKeluarga = false;
    public $modalList = false;

    public $url = '';


    #[Validate('required|min:1')]
    public $password = '';



    public function mount(Request $request){

        $this->url =url('/keluarga?id=');

        $data = DB::table('wil_kel')
        ->where('kode_kel', Auth::user()->kode_kel)
        ->first();
        $this->name = Auth::user()->nama;
        $this->email = Auth::user()->email;
        $this->kelurahan = $data->kelurahan;

       
    }

    #[On('keluarga-up')]
    public function keluargaUp(array $data)
    {
        $data = new Collection($data);
        foreach($data as $d){
            $c = $d['items'];
            $dt = [
                'id_keluarga' => $c['id_keluarga'] ?? null,
                'nomor_kk' => $c['nomor_kk'] ?? null,
                'alamat_rumah' => $c['alamat_rumah'] ?? null,
                'kode_kel' => $c['kode_kel'] ?? null,
                'rt' => $c['rt'] ?? null,
                'rw' => $c['rw'] ?? null,
                'koordinat_lat' => $c['koordinat_lat'] ?? null,
                'koordinat_lng' => $c['koordinat_lng'] ?? null,
                'responden_nama' => $c['responden_nama'] ?? null,
                'responden_ttd' => $c['responden_ttd'] ?? null,
                'foto_depan_rumah' => $c['foto_depan_rumah'] ?? null,
                'foto_ruang_tamu' => $c['foto_ruang_tamu'] ?? null,
                'foto_dapur' => $c['foto_dapur'] ?? null,
                'foto_toilet' => $c['foto_toilet'] ?? null,
                'id_kepemilikan_tt' => $c['id_kepemilikan_tt'] ?? null,
                'id_bukti_kepemilikan_tt' => $c['id_bukti_kepemilikan_tt'] ?? null,
                'luas_tanah' => $c['luas_tanah'] ?? null,
                'jumlah_tingkat_rumah' => $c['jumlah_tingkat_rumah'] ?? null,
                'luas_bangunan' => $c['luas_bangunan'] ?? null,
                'jumlah_keluarga_menempati' => $c['jumlah_keluarga_menempati'] ?? null,
                'id_jenis_lantai' => $c['id_jenis_lantai'] ?? null,
                'foto_lantai' => $c['foto_lantai'] ?? null,
                'id_jenis_dinding' => $c['id_jenis_dinding'] ?? null,
                'foto_dinding' => $c['foto_dinding'] ?? null,
                'id_jenis_atap' => $c['id_jenis_atap'] ?? null,
                'foto_atap' => $c['foto_atap'] ?? null,
                'kode_sumber_air_minum' => $c['kode_sumber_air_minum'] ?? null,
                'foto_sumber_air_minum' => $c['foto_sumber_air_minum'] ?? null,
                'id_jarak_sumber_air_minum' => $c['id_jarak_sumber_air_minum'] ?? null,
                'id_jenis_listrik' => $c['id_jenis_listrik'] ?? null,
                'id_daya_listrik' => $c['id_daya_listrik'] ?? null,
                'kode_bahan_bakar_memasak' => $c['kode_bahan_bakar_memasak'] ?? null,
                'id_fas_bab' => $c['id_fas_bab'] ?? null,
                'id_jenis_kloset' => $c['id_jenis_kloset'] ?? null,
                'id_jenis_akhir_tinja' => $c['id_jenis_akhir_tinja'] ?? null,
                'foto_akhir_tinja' => $c['foto_akhir_tinja'] ?? null,
                'program_bpnt' => $c['program_bpnt'] ?? null,
                'periode_program_bpnt' => $c['periode_program_bpnt'] ?? null,
                'program_blt' => $c['program_blt'] ?? null,
                'periode_program_blt' => $c['periode_program_blt'] ?? null,
                'program_pkh' => $c['program_pkh'] ?? null,
                'periode_program_pkh' => $c['periode_program_pkh'] ?? null,
                'program_subsidi_listrik' => $c['program_subsidi_listrik'] ?? null,
                'periode_program_subsidi_listrik' => $c['periode_program_subsidi_listrik'] ?? null,
                'program_bantuan_pemda' => $c['program_bantuan_pemda'] ?? null,
                'periode_program_bantuan_pemda' => $c['periode_program_bantuan_pemda'] ?? null,
                'program_subsidi_pupuk' => $c['program_subsidi_pupuk'] ?? null,
                'periode_program_subsidi_pupuk' => $c['periode_program_subsidi_pupuk'] ?? null,
                'menggunakan_gas_3kg' => $c['menggunakan_gas_3kg'] ?? null,
                'periode_menggunakan_gas_3kg' => $c['periode_menggunakan_gas_3kg'] ?? null,
                'jumlah_tabung_gas_5kg' => $c['jumlah_tabung_gas_5kg'] ?? null,
                'jumlah_kulkas' => $c['jumlah_kulkas'] ?? null,
                'jumlah_ac' => $c['jumlah_ac'] ?? null,
                'jumlah_pemanas_air' => $c['jumlah_pemanas_air'] ?? null,
                'jumlah_telepon_rumah' => $c['jumlah_telepon_rumah'] ?? null,
                'jumlah_tv' => $c['jumlah_tv'] ?? null,
                'jumlah_perhiasan' => $c['jumlah_perhiasan'] ?? null,
                'jumlah_komputer' => $c['jumlah_komputer'] ?? null,
                'jumlah_sepeda_motor' => $c['jumlah_sepeda_motor'] ?? null,
                'jumlah_sepeda' => $c['jumlah_sepeda'] ?? null,
                'jumlah_mobil' => $c['jumlah_mobil'] ?? null,
                'jumlah_perahu_non_motor' => $c['jumlah_perahu_non_motor'] ?? null,
                'jumlah_perahu_motor' => $c['jumlah_perahu_motor'] ?? null,
                'jumlah_smartphone' => $c['jumlah_smartphone'] ?? null,
                'punya_lahan_lainnya' => $c['punya_lahan_lainnya'] ?? null,
                'jumlah_rumah_lainnya' => $c['jumlah_rumah_lainnya'] ?? null,
                'jumlah_sapi' => $c['jumlah_sapi'] ?? null,
                'jumlah_kerbau' => $c['jumlah_kerbau'] ?? null,
                'jumlah_kuda' => $c['jumlah_kuda'] ?? null,
                'jumlah_domba' => $c['jumlah_domba'] ?? null,
                'jumlah_babi' => $c['jumlah_babi'] ?? null,
                'id_akses_internet' => $c['id_akses_internet'] ?? null,
                'id_dompet_digital' => $c['id_dompet_digital'] ?? null,
                'id_pendapatan_utama' => $c['id_pendapatan_utama'] ?? null,
                'id_user_enumerator' => Auth::user()->id,
                'catatan_enumerator' => $c['catatan_enumerator'] ?? null,
                'tanggal_pendataan' => $c['tanggal_pendataan'] ?? null,
            ];
            $cek = DB::table('p_keluarga')
                ->where('id_keluarga', $c['id_keluarga'])
                ->get();
            if($cek->count()>0){
                $update = DB::table('p_keluarga')
                    ->where('id_keluarga', $c['id_keluarga'])
                    ->update($dt);
                if($update){
                    $this->dispatch('alert-keluarga-up', $d['id']);
                }
            }else{
                $insert = DB::table('p_keluarga')
                    ->insert($dt);
                if($insert){
                    $this->dispatch('alert-keluarga-up', $d['id']);
                }
            }
        }
    }
    #[On('individu-up')]
    public function individuUp(array $data)
    {
        $data = new Collection($data);
        foreach($data as $d){
            $c = $d['items'];

            $dt = [
                'id_individu' => $c['id_individu'] ?? null,
                'id_keluarga' => $c['id_keluarga'] ?? null,
                'nik' => $c['nik'] ?? null,
                'nama' => $c['nama'] ?? null,
                'tempat_lahir' => $c['tempat_lahir'] ?? null,
                'tanggal_lahir' => $c['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $c['jenis_kelamin'] ?? null,
                'id_keberadaan_individu' => $c['id_keberadaan_individu'] ?? null,
                'id_hubungan_keluarga' => $c['id_hubungan_keluarga'] ?? null,
                'id_status_nikah' => $c['id_status_nikah'] ?? null,
                'umur_saat_nikah' => $c['umur_saat_nikah'] ?? null,
               'status_hamil' => $c['status_hamil'] ?? null,
                'punya_ktp' => $c['punya_ktp'] ?? null, 
                'punya_akta_lahir' => $c['punya_akta_lahir'] ?? null,
                'punya_kia' => $c['punya_kia'] ?? null,
                'id_bersekolah' => $c['id_bersekolah'] ?? null,
                'kode_jenjang_pendidikan' => $c['kode_jenjang_pendidikan'] ?? null,
                'kode_ijazah' => $c['kode_ijazah'] ?? null,
                'tingkat_pendidikan' => $c['tingkat_pendidikan'] ?? null,
               'status_bekerja' => $c['status_bekerja'] ?? null,
                'jumlah_jam_kerja_seminggu' => $c['jumlah_jam_kerja_seminggu'] ?? null,
                'kode_pekerjaan' => $c['kode_pekerjaan'] ?? null,
                'json_bidang_usaha' => $c['json_bidang_usaha'] ?? null,
                'kode_bidang_usaha' => $c['kode_bidang_usaha'] ?? null,
                'id_status_pekerjaan_utama' => $c['id_status_pekerjaan_utama'] ?? null,
                'punya_npwp' => $c['punya_npwp'] ?? null,
                'punya_usaha_lainnya' => $c['punya_usaha_lainnya'] ?? null,
                'jumlah_usaha_lainnya' => $c['jumlah_usaha_lainnya'] ?? null,
                'json_usaha_lainnya' => $c['json_usaha_lainnya'] ?? null,
                'kode_bidang_usaha_utama' => $c['kode_bidang_usaha_utama'] ?? null,
                'jumlah_pekerja_dibayar' => $c['jumlah_pekerja_dibayar'] ?? null,
                'jumlah_pekerja_tidak_dibayar' => $c['jumlah_pekerja_tidak_dibayar'] ?? null,
                'json_izin_usaha' => $c['json_izin_usaha'] ?? null,
                'id_omzet_usaha' => $c['id_omzet_usaha'] ?? null,
                'json_kode_internet_usaha' => $c['json_kode_internet_usaha'] ?? null,
                'id_gangguan_melihat' => $c['id_gangguan_melihat'] ?? null,
                'id_gangguan_mendengar' => $c['id_gangguan_mendengar'] ?? null,
                'id_gangguan_berjalan' => $c['id_gangguan_berjalan'] ?? null,
                'id_gangguan_tangan' => $c['id_gangguan_tangan'] ?? null,
                'id_gangguan_intelektual' => $c['id_gangguan_intelektual'] ?? null,
                'id_gangguan_emosional' => $c['id_gangguan_emosional'] ?? null,
                'id_gangguan_mandiri' => $c['id_gangguan_mandiri'] ?? null,
                'id_gangguan_konsentrasi' => $c['id_gangguan_konsentrasi'] ?? null,
                'id_gangguan_depresi' => $c['id_gangguan_depresi'] ?? null,
                'id_stunting' => $c['id_stunting'] ?? null,
                'id_memiliki_pengasuh' => $c['id_memiliki_pengasuh'] ?? null,
                'json_kode_penyakit' => $c['json_kode_penyakit'] ?? null,
                'bpjs_non_pbi' => $c['bpjs_non_pbi'] ?? null,
                'bpjs_pbi' => $c['bpjs_pbi'] ?? null,
                'bpjs_jamkses' => $c['bpjs_jamkses'] ?? null,
                'prakerja' => $c['prakerja'] ?? null,
                'bpjs_kecelakaan' => $c['bpjs_kecelakaan'] ?? null,
                'bpjs_kematian' => $c['bpjs_kematian'] ?? null,
                'bpjs_hari_tua' => $c['bpjs_hari_tua'] ?? null,
                'bpjs_pensiun' => $c['bpjs_pensiun'] ?? null,
                'jaminan_hari_tua' => $c['jaminan_hari_tua'] ?? null,
                'kur' => $c['kur'] ?? null,
                'jaminan_usaha_mikro' => $c['jaminan_usaha_mikro'] ?? null,
            ];

           
            
            $cek = DB::table('p_individu')
                ->where('id_individu', $c['id_individu'])
                ->get();
            if($cek->count()>0){
                $update = DB::table('p_individu')
                    ->where('id_individu', $c['id_individu'])
                    ->update($dt);

                if($update){
                    $this->dispatch('alert-individu-up', $d['id']);
                }
            }else{
                $insert = DB::table('p_individu')
                ->insert($dt);
                
                if($insert){
                    $this->dispatch('alert-individu-up', $d['id']);
                }
            }
        }
    }


    public function rendered(Request $request) 
    {
        if(!empty($request->password)){ 
            if(Hash::check($request->password, Auth::user()->password)){
                $this->createData();
            }
        }
    }


    #[On('show-modal-loaddata')]
    public function showModalLoad(){
        $this->modalConfirmtwo = true;
    }
    
    public function confirmPassword()
    {
        $this->validate();

        if(Hash::check($this->password, Auth::user()->password)){
            $this->createData();
        }else{
            $this->warning('Password tidak sesuai..');
        }

    }

  
    #[On('load-data')]
    public function createData()
    {

        $keluarga = DB::table('d_keluarga')
        ->select('d_keluarga.*', 
            'wil_kel.kelurahan', 
            'wil_kec.kecamatan', 
            'wil_kec.kode_kec', 
            'wil_kab.kabkota', 
            'wil_kab.kode_kab', 
            'd_individu.nama',
            'd_individu.nik',
            'd_individu.jenis_kelamin',
            'd_individu.tanggal_lahir',
            )
        ->join('wil_kel', 'wil_kel.kode_kel', '=', 'd_keluarga.kode_kel')
        ->join('wil_kec', 'wil_kel.kode_kec', '=', 'wil_kec.kode_kec')
        ->join('wil_kab', 'wil_kec.kode_kab', '=', 'wil_kab.kode_kab')
        ->join('d_individu', 'd_individu.id_keluarga', '=', 'd_keluarga.id_keluarga')
        ->where('d_keluarga.kode_kel', Auth::user()->kode_kel)
        ->where('d_keluarga.rt', Auth::user()->rt)
        ->where('d_individu.id_hubungan_keluarga', 1)
        ->get();

        // dd($keluarga->toArray());


        
        $individu = DB::table('d_individu')
            //where id_keluarga from tabel_keluarg
                ->where(function($query) use ($keluarga){
                    foreach ($keluarga as $k) {
                        $query->orWhere('id_keluarga', $k->id_keluarga);
                    }
                })
                ->get();
        


        $wilKab = DB::table('wil_kab')
        ->select('kode_kab','kabkota')
        ->get();
        
        $wilKec = DB::table('wil_kec')
        ->select('kode_kab','kode_kec','kecamatan')
        ->orderby('kecamatan', 'asc')
        ->get();
        
        $wilKel = DB::table('wil_kel')
        ->select('kode_kel','kode_kec','kelurahan')
        ->orderby('kelurahan', 'asc')
        ->get();
        
        
        $ref_izin_usaha = DB::table('ref_izin_usaha')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_izin_usaha',
            'data' => $ref_izin_usaha->toArray()
        ]); 
        
        $ref_gangguan_melihat = DB::table('ref_gangguan_melihat')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_melihat',
            'data' => $ref_gangguan_melihat->toArray()
        ]); 
        
        $ref_gangguan_komunikasi = DB::table('ref_gangguan_komunikasi')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_komunikasi',
            'data' => $ref_gangguan_komunikasi->toArray()
        ]); 
        
        $ref_gangguan_mandiri = DB::table('ref_gangguan_mandiri')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_mandiri',
            'data' => $ref_gangguan_mandiri->toArray()
        ]); 
        
        $ref_gangguan_depresi = DB::table('ref_gangguan_depresi')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_depresi',
            'data' => $ref_gangguan_depresi->toArray()
        ]); 
        
        $ref_gangguan_konsentrasi = DB::table('ref_gangguan_konsentrasi')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_konsentrasi',
            'data' => $ref_gangguan_konsentrasi->toArray()
        ]); 
        
        $ref_gangguan_mendengar = DB::table('ref_gangguan_mendengar')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_mendengar',
            'data' => $ref_gangguan_mendengar->toArray()
        ]); 
        
        $ref_gangguan_berjalan = DB::table('ref_gangguan_berjalan')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_berjalan',
            'data' => $ref_gangguan_berjalan->toArray()
        ]); 
        
        $ref_gangguan_emosional = DB::table('ref_gangguan_emosional')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_emosional',
            'data' => $ref_gangguan_emosional->toArray()
        ]); 
        
        $ref_gangguan_intelektual = DB::table('ref_gangguan_intelektual')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_intelektual',
            'data' => $ref_gangguan_intelektual->toArray()
        ]); 
        
        $ref_gangguan_tangan = DB::table('ref_gangguan_tangan')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_gangguan_tangan',
            'data' => $ref_gangguan_tangan->toArray()
        ]); 

        $ref_kepemilikan_tt = DB::table('ref_kepemilikan_tt')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_kepemilikan_tt',
            'data' => $ref_kepemilikan_tt->toArray()
        ]);       
        
        $ref_akses_internet = DB::table('ref_akses_internet')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_akses_internet',
            'data' => $ref_akses_internet->toArray()
        ]);       
        
        $ref_bahan_bakar_memasak = DB::table('ref_bahan_bakar_memasak')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_bahan_bakar_memasak',
            'data' => $ref_bahan_bakar_memasak->toArray()
        ]);       
        
        $ref_bersekolah = DB::table('ref_bersekolah')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_bersekolah',
            'data' => $ref_bersekolah->toArray()
        ]);       
        
        $ref_biaya_listrik = DB::table('ref_biaya_listrik')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_biaya_listrik',
            'data' => $ref_biaya_listrik->toArray()
        ]);       
       
        $ref_bidang_usaha = DB::table('ref_bidang_usaha')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_bidang_usaha',
            'data' => $ref_bidang_usaha->toArray()
        ]);       
       
        $ref_bukti_kepemilikan_tt = DB::table('ref_bukti_kepemilikan_tt')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_bukti_kepemilikan_tt',
            'data' => $ref_bukti_kepemilikan_tt->toArray()
        ]);       
        
        $ref_daya_listrik = DB::table('ref_daya_listrik')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_daya_listrik',
            'data' => $ref_daya_listrik->toArray()
        ]);       
        
        $ref_dompet_digital = DB::table('ref_dompet_digital')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_dompet_digital',
            'data' => $ref_dompet_digital->toArray()
        ]);       
        
        $ref_fas_bab = DB::table('ref_fas_bab')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_fas_bab',
            'data' => $ref_fas_bab->toArray()
        ]);       
        
        $ref_hubungan_keluarga = DB::table('ref_hubungan_keluarga')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_hubungan_keluarga',
            'data' => $ref_hubungan_keluarga->toArray()
        ]);       
        
        $ref_internet_usaha = DB::table('ref_internet_usaha')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_internet_usaha',
            'data' => $ref_internet_usaha->toArray()
        ]);       
        
        $ref_jarak_sumber_air_minum = DB::table('ref_jarak_sumber_air_minum')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jarak_sumber_air_minum',
            'data' => $ref_jarak_sumber_air_minum->toArray()
        ]);       
        
        $ref_jenis_akhir_tinja = DB::table('ref_jenis_akhir_tinja')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenis_akhir_tinja',
            'data' => $ref_jenis_akhir_tinja->toArray()
        ]);       
        
        $ref_jenis_atap = DB::table('ref_jenis_atap')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenis_atap',
            'data' => $ref_jenis_atap->toArray()
        ]);       
        
        $ref_jenis_dinding = DB::table('ref_jenis_dinding')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenis_dinding',
            'data' => $ref_jenis_dinding->toArray()
        ]);       
        
        $ref_jenis_kloset = DB::table('ref_jenis_kloset')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenis_kloset',
            'data' => $ref_jenis_kloset->toArray()
        ]);       
        
        $ref_jenis_lantai = DB::table('ref_jenis_lantai')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenis_lantai',
            'data' => $ref_jenis_lantai->toArray()
        ]);       
       
        $ref_jenis_listrik = DB::table('ref_jenis_listrik')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenis_listrik',
            'data' => $ref_jenis_listrik->toArray()
        ]);       
       
        $ref_jenis_penyakit = DB::table('ref_jenis_penyakit')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenis_penyakit',
            'data' => $ref_jenis_penyakit->toArray()
        ]);       
        
        $ref_jenjang_pendidikan = DB::table('ref_jenjang_pendidikan')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_jenjang_pendidikan',
            'data' => $ref_jenjang_pendidikan->toArray()
        ]);       
            
        
        $ref_keberadaan_individu = DB::table('ref_keberadaan_individu')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_keberadaan_individu',
            'data' => $ref_keberadaan_individu->toArray()
        ]);       
        
        $ref_memiliki_pengasuh = DB::table('ref_memiliki_pengasuh')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_memiliki_pengasuh',
            'data' => $ref_memiliki_pengasuh->toArray()
        ]);       
        
        $ref_omzet_usaha = DB::table('ref_omzet_usaha')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_omzet_usaha',
            'data' => $ref_omzet_usaha->toArray()
        ]);       
        
        $ref_pekerjaan = DB::table('ref_pekerjaan')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_pekerjaan',
            'data' => $ref_pekerjaan->toArray()
        ]);       
        
        $ref_pendapatan_utama = DB::table('ref_pendapatan_utama')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_pendapatan_utama',
            'data' => $ref_pendapatan_utama->toArray()
        ]);       
        
        $ref_responden_sedia = DB::table('ref_responden_sedia')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_responden_sedia',
            'data' => $ref_responden_sedia->toArray()
        ]);       
        
        $ref_status_nikah = DB::table('ref_status_nikah')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_status_nikah',
            'data' => $ref_status_nikah->toArray()
        ]);       
        
        $ref_status_pekerjaan_utama = DB::table('ref_status_pekerjaan_utama')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_status_pekerjaan_utama',
            'data' => $ref_status_pekerjaan_utama->toArray()
        ]);       
        
        $ref_stunting = DB::table('ref_stunting')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_stunting',
            'data' => $ref_stunting->toArray()
        ]);       
        
        $ref_sumber_air_minum = DB::table('ref_sumber_air_minum')->get();
        $this->dispatch('createLocalStorage', [
            'name' => 'ref_sumber_air_minum',
            'data' => $ref_sumber_air_minum->toArray()
        ]);       

        

        $this->dispatch('insertData',  [
            'individu' =>$individu->toArray(),
            'keluarga' =>$keluarga->toArray(),
        ]);

        $this->dispatch('createLocalStorage', [
            'name' => 'wil_kab',
            'data' => $wilKab->toArray()
        ]);
        
        $this->dispatch('createLocalStorage', [
            'name' => 'wil_kec',
            'data' => $wilKec->toArray()
        ]);
        
        $this->dispatch('createLocalStorage', [
            'name' => 'wil_kel',
            'data' => $wilKel->toArray()
        ]);
        
        $this->modalConfirm = false;
        
        return $this->redirect('/', navigate:true);
        

    }

    public function render()
    {
        return view('livewire.home');
    }
}

<div x-data="crudIndex" class="sm:p-5 md:p-7 pb-10" x-init="selectTable('keluarga'), getDataFromIndexedDB(), onLine()">

    <div x-show="datakeluarga.length==0">
        <div class="flex justify-between bg-base-100 items-center p-5 border-b">
            <div class="">
                <div class="font-bold">Hi, {{ $name }}</div>
                <div class="text-slate-500 text-sm">{{ $email }}</div>
                <div class="text-slate-500 text-sm">
                    Desa/Kel {{ $kelurahan }}
                </div>
            </div>
            <div>
                <x-modal wire:model="modalConfirm" title="AMBIL DATA" subtitle="Konfirmasi" separator>
                    <div>Yakin akan mengambil data?</div>

                    <x-slot:actions>
                        <x-button label="Cancel" @click="$wire.modalConfirm = false" />
                        <x-button wire:click='createData' label="Iya" spinner class="btn-success" />
                    </x-slot:actions>
                </x-modal>

                <x-button label="Ambil Data" @click="$wire.modalConfirm = true"
                    class="btn-success h-10 btn-sm text-white" icon="o-cloud-arrow-up" />

            </div>
        </div>
        <div class="flex flex-col items-center min-h-screen p-10">

            <div class="text-center mt-12">
                <x-icon name="o-exclamation-triangle" class="h-12 text-slate-400" />
            </div>
            <p class=" text-gray-500 text-center mt-4">Belum ada data keluarga yang tersedia. Silahkan tekan tombol
                "Ambil Data"</p>
        </div>
    </div>

    {{-- Blok content IF True Data--}}
    <div x-show="datakeluarga.length>0">
        
        <div wire:loading class="fixed right-3 top-20">
            <x-loading class="loading-dots text-gray-500" />
        </div>

        <div class="mb-2 mt-3  px-4">
            <div class=" font-bold">DAFTAR KELUARGA</div>    
            <div class="text-gray-500 text-sm">Data keluarga untuk dimutakhirkan</div>
        </div> 

        
        <div class="flex gap-2 w-full px-2 py-4 justify-evenly overflow-auto">
            <button @click="keluargaUpServer; individuUpServer" class="rounded-lg shadow-sm w-full justify-between px-4 py-2 flex items-center text-sm bg-emerald-600 hover:bg-emerald-700 dark:bg-base-100">
                <div class="w-full">
                    <div class="font-semibold text-white mb-1 text-start">Data offline</div>
                    <div class="text-sm flex items-center   text-emerald-100 text-start">
                            <span class="badge badge-sm me-2 font-semibold  text-xs" x-text="keluarga_updated.length"></span>
                            <span class="me-4">Data Keluarga</span>

                            <span class="badge badge-sm ms-3 me-2 font-semibold  text-xs" x-text="individu_updated.length"></span>
                            <span class="me-4">Data Individu</span>
                        </div>
                    </div>
                    <x-icon name="o-arrow-path" class="ms-2 h-6 w-6 p-0 text-yellow-300"></x-icon>
            </button>

        </div>

        <div class="flex gap-1 w-full px-2 mb-5 mt-1 overflow-auto">
            <div class="bg-base-100 border flex gap-2 hover:bg-base-300 hover:scale-95 transition-all duration-500 w-auto items-center rounded-xl px-3 py-4">
                <div>
                    <x-icon name="o-clipboard-document-list" class="h-7 text-amber-500"></x-icon>
                </div>
                <div>
                    <div class="text-xs text-nowrap pe-2">Total Keluarga</div>
                    <div class="text-xl font-bold" x-text="datakeluarga.length"></div>
                    <div class="text-xs text-slate-500 text-nowrap">Kawasan enumerator</div>
                </div>
            </div>
            <div class="bg-base-100 border flex gap-2 hover:bg-base-300 hover:scale-95 transition-all duration-500 w-auto items-center rounded-xl px-3 py-4">
                <div>
                    <x-icon name="o-users" class="h-7 text-pink-500"></x-icon>
                </div>
                <div>
                    <div class="text-xs text-nowrap pe-2">Total Individu</div>
                    <div class="text-xl font-bold" x-text="dataindividu.length"></div>
                    <div class="text-xs text-slate-500 text-nowrap">Kawasan enumerator</div>
                </div>
            </div>
            <div @click="$wire.modalList = true; showList(keluarga_insertserver, 'DATA KELUARGA DIKIRIM KE SERVER')" class="bg-base-100 border flex gap-2 hover:bg-base-300 hover:scale-95 transition-all duration-500 w-auto items-center rounded-xl px-3 py-4">
                <div>
                    <x-icon name="o-document-check" class="h-7 text-green-500"></x-icon>
                </div>
                <div>
                    <div class="text-xs text-nowrap">Data ke server</div>
                    <div class="text-xl font-bold" x-text="keluarga_insertserver.length+' / '+individu_insertserver.length"></div>
                    <div class="text-xs text-slate-500">Keluarga/Individu</div>
                </div>
            </div>
            <div @click="$wire.modalList = true; showList(keluarga_created, 'DATA KELUARGA BARU DITAMBAHKAN')" class="bg-base-100 border flex gap-2 hover:bg-base-300 hover:scale-95 transition-all duration-500 w-auto items-center rounded-xl px-3 py-4">
                <div>
                    <x-icon name="o-arrow-trending-up" class="h-7 text-indigo-500"></x-icon>
                </div>
                <div>
                    <div class="text-xs text-nowrap">Data ditambahkan</div>
                    <div class="text-xl font-bold" x-text="keluarga_created.length+' / '+individu_created.length"></div>
                    <div class="text-xs text-slate-500">Keluarga/Individu</div>
                </div>
            </div>
            <div @click="$wire.modalList = true; showList(menolak, 'KELUARGA MENOLAK MEMBERI JAWABAN')" class="bg-base-100 border flex gap-2 hover:bg-base-300 hover:scale-95 transition-all duration-500 w-auto items-center rounded-xl px-3 py-4">
                <div>
                    <x-icon name="o-hand-thumb-down" class="h-7 text-pink-500"></x-icon>
                </div>
                <div>
                    <div class="text-xs text-nowrap">Keluarga menolak</div>
                    <div class="text-xl font-bold" x-text="menolak.length"></div>
                    <div class="text-xs text-slate-500">Tidak bersedia</div>
                </div>
            </div>
            
        </div>


        <div class="border-b bg-base-100 mt-7 rounded-lg flex w-full items-center">
            <div class="w-full">
                <x-input x-model="searchKeluarga" icon="o-bolt"
                class="py-0 mt-1 px-3 w-full border-none rounded-none h-11 text-sm" placeholder="Search..."/>
            </div>
            <span class="text-center text-xs sm:text-sm outline-none text-nowrap ms-auto px-3 text-emerald-600" x-text="filterKeluarga().length+ ' KK'"></span>
        </div>



        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 sm:gap-4">
            <template x-for="(item, i) in filterKeluarga()" x-key="i">
                <div x-bind:class="item.updated ? 'bg-purple-50 dark:bg-base-200' : 'bg-base-100'"
                    class="bg-base-100 ps-5 pe-2 py-5 md:p-5 border-b sm:border sm:rounded-lg  hover:border-indigo-400 hover:bg-base-200 cursor-pointer dark:border-slate-600">
                    <a x-ref wire:navigate x-bind:href="$wire.url+item.id">
                        <div class="flex items-center justify-between">
                            <div class="w-full">
                                <div x-text="item.items.nama ? item.items.nama : item.items.nomor_kk"
                                    class="text-sm font-bold dark:text-indigo-50 uppercase mb-2"></div>
                                <div x-text="item.items.nomor_kk ? 'No.KK '+item.items.nomor_kk : 'ID-KK '+item.items.id_keluarga"
                                    class="text-xs text-slate-500 dark:text-slate-400"></div>
                                <div class="text-xs mt-2 text-base-350">
                                    <span x-text="'Desa/Kel. '+item.items.kelurahan" class="border-r pe-2"></span>
                                    <span x-text="'KEC. '+item.items.kecamatan" class="border-r px-2">Kec. Atiolo</span>
                                    <span x-text="'KAB. '+item.items.kabkota" class="px-2">Kab. Prancis</span>
                                </div>
                            </div>  
                            <div class="p-0">
                                <x-icon x-show="!item.updated" class="h-4 text-slate-400" name="o-chevron-right" />
                                <x-icon x-show="item.updated" class="h-5 text-orange-500 pe-1" name="s-arrow-path" />
                            </div>
                        </div>
                    </a>
                </div>
            </template>
        </div>




        <x-modal wire:model="modalConfirmtwo" title="Reload data" subtitle="Warning!">
            <x-form wire:submit="confirmPassword">
                <div>Reload data akan mengambil kembali data Keluarga dari server dan secara otomatis akan <b
                        class="text-red-500">Menghapus</b> perubahan yang telah dibuat pada penyimpanan local Anda.
                </div>
                <div class="mt-3">
                    <div class="text-sm text-slate-500">Konfirmasi Password</div>
                    <x-password wire:model="password" right />
                </div>
                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.modalConfirmtwo = false" />
                    <x-button type="submit" label="Iya" spinner="confirmPassword" class="btn-success" />
                </x-slot:actions>
            </x-form>
        </x-modal>



        <x-modal wire:model="modalAddKeluarga" title="Keluarga Baru"
            subtitle="Form untuk menambahkan data Keluarga baru">
            <x-form @submit.prevent="addDataKeluarga; $wire.modalConfirmtwo = false">
                <div x-data="getDataForm()" x-init="getData" x-effect="getIdKeluarga">
                    
                    <x-input inline @keyup="itemAddKeluarga.nama = nama" x-model="nama" label="Nama Kepala Keluarga" required class="mb-1" id="nama" />
                    <x-input inline @keyup="itemAddKeluarga.nik = nik" x-model="nik" label="NIK" required class="mb-1" id="nik" />
                    <x-input inline @keyup="itemAddKeluarga.nomor_kk = nomor_kk" x-model="nomor_kk" label="Nomor KK" required class="mb-1" id="nomorkk" />
                    <x-input inline readonly x-bind:value="itemAddKeluarga.rt" label="RT/Dusun" placeholder="RT/Dusun" required class="mb-1" id="kel" />
                    <x-input inline readonly x-bind:value="itemAddKeluarga.kelurahan" label="Desa/Keluarhan" placeholder="Kelurahan" required class="mb-1" id="kel" />
                    <x-input inline readonly x-bind:value="itemAddKeluarga.kecamatan" label="Kecamatan" placeholder="Kecamatan" required class="mb-1" id="kec" />
                    <x-input inline readonly x-bind:value="itemAddKeluarga.kabkota" label="Kabupaten" placeholder="Kabupaten" required class="mb-1" id="kab" />
                </div>

                <x-slot:actions>
                    <x-button x-ref="closeModal" label="Tutup" @click="$wire.modalAddKeluarga = false" />
                    <x-button type="submit" label="Tambahkan" class="btn-success" />
                </x-slot:actions>
            </x-form>
        </x-modal>


        <x-modal wire:model="modalList" class="backdrop-blur">
            <div class="mb-5">
                <div class="font-bold mb-4" x-text="showDataList_title"></div>
                <div class="text-slate-500 flex font-light justify-between text-sm border-b pb-1">
                    <div class="">Daftar keluarga</div>
                    <x-icon class="h-4" name="m-list-bullet" class=""></x-icon>
                </div>
                <template x-for="(item, i) in showDataList" x-key="i">
                    <div x-bind:class="item.updated ? 'bg-purple-50 dark:bg-base-200' : 'bg-base-100'"
                        class="bg-base-100 pe-2 py-4 md:p-5 border-b sm:border sm:rounded-lg  hover:border-indigo-400 hover:bg-base-200 cursor-pointer dark:border-slate-600">
                        <a x-ref wire:navigate x-bind:href="$wire.url+item.id">
                            <div class="flex items-center justify-between">
                                <div class="w-full">
                                    <div x-text="item.items.nama ? item.items.nama : item.items.nomor_kk"
                                        class="text-sm font-bold dark:text-indigo-50 uppercase mb-2"></div>
                                    <div x-text="item.items.nomor_kk ? 'No.KK '+item.items.nomor_kk : 'ID-KK '+item.items.id_keluarga"
                                        class="text-xs text-slate-500 dark:text-slate-400"></div>
                                    <div class="text-xs mt-2 text-base-350">
                                        <span x-text="'Desa/Kel. '+item.items.kelurahan" class="border-r pe-2"></span>
                                        <span x-text="'KEC. '+item.items.kecamatan" class="border-r px-2">Kec. Atiolo</span>
                                        <span x-text="'KAB. '+item.items.kabkota" class="px-2">Kab. Prancis</span>
                                    </div>
                                </div>  
                                
                            </div>
                        </a>
                    </div>
                </template>
            </div>
            <x-button class="btn-sm h-9 btn-outline" label="Tutup" @click="$wire.modalList = false" />
        </x-modal>
    

        <x-button @click="$wire.modalAddKeluarga = true" icon="s-user-group"
            class="btn-circle btn-sm h-14 w-14 z-50 text-white shadow bg-emerald-500 hover:bg-emerald-600 fixed bottom-5 right-3" />

        @livewire('components.toast')


    </div>

</div>


<script>

 function getDataForm(){
    return {
        nomor_kk:'',
        nama:'',
        nik:'',

        getData(){

            if (localStorage.getItem('wil_kel')) {
                const kode = '{!!Auth::user()->kode_kel!!}';
                const datakel = JSON.parse(localStorage.getItem('wil_kel'));
                const datakec = JSON.parse(localStorage.getItem('wil_kec'));
                const datakab = JSON.parse(localStorage.getItem('wil_kab'));
                
                const getkel = datakel.find(k => k.kode_kel == kode);
                const getkec = datakec.find(k => k.kode_kec == getkel.kode_kec);
                const getkab = datakab.find(k => k.kode_kab == getkec.kode_kab);

                this.itemAddKeluarga.rt = {!! Auth::user()->rt!!};
                this.itemAddKeluarga.kelurahan = getkel.kelurahan;
                this.itemAddKeluarga.kode_kel = getkel.kode_kel;
                this.itemAddKeluarga.kecamatan = getkec.kecamatan;
                this.itemAddKeluarga.kode_kec = getkec.kode_kec;
                this.itemAddKeluarga.kabkota = getkab.kabkota;
                this.itemAddKeluarga.kode_kab = getkab.kode_kab;

                
            }
            
        },
        getIdKeluarga(){
            const sekarang = new Date();
            const tahun = sekarang.getFullYear();
            const bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
            const tanggal = String(sekarang.getDate()).padStart(2, '0');
            const jam = String(sekarang.getHours()).padStart(2, '0');
            const menit = String(sekarang.getMinutes()).padStart(2, '0');
            const detik = String(sekarang.getSeconds()).padStart(2, '0');
            const milidetik = String(sekarang.getMilliseconds()).padStart(3, '0');
            
            // Gabungkan elemen waktu untuk membentuk kode unik
            this.itemAddKeluarga.id_keluarga = parseInt(`${tahun}${bulan}${tanggal}${jam}${menit}${detik}`);

            
        }
    }
        
}


function getReferensiData(item_name) {
    if (localStorage.getItem(item_name)) {
        // console.log(JSON.parse(localStorage.getItem(item_name)));
        return this.results = JSON.parse(localStorage.getItem(item_name));
        
    }
}


</script>
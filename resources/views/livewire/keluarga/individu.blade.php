<div x-data="crudIndex" class="sm:p-5 md:p-7 p-2 pb-12" x-init="getDataFromIndexedDB(),getKeluargaId(getId())">

    <div class="flex justify-between gap-3 items-center px-2 mb-8 pt-16 mt-3">
        <div>
            <x-icon name="s-user-group" class="bg-purple-400  dark:text-slate-800 p-2 rounded h-9" />
        </div>
        <div class="w-full">
            <div class="font-bold uppercase">Anggota Keluarga</div>
            <div class="text-xs font-semibold mt-1 uppercase" x-text="itemskeluarga.nama"></div>
            <div class="flex items-center mt-1 text-purple-500">
                <x-icon name="o-user" class="h-3 me-1" />
                <div x-text="itemskeluarga.jenis_kelamin == 'L' ? 'Pria' : 'Wanita'" class="text-xs me-4"></div>
                <x-icon name="o-calendar-days" class="h-3 me-1" />
                <div x-text="'Lahir '+itemskeluarga.tanggal_lahir" class="text-xs me-4"></div>
                <x-icon name="o-key" class="h-3 me-1" />
                <div x-text="itemskeluarga.nomor_kk ? 'KK '+itemskeluarga.nomor_kk : 'ID Keluarga '+itemskeluarga.id_keluarga"
                    class="text-xs"></div>
            </div>
        </div>

    </div>

    <div class="mb-1">
        <x-input x-model="searchAnggota" icon="o-bolt" class="py-0 mt-1 px-3 border border-base-100 rounded-xl me-1 md:mt-4 h-11 text-sm"
            placeholder="Search..." />
    </div>

    <div x-data="getRef" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 sm:gap-4">
        <template x-for="(item, i) in filterAnggota()" x-key="i" >
            <div
                class="bg-base-100 ps-5 pe-2 py-5 md:p-5 rounded-xl border-x border-b sm:border  hover:border-indigo-400 hover:bg-base-200 cursor-pointer dark:border-slate-600">
                <a x-ref wire:navigate x-bind:href="'/individu/show?id='+item.id">
                    <div class="flex items-center justify-between">
                        <div class="w-full">
                            <div x-text="item.items.nama" class="text-sm font-bold dark:text-indigo-50 uppercase mb-2"></div>
                            <div x-text="'NIK. '+item.items.nik" class="text-xs mt-0 text-slate-500 dark:text-slate-400"></div>
                            <div x-text="item.items.tanggal_lahir ? 'Lahir '+item.items.tanggal_lahir : ''" class="text-xs text-slate-500 dark:text-slate-400"></div>
                            <div class="text-xs mt-2 text-base-350 text-indigo-500">
                                <span x-text="item.items.jenis_kelamin == 'P' ? 'Wanita' : 'Pria'" class="border-r pe-2">Pria</span>
                                <span x-text="item.items.id_hubungan_keluarga ? getHubungan(item.items.id_hubungan_keluarga) : ''" class="border-r px-2"></span>
                                <span x-show="item.items.status_bekerja" x-text="item.items.status_bekerja" class="border-r px-2"></span>
                                <span x-text="item.items.id_status_nikah ? getNikah(item.items.id_status_nikah) : ''" class="px-2"></span>
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


    <div x-data="{kelamin: 'L', idindividu: idIndividu(), }">
        <x-modal wire:model="modalAddIndividu" title="Individu Baru" subtitle="Form untuk menambahkan data Individu baru">
            <x-form @submit.prevent="addDataIndividu">
                <div  x-effect="itemAddIndividu.id_individu = idindividu" class="flex flex-col gap-3">
                    <x-input x-model="itemAddIndividu.nama" label="Nama Individu" inline required />
                    <x-input x-model="itemAddIndividu.nik" label="NIK" inline required />
                    <div class="flex gap-2"  x-effect="itemAddIndividu.jenis_kelamin = kelamin">
                        <label for="kelamin" class="inline-flex items-center gap-2 me-4">Jenis Kelamin </label>
                        <input @click="kelamin='L'" x-bind:checked="kelamin == 'L'" type="radio" required />
                        <span class="me-3">Pria</span>
                        <input @click="kelamin='P'" x-bind:checked="kelamin == 'P'" type="radio" required />
                        <span>Wanita</span>
                    </div>
                    <x-input x-effect="itemAddIndividu.id_keluarga = itemskeluarga.id_keluarga" readonly label="Nama Kepala Keluarga" x-bind:value="itemskeluarga.nama" inline required />

                </div>
            
                <x-slot:actions>
                    <x-button x-ref="closeModal" label="Tutup" @click="$wire.modalAddIndividu = false" />
                    <x-button type="submit" label="Tambah Individu" class="btn-success"   />
                </x-slot:actions>
            </x-form>
        </x-modal>
    </div>



    <x-button @click="$wire.modalAddIndividu = true" icon="s-user-plus"
        class="btn-circle btn-sm h-14 w-14 z-50 dark:text-slate-800 shadow bg-purple-300 hover:bg-purple-500 fixed bottom-5 right-3" />

    @livewire('components.toast')

</div>



<script>
    function getId(){
        const params = new URLSearchParams(window.location.search);
        console.log(params.get('id'));
        
        return params.get('id'); 
    }


    function getReferensiData(item_name) {
        if (localStorage.getItem(item_name)) {
            // console.log(JSON.parse(localStorage.getItem(item_name)));
            return this.results = JSON.parse(localStorage.getItem(item_name));
            
        }
    }

    function getRef(){
        return {
            getHubungan(id)
            {
                if (localStorage.getItem('ref_hubungan_keluarga')) {
                    // console.log(JSON.parse(localStorage.getItem(item_name)));
                    const results = JSON.parse(localStorage.getItem('ref_hubungan_keluarga'));
                    return results.length>0 ? results.find(item => item.id_hubungan_keluarga == id).hubungan_keluarga : '';
                }
            },
            getNikah(id)
            {
                if (localStorage.getItem('ref_status_nikah')) {
                    // console.log(JSON.parse(localStorage.getItem(item_name)));
                    const results = JSON.parse(localStorage.getItem('ref_status_nikah'));
                    return results.length>0 ? results.find(item => item.id_status_nikah == id).status_nikah : '';
                }
            },
            
           
        }
    }



    function idIndividu() {
            
                    const sekarang = new Date();
                    const tahun = sekarang.getFullYear().toString();
                    const bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
                    const tanggal = String(sekarang.getDate()).padStart(2, '0');
                    const jam = String(sekarang.getHours()).padStart(2, '0');
                    const menit = String(sekarang.getMinutes()).padStart(2, '0');
                    const detik = String(sekarang.getSeconds()).padStart(2, '0');
                    const milidetik = String(sekarang.getMilliseconds()).padStart(3, '0');

                    // Gabungkan elemen waktu untuk membentuk kode unik
                    const d = `${tahun}${bulan}${tanggal}${jam}${menit}${detik}`;
                    return  parseInt(d);
                  
        }
</script>
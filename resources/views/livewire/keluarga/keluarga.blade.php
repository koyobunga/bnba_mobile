<div x-data="crudIndex" class="sm:p-5 md:p-7 min-h-screen" x-init="getKeluargaId(getId())">
    
    <div class="mb-2 px-6  pt-12 mt-6">
        <div x-text="itemskeluarga.nama" class="text-lg font-bold uppercase"></div>
        <div class="flex itemskeluarga-center items-center text-slate-500 mt-1">
            <div x-text="'DESA/KEL. '+itemskeluarga.kelurahan+', KEC. '+itemskeluarga.kecamatan+', KAB. '+itemskeluarga.kabkota" class="text-xs"></div>
        </div>
        <div class="flex items-center mt-2 text-emerald-500">
            <x-icon name="o-user-circle" class="h-4 me-1" />
            <span class="text-xs me-3">Kepala Keluarga</span>
            <x-icon name="o-heart" class="h-4 me-1" />
            <div x-text="itemskeluarga.jenis_kelamin == 'L' ? 'Pria' : 'Wanita'" class="text-xs me-4"></div>
            <x-icon name="o-key" class="h-4 me-1" />
            <div x-text="!itemskeluarga.nomor_kk ? 'NIK. '+itemskeluarga.nik : 'KK '+itemskeluarga.nomor_kk" class="text-xs"></div>
        </div>
    </div>
    


    <div class="mt-4">&nbsp;</div>
    <template x-if="currentkeluarga.created == true && currentkeluarga.insertserver == false">
        <div class="text-end mb-1">
            <x-button @click="$wire.modalHapus = true" icon-right="o-trash" class="btn-sm h-9 btn-outline btn-error me-2  text-xs" label="Hapus Keluarga"></x-button>
        </div>
    </template>

    <x-modal wire:model="modalHapus" title="Hapus data !">
        <div x-text="'Yakin akan menghapus data '+itemskeluarga.nama+'?'"></div>
     
        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.modalHapus = false" />
            <x-button @click="deleteKeluarga(currentkeluarga.id)" label="Ya, hapus" class="btn-error" />
        </x-slot:actions>
    </x-modal>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 sm:gap-4">

        <a wire:navigate x-bind:href="$wire.url+currentkeluarga.id" as="tempattinggal">
            <div
                class="flex hover:bg-base-200 h-full cursor-pointer gap-4 items-center p-5 border-b sm:rounded-lg sm:border bg-base-100">
                <div>
                    <x-icon name="s-map-pin" class="text-pink-500 h-6" />
                </div>

                <div class="w-full">
                    <div class="font-semibold">
                        Keterangan Tempat Tinggal
                    </div>
                    <div class="text-slate-500 mt-1 text-sm">
                        Input informasi tempat tinggal
                    </div>
                </div>

                <div class="">
                    <x-icon name="o-chevron-right" class="h-4 text-slate-400" />
                </div>
            </div>
        </a>
        <a wire:navigate x-bind:href="$wire.urlperuhan+currentkeluarga.id" as="perumahan">
            <div
                class="flex hover:bg-base-200 h-full cursor-pointer gap-4 items-center p-5 border-b sm:rounded-lg sm:border bg-base-100">
                <div>
                    <x-icon name="s-home-modern" class="text-green-600 h-6" />
                </div>

                <div class="w-full">
                    <div class="font-semibold">
                        Perumahan
                    </div>
                    <div class="text-slate-500 mt-1 text-sm">
                        Input informasi perumahan
                    </div>
                </div>

                <div class="">
                    <x-icon name="o-chevron-right" class="h-4 text-slate-400" />
                </div>
            </div>
        </a>
        <a wire:navigate x-bind:href="$wire.urlsosial+currentkeluarga.id"  as="sosial">
            <div
                class="flex hover:bg-base-200 h-full cursor-pointer gap-4 items-center p-5 border-b sm:rounded-lg sm:border bg-base-100">
                <div>
                    <x-icon name="s-document-currency-pound" class="text-teal-500 h-6" />
                </div>

                <div class="w-full">
                    <div class="font-semibold">
                        Sosial Ekonomi Penduduk
                    </div>
                    <div class="text-slate-500 mt-1 text-sm">
                        Input informasi sosial, ekonomi dan penduduk
                    </div>
                </div>

                <div class="">
                    <x-icon name="o-chevron-right" class="h-4 text-slate-400" />
                </div>
            </div>
        </a>
        <a wire:navigate x-bind:href="$wire.urlaset+currentkeluarga.id"  as="aset">
            <div
                class="flex hover:bg-base-200 h-full cursor-pointer gap-4 items-center p-5 border-b sm:rounded-lg sm:border bg-base-100">
                <div>
                    <x-icon name="s-briefcase" class="text-indigo-500 h-6" />
                </div>

                <div class="w-full">
                    <div class="font-semibold">
                        Keikutsertaan Program, Kepemilikan Aset dan Layanan
                    </div>
                    <div class="text-slate-500 mt-1 text-sm">
                        Input informasi keikutsertaan program, kepemilikan aset dan Layanan
                    </div>
                </div>

                <div class="">
                    <x-icon name="o-chevron-right" class="h-4 text-slate-400" />
                </div>
            </div>
        </a>
        <a wire:navigate x-bind:href="$wire.urlindividu+currentkeluarga.id"  as="inividu">
            <div
                class="flex h-full cursor-pointer gap-4 items-center p-5 border-b sm:rounded-lg sm:border bg-base-100 hover:bg-base-200">
                <div>
                    <x-icon name="s-user-group" class="text-purple-400 h-6" />
                </div>

                <div class="w-full">
                    <div class="font-semibold">
                        Anggota Keluarga
                    </div>
                    <div class="text-slate-500 mt-1 text-sm">
                        Input anggota keluarga
                    </div>
                </div>

                <div class="">
                    <x-icon name="o-chevron-right" class="h-4 text-slate-400" />
                </div>
            </div>
        </a>


    </div>

    




</div>


<script>
    function getId(){
        const params = new URLSearchParams(window.location.search);
        console.log(params.get('id'));
        
        return params.get('id'); 
    }


  
    
</script>


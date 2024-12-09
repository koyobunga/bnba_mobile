<div x-data="crudIndex" class="sm:p-5 md:p-7 p-2 pb-12" x-init="getDataFromIndexedDB(),getIndividuId(getId())">

    <div class="flex gap-3 items-center px-2 pt-16 mt-3">
        <div>
            <x-icon name="s-user" class="bg-amber-200  dark:text-slate-800 p-2 rounded h-9" />
        </div>
        <div class="w-full">
            <div class="font-bold uppercase" x-text="itemsindividu.nama"></div>
            <div class="text-xs font-semibold mt-1 uppercase">Data Individu</div>
            <div class="flex items-center mt-2 text-amber-600">
                <x-icon name="o-user" class="h-3 me-1" />
                <div x-text="itemsindividu.jenis_kelamin == 'L' ? 'Pria' : 'Wanita'" class="text-xs me-4"></div>
                <x-icon name="o-calendar-days" class="h-3 me-1" />
                <div x-text="'Lahir '+itemsindividu.tanggal_lahir" class="text-xs me-4"></div>
                <x-icon name="o-key" class="h-3 me-1" />
                <div x-text="itemsindividu.nik ? 'NIK. '+itemsindividu.nik : 'ID Keluarga '+itemsindividu.id_keluarga"
                    class="text-xs"></div>
                
                </div>
        </div>
        
    </div>
    
    <div class="mt-5">&nbsp;</div>
    
    <template x-if="currentindividu.created == true && currentindividu.insertserver == false">
        <div class="text-end mb-1">
            <x-button @click="$wire.modalHapus = true" icon-right="o-trash" class="btn-sm h-9 btn-error btn-outline text-xs" label="Hapus data ini"></x-button>
        </div>
    </template>

    <x-modal wire:model="modalHapus" title="Hapus Individu !">
        <div x-text="'Yakin, akan menghapus data '+itemsindividu.nama+'?'"></div>
     
        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.modalHapus = false" />
            <x-button @click="deleteIndividu(currentindividu.id)" label="Ya, hapus" class="btn-error" />
        </x-slot:actions>
    </x-modal>




    <x-tabs wire:model="selectedTab"   
    active-class="bg-amber-200 rounded text-slate-700 h-full px-3"
    label-class="font-semibold px-3 text-sm w-full h-full"
    label-div-class="bg-base-100 h-10 rounded inline-flex w-full overflow-x-auto shadow-lg">
    <x-tab name="users-tab" label="Demografi">
       <div class="-mt-3 -mx-1">
        <x-card>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                <div x-data="{nama: ''}">
                    <div class="font-semibold">Nama lengkap</div>
                    <x-input @keyup="itemsindividu.nama = nama" x-model="nama" x-bind:value="itemsindividu.nama" class="input-sm h-9" />
                </div>
                <div x-data="{nik: ''}">
                    <div class="font-semibold">NIK</div>
                    <x-input @keyup="itemsindividu.nik = nik" x-model="nik" x-bind:value="itemsindividu.nik" class="input-sm h-9" />
                </div>
                <div x-data="{tempat_lahir: ''}">
                    <div class="font-semibold">Tempat lahir</div>
                    <x-input @keyup="itemsindividu.tempat_lahir = tempat_lahir" x-model="tempat_lahir" x-bind:value="itemsindividu.tempat_lahir" class="input-sm h-9" />
                </div>
                <div x-data="{tanggal_lahir:''}">
                    <div class="font-semibold">Tanggal lahir</div>
                    <x-datetime @change="itemsindividu.tanggal_lahir = tanggal_lahir" x-model="tanggal_lahir" x-bind:value="itemsindividu.tanggal_lahir" icon="o-calendar" class="input-sm h-9" />
                </div>
                <div x-data="{
                    kelamin: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Pria',
                             id: 'L'
                         },
                         {
                             name: 'Wanita',
                             id: 'P'
                         }
                        ]
                    }"
                    x-effect="itemsindividu.jenis_kelamin == 'L' ? itemsindividu.status_hamil='' : ''">
                    <span class="font-semibold">Jenis kelamin</span>
                    <select @change="itemsindividu.jenis_kelamin = kelamin" id="select-option" x-model="kelamin" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="d in data">
                            <option x-bind:selected="itemsindividu.jenis_kelamin == d.id" x-bind:value="d.id" x-text="d.name"></option>
                        </template>
                    </select>
                </div>
            </div>
        </x-card>

        <x-card class="mt-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1 sm:gap-2">

                <div x-data="{hubungan: null}">
                    <span class="font-semibold">Hubungan dengan kepala keluarga</span>
                    <select @change="itemsindividu.id_hubungan_keluarga = parseInt(hubungan)" id="select-option" x-model="hubungan" required>
                        <option value="" >Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_hubungan_keluarga')" x-key="i">
                            <option x-bind:selected="itemsindividu.id_hubungan_keluarga == d.id_hubungan_keluarga" x-bind:value="d.id_hubungan_keluarga" x-text="d.hubungan_keluarga"></option>
                        </template>
                    </select>
                </div>


                <div x-data="{ keberadaan: 1 }">
                    <span class="font-semibold">Keterangan keberadaan anggota keluarga</span>
                    <select @change="itemsindividu.id_keberadaan_individu = parseInt(keberadaan)" id="select-option" x-model="keberadaan" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_keberadaan_individu')" x-key="i">
                            <option x-bind:selected="itemsindividu.id_keberadaan_individu == d.id_keberadaan_individu" x-bind:value="d.id_keberadaan_individu" x-text="d.keberadaan_individu"></option>
                        </template>
                    </select>
                </div>
                
                <div x-data="{ status_nikah: 1 }"
                    x-effect="itemsindividu.id_status_nikah == 1 ? itemsindividu.umur_saat_nikah = '' : ''">
                    <span class="font-semibold">Status nikah</span>
                    <select @change="itemsindividu.id_status_nikah = parseInt(status_nikah)" id="select-option" x-model="status_nikah" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_status_nikah')" x-key="i">
                            <option x-bind:selected="itemsindividu.id_status_nikah == d.id_status_nikah" x-bind:value="d.id_status_nikah" x-text="d.status_nikah"></option>
                        </template>
                    </select>
                </div>
                
                <div x-show="itemsindividu.id_status_nikah != 1" x-data="{ umur_saat_nikah: 1 }">
                    <div x-data="{umur_saat_nikah: ''}">
                        <span class="font-semibold">Umur saat nikah</span>
                        <x-input @keyup="itemsindividu.umur_saat_nikah = umur_saat_nikah" x-model="umur_saat_nikah" x-bind:value="itemsindividu.umur_saat_nikah" class="input-sm mt-1 h-9" />
                    </div>
                </div>

                <div x-show="itemsindividu.jenis_kelamin == 'P' && itemsindividu.id_status_nikah != 1" x-data="{
                    data: [
                        //insert data array
                        {
                                name: 'Ya',
                                id: 1
                            },
                            {
                                name: 'Tidak',
                                id: 2
                            },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-2">Apakah <span x-text="itemsindividu.nama"></span> sedang hamil?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.status_hamil = d.name" x-bind:checked="itemsindividu.status_hamil == d.name" type="radio"/>
                                    <label x-text='d.name' class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                

            </div>

        </x-card>
       </div>

    </x-tab>


    {{-- TAB 2 --}}
    <x-tab name="tricks-tab" label="Pendidikan" class="">
        <div class="bg-blue-100 dark:bg-gray-800 col-span-full rounded-lg border items-center -mt-3 -mx-1 flex gap-3 p-4">
            <div>    
                <x-icon name="o-academic-cap" class="h-7"></x-icon>
            </div>
            <div>
                Blok pendidikan untuk Individu yang berusia 3 tahun keatas
            </div>
        </div>
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-3 -mx-1">
            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Apakat <span x-text="itemsindividu.nama"></span> masih bersekolah?</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_bersekolah')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input  @click="itemsindividu.id_bersekolah = parseInt(d.id_bersekolah)" x-bind:checked="d.id_bersekolah == itemsindividu.id_bersekolah" type="radio"/>
                                    <label x-text='d.bersekolah'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card 
                x-show="itemsindividu.id_bersekolah != 1"
                x-effect="itemsindividu.id_bersekolah == 1 ? itemsindividu.kode_jenjang_pendidikan=null : ''">
                <div x-data="{
                    jenjang_pendidikan: 1,
                    }">
                    <span x-show="itemsindividu.id_bersekolah == 3" class="font-semibold">Jenjang pendidikan terakhir yang pernah diikuti?</span>
                    <span x-show="itemsindividu.id_bersekolah == 2" class="font-semibold">Jenjang pendidikan saat ini?</span>
                    <select @change="itemsindividu.kode_jenjang_pendidikan = jenjang_pendidikan" id="select-option" x-model="jenjang_pendidikan" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_jenjang_pendidikan')" x-key="i">
                            <option x-bind:selected="itemsindividu.kode_jenjang_pendidikan == d.kode_jenjang_pendidikan" x-bind:value="d.kode_jenjang_pendidikan" x-text="d.jenjang_pendidikan"></option>
                        </template>
                    </select>
                </div>
            </x-card>
            
            <x-card
                x-show="itemsindividu.id_bersekolah != 1"    
                x-effect="itemsindividu.id_bersekolah == 1 ? itemsindividu.tingkat_penddikan=null : ''">
                <div x-data="{
                    tingkat_penddikan: 1,
                    data: [
                       //insert data array
                        {
                             name: '1',
                             id: 1,
                             hidden: false,
                         },
                         {
                             name: '2',
                             id: 2,
                             hidden: false,
                         },
                         {
                             name: '3',
                             id: 3,
                             hidden: false,
                         },
                         {
                             name: '4',
                             id: 4,
                             hidden: false,
                         },
                         {
                             name: '5',
                             id: 5,
                             hidden: false,
                         },
                         {
                             name: '6',
                             id: 6,
                             hidden: false,
                         },
                         {
                             name: '7',
                             id: 7,
                             hidden: false,
                         },
                         {
                             name: '8 (Tamat dan Lulus)',
                             id: 8,
                             hidden: false,
                         },
                        ],
                        getHidden(){
                            if(this.itemsindividu.id_bersekolah != 1 && ['18','19'].includes(this.itemsindividu.kode_jenjang_pendidikan))
                            {
                                this.data[0].hidden = false; this.data[1].hidden = false; this.data[2].hidden = false; this.data[3].hidden = false; this.data[4].hidden = false; this.data[5].hidden = true; this.data[6].hidden = true; this.data[7].hidden = false;
                            }
                            else if(this.itemsindividu.id_bersekolah != 1 && this.itemsindividu.kode_jenjang_pendidikan=='20')
                            {
                                this.data[0].hidden = false; this.data[0].name = '1 (Pernah/Sedang)'; this.data[1].hidden = true; this.data[2].hidden = true; this.data[3].hidden = true; this.data[4].hidden = true; this.data[5].hidden = true; this.data[6].hidden = true; this.data[7].hidden = false;
                            }
                            else if(this.itemsindividu.id_bersekolah != 1 && this.itemsindividu.kode_jenjang_pendidikan== '21')
                            {
                                this.data[0].hidden = true; this.data[1].hidden = true; this.data[2].hidden = true; this.data[3].hidden = true; this.data[4].hidden = true; this.data[5].hidden = false; this.data[5].name = '6 (Pernah/Sedang)'; this.data[6].hidden = true; this.data[7].hidden = false;
                            }
                            else if(this.itemsindividu.id_bersekolah != 1 && this.itemsindividu.kode_jenjang_pendidikan== '22')
                            {
                                this.data[0].hidden = true; this.data[1].hidden = true; this.data[2].hidden = true; this.data[3].hidden = true; this.data[4].hidden = true; this.data[5].hidden = true; this.data[6].hidden = false; this.data[6].name = '7 (Pernah/Sedang)';  this.data[7].hidden = false;
                            }
                            else
                            {
                                this.data[0].hidden = false; this.data[1].hidden = false; this.data[2].hidden = false; this.data[3].hidden = false; this.data[4].hidden = false; this.data[5].hidden = false; this.data[6].hidden = false; this.data[7].hidden = false;
                                this.data[0].name = '1'; this.data[1].name = '2'; this.data[2].name = '3'; this.data[3].name = '4'; this.data[4].name = '5'; this.data[5].name = '6'; this.data[6].name = '7'; this.data[7].name = '8 (Tamat dan Lulus)';
                            }
                        }
                    }"
                    x-effect="getHidden()">
                    <span x-show="itemsindividu.id_bersekolah == 2" class="font-semibold">Kelas/tingkat pendidikan tertinggi yang sedang diduduki</span>
                    <span x-show="itemsindividu.id_bersekolah == 3" class="font-semibold">Kelas/tingakat pendidikan tertinggi yang pernah diduduki</span>
                    <div class="flex flex-wrap gap-3 mt-3">
                    <template x-for="(d, i) in data" x-key="i">
                        <div class="flex gap-3 items-center">
                            <input x-bind:hidden="d.hidden" @click="itemsindividu.tingkat_pendidikan = parseInt(d.id)" x-bind:checked="d.id === itemsindividu.tingkat_pendidikan" type="radio"/>
                            <label x-bind:hidden="d.hidden" x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                        </div>
                    </template>
                    </div>
                </div>
            </x-card>

            <x-card 
                x-show="itemsindividu.id_bersekolah != 1"
                x-effect="itemsindividu.id_bersekolah == 1 ? itemsindividu.kode_ijazah=null : ''">
                <div x-data="{
                    kode_ijazah: 1,
                    }">
                    <span class="font-semibold">Ijazah/pendidikan terakhir yang ditamatkan?</span>
                    <select @change="itemsindividu.kode_ijazah = kode_ijazah" id="select-option" x-model="kode_ijazah" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_jenjang_pendidikan')" x-key="i">
                            <option x-bind:selected="itemsindividu.kode_ijazah == d.kode_jenjang_pendidikan" x-bind:value="d.kode_jenjang_pendidikan" x-text="d.jenjang_pendidikan"></option>
                        </template>
                    </select>
                </div>
            </x-card>

        </div>
    </x-tab>





    {{-- TAB 3 --}}
    <x-tab name="musics-tab" label="Pekerjaan">
        <div class="bg-red-100 dark:bg-gray-800 col-span-full rounded-lg border items-center -mt-3 -mx-1 flex gap-3 p-4">
            <div>    
                <x-icon name="o-wrench" class="h-7"></x-icon>
            </div>
            <div>
                Blok pekerjaan untuk Individu yang berusia 5 tahun keatas
            </div>
        </div>
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-3 -mx-1">
            <x-card>
                <div x-data="{
                    data: [
                       //insert data array
                        {
                             name: 'Bekerja',
                             id: 1
                         },
                         {
                             name: 'Tidak bekerja',
                             id: 2
                         },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Apakah <span x-text="itemsindividu.nama"></span> biasanya bekerja?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.status_bekerja = d.name" x-bind:checked="itemsindividu.status_bekerja == d.name" type="radio"/>
                                    <label x-text='d.name' class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card x-data="{jam_kerja: ''}">
                <div>
                    <div class="font-semibold">Total jam <span x-text="itemsindividu.nama"></span> biasanya bekerja dalam seminggu</div>
                    <input @keyup="itemsindividu.jumlah_jam_kerja_seminggu = parseInt(jam_kerja)" x-model="jam_kerja" x-bind:value="itemsindividu.jumlah_jam_kerja_seminggu" type="number" class="border border-primary rounded-lg px-3 py-1 w-full" placeholder="Jam Kerja" />
                </div>
            </x-card>

            <x-card x-data="{pekerjaan:''}">
                <div>
                    <span class="font-semibold">Apa pekerjaan utama (yang menghabiskan banyak waktu) <span x-text="itemsindividu.nama"></span></span>
                    <select @change="itemsindividu.kode_pekerjaan = pekerjaan" id="select-option" x-model="pekerjaan" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_pekerjaan')" x-key="i">
                            <option x-bind:selected="itemsindividu.kode_pekerjaan == d.kode_pekerjaan" x-bind:value="d.kode_pekerjaan" x-text="d.pekerjaan"></option>
                        </template>
                    </select>
                </div>
            </x-card>  
            
            <div x-data="dataBidangUsaha" class="bg-base-100 rounded-lg">
                <div @click="getData()">
                    <x-collapse class="rounded-lg border-none shadow-sm">
                        <x-slot:heading>
                            <span class="font-semibold text-[1rem]">Lapangan usaha atau bidang pekerjaan dari tempat kerja <span x-text="itemsindividu.nama"></span>?</span>
                        </x-slot:heading>
                        <x-slot:content>
                            <template x-if="items.length > 0">
                                <template x-for="(item, i) in items" x-key="i">
                                    <div class="flex gap-2 mt-2" x-init="getSelek(item.kode_bidang_usaha)">
                                        <x-checkbox @blur="klik"  x-model="selek" x-bind:value="item.kode_bidang_usaha" />
                                        <span x-text="item.bidang_usaha" class="text-sm"></span>
                                    </div>
                                </template>
                            </template>
                        </x-slot:content>
                    </x-collapse>
                </div>
            </div>  

            <x-card>
                <div x-data="{
                    status_kedudukan: 1,
                    }">
                    <span class="font-semibold">Status kedudukan dalam pekerjaan utama <span x-text="itemsindividu.nama"></span></span>
                    <select @change="itemsindividu.id_status_pekerjaan_utama = parseInt(status_kedudukan)" id="select-option" x-model="status_kedudukan" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_status_pekerjaan_utama')" x-key="i">
                            <option x-bind:selected="itemsindividu.id_status_pekerjaan_utama == d.id_status_pekerjaan_utama" x-bind:value="d.id_status_pekerjaan_utama" x-text="d.status_pekerjaan_utama"></option>
                        </template>
                    </select>
                </div>
            </x-card>  

            <x-card>
                <div x-data="{
                    npwp: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ada',
                             id: 1
                         },
                         {
                             name: 'Tidak ada',
                             id: 2
                         },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Apakah <span x-text="itemsindividu.nama"></span> memiliki NPWP?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.punya_npwp = d.name" x-bind:checked="d.name == itemsindividu.punya_npwp" type="radio" x-bind:value="d.name"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    usaha_sendiri: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Apakah <span x-text="itemsindividu.nama"></span> memiliki usaha sendiri/bersama?</div>
                        <div class="gap-3" x-effect="itemsindividu.punya_usaha_lainnya=='Tidak' ? itemsindividu.json_usaha_lainnya = [] : ''">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.punya_usaha_lainnya = d.name" x-bind:checked="d.name == itemsindividu.punya_usaha_lainnya" type="radio" x-bind:value="d.name"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </x-card>

            <div x-show="itemsindividu.punya_usaha_lainnya=='Ya'">
            <div 
                x-data="dataBidangUsahaLainnya" 
                class="bg-base-100 rounded-lg">
                <div @click="getData()">
                    <x-collapse class="rounded-lg border-none shadow-sm">
                        <x-slot:heading>
                            <span class="font-semibold text-[1rem]">Usaha dibidang apa?</span>
                        </x-slot:heading>
                        <x-slot:content>
                            <template x-if="items.length > 0">
                                <template x-for="(item, i) in items" x-key="i">
                                    <div class="flex gap-2 mt-2" x-init="getSelek(item.kode_bidang_usaha)">
                                        <x-checkbox @blur="klik"  x-model="selek" x-bind:value="item.kode_bidang_usaha" />
                                        <span x-text="item.bidang_usaha" class="text-sm"></span>
                                    </div>
                                </template>
                            </template>
                        </x-slot:content>
                    </x-collapse>
                </div>
            </div>
            </div>


            <x-card x-show="itemsindividu.punya_usaha_lainnya=='Ya'" > 
                <div x-data="{jumlah_usaha_lainnya: ''}" x-effect="itemsindividu.punya_usaha_lainnya=='Tidak' ? itemsindividu.jumlah_usaha_lainnya = null : ''">
                    <div class="font-semibold">Jumlah usaha sendiri/bersama yang dimiliki</div>
                    <input @keyup="itemsindividu.jumlah_usaha_lainnya = parseInt(jumlah_usaha_lainnya)" x-bind:value="itemsindividu.jumlah_usaha_lainnya" x-model="jumlah_usaha_lainnya" type="number" class="border border-primary rounded-lg px-3 py-1 w-full" />
                </div>
                <div x-data="{jumlah_pekerja_dibayar: ''}" x-effect="itemsindividu.punya_usaha_lainnya=='Tidak' ? itemsindividu.jumlah_pekerja_dibayar = null : ''" type="number" class="border border-primary rounded-lg px-3 py-1 w-full"/>
                    <div class="font-semibold">Jumlah pekerja yang dibayar</div>
                    <input @keyup="itemsindividu.jumlah_pekerja_dibayar = parseInt(jumlah_pekerja_dibayar)" x-bind:value="itemsindividu.jumlah_pekerja_dibayar" x-model="jumlah_pekerja_dibayar" type="number" class="border border-primary rounded-lg px-3 py-1 w-full" />
                </div>
                <div x-data="{jumlah_pekerja_tidak_dibayar: ''}" x-effect="itemsindividu.punya_usaha_lainnya=='Tidak' ? itemsindividu.jumlah_pekerja_tidak_dibayar = '' : ''">
                    <div class="font-semibold">Jumlah pekerja yang tidak dibayar</div>
                    <input @keyup="itemsindividu.jumlah_pekerja_tidak_dibayar = parseInt(jumlah_pekerja_tidak_dibayar)" x-bind:value="itemsindividu.jumlah_pekerja_tidak_dibayar" x-model="jumlah_pekerja_tidak_dibayar" type="number" class="border border-primary rounded-lg px-3 py-1 w-full"/>
                </div>
            </x-card> 
            
            
            <div x-show="itemsindividu.punya_usaha_lainnya=='Ya'">
                <div x-data="dataIjinUsaha" class="bg-base-100 rounded-lg" 
                    x-effect="itemsindividu.punya_usaha_lainnya=='Tidak' ? itemsindividu.json_perijinan_usaha = [] : ''">
                    <div @click="getData()">
                        <x-collapse class="rounded-lg border-none shadow-sm">
                            <x-slot:heading>
                                <span class="font-semibold text-[1rem]">Kepemilikan perijinan usaha?</span>
                            </x-slot:heading>
                            <x-slot:content>
                                <template x-if="items.length > 0">
                                    <template x-for="(item, i) in items" x-key="i">
                                        <div class="flex gap-2 mt-2" x-init="getSelek(item.id_perijinan_usaha)">
                                            <x-checkbox @blur="klik"  x-model="selek" x-bind:value="item.id_perijinan_usaha" />
                                            <span x-text="item.perijinan_usaha" class="text-sm"></span>
                                        </div>
                                    </template>
                                </template>
                            </x-slot:content>
                        </x-collapse>
                    </div>
                </div>
            </div>



            <x-card x-show="itemsindividu.punya_usaha_lainnya=='Ya'">
                <div x-data="{
                    omset_perbulan: 1,
                    }" 
                    x-effect="itemsindividu.punya_usaha_lainnya=='Tidak' ? itemsindividu.id_omzet_usaha = null : '' ">
                    <span class="font-semibold">Omset usaha perbulan?</span>
                    <select @change="itemsindividu.id_omzet_usaha = parseInt(omset_perbulan)" id="select-option" x-model="omset_perbulan" required>
                        <option value="">Pilih opsi...</option>
                        <template x-for="(d,i) in getReferensiData('ref_omzet_usaha')" x-key="i">
                            <option x-bind:selected="itemsindividu.id_omzet_usaha == d.id_omzet_usaha" x-bind:value="d.id_omzet_usaha" x-text="d.omzet_usaha"></option>
                        </template>
                    </select>
                </div>
            </x-card>


            <div x-show="itemsindividu.punya_usaha_lainnya=='Ya'">
                <div x-data="dataInternetUsaha" class="bg-base-100 rounded-lg" 
                    x-effect="itemsindividu.punya_usaha_lainnya=='Tidak' ? itemsindividu.json_kode_internet_usaha = [] : ''">
                    <div @click="getData()">
                        <x-collapse class="rounded-lg border-none shadow-sm">
                            <x-slot:heading>
                                <span class="font-semibold text-[1rem]">Untuk apa internet digunakan dalam kegiatan usaha?</span>
                            </x-slot:heading>
                            <x-slot:content>
                                <template x-if="items.length > 0">
                                    <template x-for="(item, i) in items" x-key="i">
                                        <div class="flex gap-2 mt-2" x-init="getSelek(item.kode_internet_usaha)">
                                            <x-checkbox @blur="klik"  x-model="selek" x-bind:value="item.kode_internet_usaha" />
                                            <span x-text="item.internet_usaha" class="text-sm"></span>
                                        </div>
                                    </template>
                                </template>
                            </x-slot:content>
                        </x-collapse>
                    </div>
                </div>
            </div>

        </div>
    </x-tab>

    {{-- TAB 4 --}}
    <x-tab name="stars-tab" label="Kesehatan">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 -mt-3 -mx-1">
            <div class="bg-green-100 dark:bg-gray-800 col-span-full rounded-lg border items-center flex gap-3 p-4">
                <div>    
                    <x-icon name="o-shield-check" class="h-7"></x-icon>
                </div>
                <div>
                    Dalam melakukan aktifitas sehari-hari, apakah <strong x-text="itemsindividu.nama"></strong> mengalami kesulitan dalam hal:
                </div>
            </div>
            
            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">melihat, meskipun sudah menggunakan alat bantu?</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_melihat')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_melihat = parseInt(d.id_gangguan_melihat)" x-bind:checked="d.id_gangguan_melihat == itemsindividu.id_gangguan_melihat" type="radio"/>
                                    <label x-text='d.gangguan_melihat'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">mendengar, meskipun sudah menggunakan alat bantu?</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_mendengar')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_mendengar = parseInt(d.id_gangguan_mendengar)" x-bind:checked="d.id_gangguan_mendengar == itemsindividu.id_gangguan_mendengar" type="radio"/>
                                    <label x-text='d.gangguan_mendengar'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

          
            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">dibandingkan dengan anak lain yang sebaya, berjalan/naik tangga:</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_berjalan')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_berjalan = parseInt(d.id_gangguan_berjalan)" x-bind:checked="d.id_gangguan_berjalan == itemsindividu.id_gangguan_berjalan" type="radio"/>
                                    <label x-text='d.gangguan_berjalan'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                           
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Menggunakan tangan atau jari</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_tangan')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_tangan = parseInt(d.id_gangguan_tangan)" x-bind:checked="d.id_gangguan_tangan == itemsindividu.id_gangguan_tangan" type="radio"/>
                                    <label x-text='d.gangguan_tangan'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Dibandingkan dengan anak lain yang sebaya, mempelajari sesuatu atau kemampuan intelektual:</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_intelektual')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_intelektual = parseInt(d.id_gangguan_intelektual)" x-bind:checked="d.id_gangguan_intelektual == itemsindividu.id_gangguan_intelektual" type="radio"/>
                                    <label x-text='d.gangguan_intelektual'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Dibandingkan dengan anak lain yang sebaya, mengendalikan perilaku emosional:</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_emosional')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_emosional = parseInt(d.id_gangguan_emosional)" x-bind:checked="d.id_gangguan_emosional == itemsindividu.id_gangguan_emosional" type="radio"/>
                                    <label x-text='d.gangguan_emosional'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Berbicara atau komunikasi:</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_komunikasi')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_komunikasi = parseInt(d.id_gangguan_komunikasi)" x-bind:checked="d.id_gangguan_komunikasi == itemsindividu.id_gangguan_komunikasi" type="radio"/>
                                    <label x-text='d.gangguan_komunikasi'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Mengurus diri sendiri (makan, mandi, berpakaian, ketoilet):</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_mandiri')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_mandiri = parseInt(d.id_gangguan_mandiri)" x-bind:checked="d.id_gangguan_mandiri == itemsindividu.id_gangguan_mandiri" type="radio"/>
                                    <label x-text='d.gangguan_mandiri'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Mengingat atau berkosentrasi:</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_konsentrasi')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_konsentrasi = parseInt(d.id_gangguan_konsentrasi)" x-bind:checked="d.id_gangguan_konsentrasi == itemsindividu.id_gangguan_konsentrasi" type="radio"/>
                                    <label x-text='d.gangguan_konsentrasi'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Seberapa sering <strong x-text="itemsindividu.nama"></strong> merasa sangat sedih atau depresi?</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_gangguan_depresi')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_gangguan_depresi = parseInt(d.id_gangguan_depresi)" x-bind:checked="d.id_gangguan_depresi == itemsindividu.id_gangguan_depresi" type="radio"/>
                                    <label x-text='d.gangguan_depresi'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <div>
                <div x-data="dataKronis" class="bg-base-100 rounded-lg">
                    <div @click="getData()">
                        <x-collapse class="rounded-lg border-none shadow-sm">
                            <x-slot:heading>
                                <span class="font-semibold text-[1rem]">Penyakit Kronis?</span>
                            </x-slot:heading>
                            <x-slot:content>
                                <template x-if="items.length > 0">
                                    <template x-for="(item, i) in items" x-key="i">
                                        <div class="flex gap-2 mt-2" x-init="getSelek(item.kode_jenis_penyakit)">
                                            <x-checkbox @blur="klik"  x-model="selek" x-bind:value="item.kode_jenis_penyakit" />
                                            <span x-text="item.jenis_penyakit" class="text-sm"></span>
                                        </div>
                                    </template>
                                </template>
                            </x-slot:content>
                        </x-collapse>
                    </div>
                </div>
            </div>

            <x-card>
                <div>
                    <div>
                        <div class="font-semibold mb-3">Stunting?</div>
                        <div class="gap-3">
                            <template x-for="d in getReferensiData('ref_stunting')">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.id_stunting = parseInt(d.id_stunting)" x-bind:checked="d.id_stunting == itemsindividu.id_stunting" type="radio"/>
                                    <label x-text='d.stunting'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

        </div>
    </x-tab>
    
    {{-- TAB 5 --}}
    <x-tab name="sosial-tab" label="Perlindungan Sosial">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 -mt-3 -mx-1">
            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                             name: 'Tidak Tauh',
                             id: 3
                         },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki jaminan BPJS Non PBI (Mandiri/Pemberi kejra) aktif?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.bpjs_non_pbi = d.name" x-bind:checked="d.name == itemsindividu.bpjs_non_pbi" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                             name: 'Tidak Tahu',
                             id: 3
                         },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki jaminan BPJS PBI (Penerima bantuan) aktif?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.bpjs_pbi = d.name" x-bind:checked="d.name == itemsindividu.bpjs_pbi" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki jaminan kesehatan lainnya?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.bpjs_jamkses = d.name" x-bind:checked="d.name == itemsindividu.bpjs_jamkses" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> ikut serta dalam program Kartu Pra-Kerja?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.prakerja = d.name" x-bind:checked="d.name == itemsindividu.prakerja" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki BPJS jamainan kecelakaan keja aktif?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.bpjs_kecelakaan = d.name" x-bind:checked="d.name == itemsindividu.bpjs_kecelakaan" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki BPJS jaminan kematian aktif?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.bpjs_kematian = d.name" x-bind:checked="d.name == itemsindividu.bpjs_kematian" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki BPJS jaminan hari tua aktif?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.bpjs_hari_tua = d.name" x-bind:checked="d.name == itemsindividu.bpjs_hari_tua" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki BPJS jaminan pensiun aktif?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.bpjs_pensiun = d.name" x-bind:checked="d.name == itemsindividu.bpjs_pensiun" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> memiliki jaminan pensiun/jaminan hari tua lainnya (Taspen/Program pensiun swasta)?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.jaminan_hari_tua = d.name" x-bind:checked="d.name == itemsindividu.jaminan_hari_tua" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> ikut serta dalam Program Kredit Usaha Rakyat?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.kur = d.name" x-bind:checked="d.name == itemsindividu.kur" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div x-data="{
                    bekerja: 1,
                    data: [
                       //insert data array
                        {
                             name: 'Ya',
                             id: 1
                         },
                         {
                             name: 'Tidak',
                             id: 2
                         },
                         {
                            name: 'Tidak Tahu',
                            id: 3
                        },
                        ]
                    }">
                    <div>
                        <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividu.nama"></strong> ikut dalam Program Pembiayaan Usaha Mikro (UMi)?</div>
                        <div class="gap-3">
                            <template x-for="d in data">
                                <div class="flex gap-3 items-center mb-1">
                                    <input @click="itemsindividu.jaminan_usaha_mikro = d.name" x-bind:checked="d.name == itemsindividu.jaminan_usaha_mikro" type="radio"/>
                                    <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-card>

        </div>
    </x-tab>
</x-tabs>




    <x-button @click="updateIndividu()" type="submit" spinner icon="o-paper-airplane"
        class="btn-circle btn-sm h-14 w-14 z-50 text-base-100 shadow-lg bg-amber-500 hover:bg-amber-700 fixed bottom-5 right-3" />

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

    function getHubungan(id)
    {
        if (localStorage.getItem('ref_hubungan_keluarga')) {
            // console.log(JSON.parse(localStorage.getItem(item_name)));
            const results = JSON.parse(localStorage.getItem('ref_hubungan_keluarga'));
            return results.length>0 ? results.find(item => item.id_hubungan_keluarga === id).hubungan_keluarga : '';
        }
    }
    
    function getKeberadaan(id)
    {
        if (localStorage.getItem('ref_keberadaan_individu')) {
            
            const results = JSON.parse(localStorage.getItem('ref_keberadaan_individu'));
            return results.length>0 ? results.find(item => item.id_keberadaan_individu === id).keberadaan_individu : '';
        }
    }



    function dataBidangUsaha(){
        return{
            selek: [],
            items: [],

             async getData(){
                 this.items = await JSON.parse(localStorage.getItem('ref_bidang_usaha'))
             },

             async getSelek(i){
                this.itemsindividu.json_bidang_usaha.includes(i) ? this.selek.push(i) : '';
             },

             klik(){
                 this.itemsindividu.json_bidang_usaha = this.selek
                 console.log(this.itemsindividu.json_bidang_usaha);
                //  await this.updateIndividu()
             }



        }
    }

    function dataBidangUsahaLainnya(){
        return{
            selek: [],
            items: [],

             async getData(){
                 this.items = await JSON.parse(localStorage.getItem('ref_bidang_usaha'))
             },

             async getSelek(i){
                if(this.itemsindividu.json_usaha_lainnya){
                    this.itemsindividu.json_usaha_lainnya.includes(i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividu.json_usaha_lainnya = this.selek
                 console.log(this.itemsindividu.json_usaha_lainnya);
                //  await this.updateIndividu()
             }



        }
    }
    
    function dataIjinUsaha(){
        return{
            selek: [],
            items: [],

             async getData(){
                if(localStorage.getItem('ref_perijinan_usaha')){
                    this.items = await JSON.parse(localStorage.getItem('ref_perijinan_usaha'))
                }
             },

             async getSelek(i){
                if(this.itemsindividu.json_perijinan_usaha){
                    this.itemsindividu.json_perijinan_usaha.find(j=> j==i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividu.json_perijinan_usaha = this.selek
                 console.log(this.itemsindividu.json_perijinan_usaha);
                //  await this.updateIndividu()
             }



        }
    }
    
    function dataInternetUsaha(){
        return{
            selek: [],
            items: [],

             async getData(){
                if(localStorage.getItem('ref_internet_usaha')){
                    this.items = await JSON.parse(localStorage.getItem('ref_internet_usaha'))
                }
             },

             async getSelek(i){
                if(this.itemsindividu.json_kode_internet_usaha){
                    this.itemsindividu.json_kode_internet_usaha.includes(i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividu.json_kode_internet_usaha = this.selek
                 console.log(this.itemsindividu.json_kode_internet_usaha);
                //  await this.updateIndividu()
             }



        }
    }
    
    function dataKronis(){
        return{
            selek: [],
            items: [],

             async getData(){
                if(localStorage.getItem('ref_jenis_penyakit')){
                    this.items = await JSON.parse(localStorage.getItem('ref_jenis_penyakit'))
                }
             },

             async getSelek(i){
                if(this.itemsindividu.json_kode_penyakit){
                    this.itemsindividu.json_kode_penyakit.includes(i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividu.json_kode_penyakit = this.selek
                 console.log(this.itemsindividu.json_kode_penyakit);
                //  await this.updateIndividu()
             }



        }
    }

</script>

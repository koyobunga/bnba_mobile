<div x-data="crudIndex" class="sm:p-5 md:p-7 p-2 pb-12" x-init="getDataFromIndexedDB(),getKeluargaId(getId())">

    <div class="flex justify-between gap-3 items-center px-2  pt-16 mt-3">
        <div>
            <x-icon name="s-document-currency-pound" class="bg-teal-500 text-base-100 p-2 rounded h-9" />
        </div>
        <div class="w-full">
            <div class="font-bold uppercase">Sosial Ekonomi Penduduk</div>
            <div class="text-xs mt-2 uppercase" x-text="itemsindividukk.nama"></div>
            <div class="flex items-center mt-1">
                <div class="flex items-center mt-1 text-teal-500">
                    <div x-text="itemsindividukk.jenis_kelamin == 'L' ? 'Pria' : 'Wanita'" class="text-xs me-4"></div>
                    <x-icon name="o-calendar-days" class="h-3 me-1" />
                    <div x-text="'Lahir '+itemsindividukk.tanggal_lahir" class="text-xs me-4"></div>
                    <x-icon name="o-key" class="h-3 me-1" />
                    <div x-text="itemsindividukk.nomor_kk ? 'KK '+itemsindividukk.nomor_kk : 'ID Keluarga '+itemsindividukk.id_keluarga" class="text-xs"></div>
                </div>
            </div>
            <div>

            </div>
        </div>

    </div>

    <div class="">&nbsp;</div>

    <x-tabs wire:model="selectedTab"   
        active-class="bg-teal-400 rounded text-white h-full px-3"
        label-class="font-semibold px-3 text-sm w-full h-full"
        label-div-class="bg-base-100 h-10 rounded inline-flex w-full overflow-x-auto shadow-lg">
        <x-tab name="users-tab" label="Demografi">
           <div class="-mt-3 -mx-1">
            <x-card x-data="{nama: '', nik:'', tanggal_lahir: '', tempat_lahir:''}">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    <div>
                        <div class="font-semibold">Nama lengkap</div>
                        <x-input @keyup="itemsindividukk.nama = nama; itemskeluarga.nama= nama" x-model="nama" x-bind:value="itemsindividukk.nama" class="input-sm h-9" />
                    </div>
                    <div>
                        <div class="font-semibold">NIK</div>
                        <x-input @keyup="itemsindividukk.nik = nik" x-model="nik" x-bind:value="itemsindividukk.nik" class="input-sm h-9" />
                    </div>
                    <div>
                        <div class="font-semibold">Tempat lahir</div>
                        <x-input @keyup="itemsindividukk.tempat_lahir = tempat_lahir" x-model="tempat_lahir" x-bind:value="itemsindividukk.tempat_lahir" class="input-sm h-9" />
                    </div>
                    <div>
                        <div class="font-semibold">Tanggal lahir</div>
                        <x-datetime @change="itemsindividukk.tanggal_lahir = tanggal_lahir" x-model="tanggal_lahir" x-bind:value="itemsindividukk.tanggal_lahir" icon="o-calendar" class="input-sm h-9" />
                    </div>

                </div>
            </x-card>

            <x-card class="mt-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1 sm:gap-2">

                    <div x-data="{hubungan:''}">
                        <span class="font-semibold">Hubungan dengan kepala keluarga</span>
                        <select @change="itemsindividukk.id_hubungan_keluarga = parseInt(hubungan)" id="select-option" x-model="hubungan" required>
                            <option value="" >Pilih opsi...</option>
                            <template x-for="(d,i) in getReferensiData('ref_hubungan_keluarga')" x-key="i">
                                <option x-bind:selected="itemsindividukk.id_hubungan_keluarga == d.id_hubungan_keluarga" x-bind:value="d.id_hubungan_keluarga" x-text="d.hubungan_keluarga"></option>
                            </template>
                        </select>
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
                        }">
                        <span class="font-semibold">Jenis kelamin</span>
                        <select @change="itemsindividukk.jenis_kelamin = kelamin" id="select-option" x-model="kelamin" required>
                            <option value="" >Pilih opsi...</option>
                            <template x-for="d in data">
                                <option x-bind:selected="itemsindividukk.jenis_kelamin == d.id" x-bind:value="d.id" x-text="d.name"></option>
                            </template>
                        </select>
                    </div>

                    <div x-data="{ keberadaan: 1 }">
                        <span class="font-semibold">Keterangan keberadaan anggota keluarga</span>
                        <select @change="itemsindividukk.id_keberadaan_individu = parseInt(keberadaan)" id="select-option" x-model="keberadaan" required>
                            <option value="" >Pilih opsi...</option>
                            <template x-for="(d,i) in getReferensiData('ref_keberadaan_individu')" x-key="i">
                                <option x-bind:selected="itemsindividukk.id_keberadaan_individu == d.id_keberadaan_individu" x-bind:value="d.id_keberadaan_individu" x-text="d.keberadaan_individu"></option>
                            </template>
                        </select>
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
                            <div class="font-semibold mb-3">Apakat <span x-text="itemsindividukk.nama"></span> masih bersekolah?</div>
                            <div class="gap-3">
                                <template x-for="d in getReferensiData('ref_bersekolah')">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.id_bersekolah = parseInt(d.id_bersekolah)" x-bind:checked="d.id_bersekolah == itemsindividukk.id_bersekolah" type="radio"/>
                                        <label x-text='d.bersekolah'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </x-card>

                <x-card 
                    x-show="itemsindividukk.id_bersekolah != 1"
                    x-effect="itemsindividukk.id_bersekolah == 1 ? itemsindividukk.kode_jenjang_pendidikan=null : ''">
                    <div x-data="{
                        jenjang_pendidikan: 1,
                        }">
                        <span x-show="itemsindividukk.id_bersekolah == 3" class="font-semibold">Jenjang pendidikan terakhir yang pernah diikuti?</span>
                        <span x-show="itemsindividukk.id_bersekolah == 2" class="font-semibold">Jenjang pendidikan saat ini?</span>
                        <select @change="itemsindividukk.kode_jenjang_pendidikan = jenjang_pendidikan" id="select-option" x-model="jenjang_pendidikan" required>
                            <option value="">Pilih opsi...</option>
                            <template x-for="(d,i) in getReferensiData('ref_jenjang_pendidikan')" x-key="i">
                                <option x-bind:selected="itemsindividukk.kode_jenjang_pendidikan == d.kode_jenjang_pendidikan" x-bind:value="d.kode_jenjang_pendidikan" x-text="d.jenjang_pendidikan"></option>
                            </template>
                        </select>
                    </div>
                </x-card>
                
                <x-card
                    x-show="itemsindividukk.id_bersekolah != 1"    
                    x-effect="itemsindividukk.id_bersekolah == 1 ? itemsindividukk.tingkat_penddikan=null : ''">
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
                                if(this.itemsindividukk.id_bersekolah != 1 && ['18','19'].includes(this.itemsindividukk.kode_jenjang_pendidikan))
                                {
                                    this.data[0].hidden = false; this.data[1].hidden = false; this.data[2].hidden = false; this.data[3].hidden = false; this.data[4].hidden = false; this.data[5].hidden = true; this.data[6].hidden = true; this.data[7].hidden = false;
                                }
                                else if(this.itemsindividukk.id_bersekolah != 1 && this.itemsindividukk.kode_jenjang_pendidikan=='20')
                                {
                                    this.data[0].hidden = false; this.data[0].name = '1 (Pernah/Sedang)'; this.data[1].hidden = true; this.data[2].hidden = true; this.data[3].hidden = true; this.data[4].hidden = true; this.data[5].hidden = true; this.data[6].hidden = true; this.data[7].hidden = false;
                                }
                                else if(this.itemsindividukk.id_bersekolah != 1 && this.itemsindividukk.kode_jenjang_pendidikan== '21')
                                {
                                    this.data[0].hidden = true; this.data[1].hidden = true; this.data[2].hidden = true; this.data[3].hidden = true; this.data[4].hidden = true; this.data[5].hidden = false; this.data[5].name = '6 (Pernah/Sedang)'; this.data[6].hidden = true; this.data[7].hidden = false;
                                }
                                else if(this.itemsindividukk.id_bersekolah != 1 && this.itemsindividukk.kode_jenjang_pendidikan== '22')
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
                        <span x-show="itemsindividukk.id_bersekolah == 2" class="font-semibold">Kelas/tingkat pendidikan tertinggi yang sedang diduduki</span>
                        <span x-show="itemsindividukk.id_bersekolah == 3" class="font-semibold">Kelas/tingakat pendidikan tertinggi yang pernah diduduki</span>
                        <div class="flex flex-wrap gap-3 mt-3">
                        <template x-for="(d, i) in data" x-key="i">
                            <div class="flex gap-3 items-center">
                                <input x-bind:hidden="d.hidden" @click="itemsindividukk.tingkat_pendidikan = d.id" x-bind:checked="d.id === itemsindividukk.tingkat_pendidikan" type="radio"/>
                                <label x-bind:hidden="d.hidden" x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                            </div>
                        </template>
                        </div>
                    </div>
                </x-card>

                <x-card 
                    x-show="itemsindividukk.id_bersekolah != 1"
                    x-effect="itemsindividukk.id_bersekolah == 1 ? itemsindividukk.kode_ijazah=null : ''">
                    <div x-data="{
                        kode_ijazah: 1,
                        }">
                        <span class="font-semibold">Ijazah/pendidikan terakhir yang ditamatkan?</span>
                        <select @change="itemsindividukk.kode_ijazah = kode_ijazah" id="select-option" x-model="kode_ijazah" required>
                            <option value="">Pilih opsi...</option>
                            <template x-for="(d,i) in getReferensiData('ref_jenjang_pendidikan')" x-key="i">
                                <option x-bind:selected="itemsindividukk.kode_ijazah == d.kode_jenjang_pendidikan" x-bind:value="d.kode_jenjang_pendidikan" x-text="d.jenjang_pendidikan"></option>
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
                            <div class="font-semibold mb-3">Apakah <span x-text="itemsindividukk.nama"></span> biasanya bekerja?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.status_bekerja = d.name" x-bind:checked="itemsindividukk.status_bekerja == d.name" type="radio"/>
                                        <label x-text='d.name' class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </x-card>

                <x-card x-data="{jam_kerja: ''}">
                    <div>
                        <div class="font-semibold">Total jam <span x-text="itemsindividukk.nama"></span> biasanya bekerja dalam seminggu</div>
                        <x-input @keyup="itemsindividukk.jumlah_jam_kerja_seminggu = jam_kerja" x-model="jam_kerja" x-bind:value="itemsindividukk.jumlah_jam_kerja_seminggu" class="text-sm h-9 w-full input-sm" placeholder="Jam Kerja" />
                    </div>
                </x-card>

                <x-card x-data="{pekerjaan:''}">
                    <div>
                        <span class="font-semibold">Apa pekerjaan utama (yang menghabiskan banyak waktu) <span x-text="itemsindividukk.nama"></span></span>
                        <select @change="itemsindividukk.kode_pekerjaan = pekerjaan" id="select-option" x-model="pekerjaan" required>
                            <option value="">Pilih opsi...</option>
                            <template x-for="(d,i) in getReferensiData('ref_pekerjaan')" x-key="i">
                                <option x-bind:selected="itemsindividukk.kode_pekerjaan == d.kode_pekerjaan" x-bind:value="d.kode_pekerjaan" x-text="d.pekerjaan"></option>
                            </template>
                        </select>
                    </div>
                </x-card>  
                
                <div x-data="dataBidangUsaha" class="bg-base-100 rounded-lg">
                    <div @click="getData()">
                        <x-collapse class="rounded-lg border-none shadow-sm">
                            <x-slot:heading>
                                <span class="font-semibold text-[1rem]">Lapangan usaha atau bidang pekerjaan dari tempat kerja <span x-text="itemsindividukk.nama"></span>?</span>
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
                        <span class="font-semibold">Status kedudukan dalam pekerjaan utama <span x-text="itemsindividukk.nama"></span></span>
                        <select @change="itemsindividukk.id_status_pekerjaan_utama = parseInt(status_kedudukan)" id="select-option" x-model="status_kedudukan" required>
                            <option value="">Pilih opsi...</option>
                            <template x-for="(d,i) in getReferensiData('ref_status_pekerjaan_utama')" x-key="i">
                                <option x-bind:selected="itemsindividukk.id_status_pekerjaan_utama == d.id_status_pekerjaan_utama" x-bind:value="d.id_status_pekerjaan_utama" x-text="d.status_pekerjaan_utama"></option>
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
                            <div class="font-semibold mb-3">Apakah <span x-text="itemsindividukk.nama"></span> memiliki NPWP?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.punya_npwp = d.name" x-bind:checked="d.name == itemsindividukk.punya_npwp" type="radio" x-bind:value="d.name"/>
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
                            <div class="font-semibold mb-3">Apakah <span x-text="itemsindividukk.nama"></span> memiliki usaha sendiri/bersama?</div>
                            <div class="gap-3" x-effect="itemsindividukk.punya_usaha_lainnya=='Tidak' ? itemsindividukk.json_usaha_lainnya = [] : ''">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.punya_usaha_lainnya = d.name" x-bind:checked="d.name == itemsindividukk.punya_usaha_lainnya" type="radio" x-bind:value="d.name"/>
                                        <label x-text='d.name'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                </x-card>

                <div x-show="itemsindividukk.punya_usaha_lainnya=='Ya'">
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


                <x-card x-show="itemsindividukk.punya_usaha_lainnya=='Ya'" > 
                    <div x-data="{jumlah_usaha_lainnya: ''}" x-effect="itemsindividukk.punya_usaha_lainnya=='Tidak' ? itemsindividukk.jumlah_usaha_lainnya = null : ''">
                        <div class="font-semibold">Jumlah usaha sendiri/bersama yang dimiliki</div>
                        <x-input @keyup="itemsindividukk.jumlah_usaha_lainnya = jumlah_usaha_lainnya" x-bind:value="itemsindividukk.jumlah_usaha_lainnya" x-model="jumlah_usaha_lainnya" class="input-sm h-9" />
                    </div>
                    <div x-data="{jumlah_pekerja_dibayar: ''}" x-effect="itemsindividukk.punya_usaha_lainnya=='Tidak' ? itemsindividukk.jumlah_pekerja_dibayar = null : ''">
                        <div class="font-semibold">Jumlah pekerja yang dibayar</div>
                        <x-input @keyup="itemsindividukk.jumlah_pekerja_dibayar = jumlah_pekerja_dibayar" x-bind:value="itemsindividukk.jumlah_pekerja_dibayar" x-model="jumlah_pekerja_dibayar" class="input-sm h-9" />
                    </div>
                    <div x-data="{jumlah_pekerja_tidak_dibayar: ''}" x-effect="itemsindividukk.punya_usaha_lainnya=='Tidak' ? itemsindividukk.jumlah_pekerja_tidak_dibayar = '' : ''">
                        <div class="font-semibold">Jumlah pekerja yang tidak dibayar</div>
                        <x-input @keyup="itemsindividukk.jumlah_pekerja_tidak_dibayar = jumlah_pekerja_tidak_dibayar" x-bind:value="itemsindividukk.jumlah_pekerja_tidak_dibayar" x-model="jumlah_pekerja_tidak_dibayar" class="input-sm h-9" />
                    </div>
                </x-card> 
                
                
                <div x-show="itemsindividukk.punya_usaha_lainnya=='Ya'">
                    <div x-data="dataIjinUsaha" class="bg-base-100 rounded-lg" 
                        x-effect="itemsindividukk.punya_usaha_lainnya=='Tidak' ? itemsindividukk.json_izin_usaha = [] : ''">
                        <div @click="getData()">
                            <x-collapse class="rounded-lg border-none shadow-sm">
                                <x-slot:heading>
                                    <span class="font-semibold text-[1rem]">Kepemilikan perijinan usaha?</span>
                                </x-slot:heading>
                                <x-slot:content>
                                    <template x-if="items.length > 0">
                                        <template x-for="(item, i) in items" x-key="i">
                                            <div class="flex gap-2 mt-2" x-init="getSelek(item.id_izin_usaha)">
                                                <x-checkbox @blur="klik"  x-model="selek" x-bind:value="item.id_izin_usaha" />
                                                <span x-text="item.izin_usaha" class="text-sm"></span>
                                            </div>
                                        </template>
                                    </template>
                                </x-slot:content>
                            </x-collapse>
                        </div>
                    </div>
                </div>



                <x-card x-show="itemsindividukk.punya_usaha_lainnya=='Ya'">
                    <div x-data="{
                        omset_perbulan: 1,
                        }" 
                        x-effect="itemsindividukk.punya_usaha_lainnya=='Tidak' ? itemsindividukk.id_omzet_usaha = null : '' ">
                        <span class="font-semibold">Omset usaha perbulan?</span>
                        <select @change="itemsindividukk.id_omzet_usaha = parseInt(omset_perbulan)" id="select-option" x-model="omset_perbulan" required>
                            <option value="">Pilih opsi...</option>
                            <template x-for="(d,i) in getReferensiData('ref_omzet_usaha')" x-key="i">
                                <option x-bind:selected="itemsindividukk.id_omzet_usaha == d.id_omzet_usaha" x-bind:value="d.id_omzet_usaha" x-text="d.omzet_usaha"></option>
                            </template>
                        </select>
                    </div>
                </x-card>


                <div x-show="itemsindividukk.punya_usaha_lainnya=='Ya'">
                    <div x-data="dataInternetUsaha" class="bg-base-100 rounded-lg" 
                        x-effect="itemsindividukk.punya_usaha_lainnya=='Tidak' ? itemsindividukk.json_kode_internet_usaha = [] : ''">
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
                        Dalam melakukan aktifitas sehari-hari, apakah <strong x-text="itemsindividukk.nama"></strong> mengalami kesulitan dalam hal:
                    </div>
                </div>
                
                <x-card>
                    <div>
                        <div>
                            <div class="font-semibold mb-3">melihat, meskipun sudah menggunakan alat bantu?</div>
                            <div class="gap-3">
                                <template x-for="d in getReferensiData('ref_gangguan_melihat')">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.id_gangguan_melihat = parseInt(d.id_gangguan_melihat)" x-bind:checked="d.id_gangguan_melihat == itemsindividukk.id_gangguan_melihat" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_mendengar = parseInt(d.id_gangguan_mendengar)" x-bind:checked="d.id_gangguan_mendengar == itemsindividukk.id_gangguan_mendengar" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_berjalan = parseInt(d.id_gangguan_berjalan)" x-bind:checked="d.id_gangguan_berjalan == itemsindividukk.id_gangguan_berjalan" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_tangan = parseInt(d.id_gangguan_tangan)" x-bind:checked="d.id_gangguan_tangan == itemsindividukk.id_gangguan_tangan" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_intelektual = parseInt(d.id_gangguan_intelektual)" x-bind:checked="d.id_gangguan_intelektual == itemsindividukk.id_gangguan_intelektual" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_emosional = parseInt(d.id_gangguan_emosional)" x-bind:checked="d.id_gangguan_emosional == itemsindividukk.id_gangguan_emosional" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_komunikasi = parseInt(d.id_gangguan_komunikasi)" x-bind:checked="d.id_gangguan_komunikasi == itemsindividukk.id_gangguan_komunikasi" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_mandiri = parseInt(d.id_gangguan_mandiri)" x-bind:checked="d.id_gangguan_mandiri == itemsindividukk.id_gangguan_mandiri" type="radio"/>
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
                                        <input @click="itemsindividukk.id_gangguan_konsentrasi = parseInt(d.id_gangguan_konsentrasi)" x-bind:checked="d.id_gangguan_konsentrasi == itemsindividukk.id_gangguan_konsentrasi" type="radio"/>
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
                            <div class="font-semibold mb-3">Seberapa sering <strong x-text="itemsindividukk.nama"></strong> merasa sangat sedih atau depresi?</div>
                            <div class="gap-3">
                                <template x-for="d in getReferensiData('ref_gangguan_depresi')">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.id_gangguan_depresi = parseInt(d.id_gangguan_depresi)" x-bind:checked="d.id_gangguan_depresi == itemsindividukk.id_gangguan_depresi" type="radio"/>
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
                                        <input @click="itemsindividukk.id_stunting = parseInt(d.id_stunting)" x-bind:checked="d.id_stunting == itemsindividukk.id_stunting" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki jaminan BPJS Non PBI (Mandiri/Pemberi kejra) aktif?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.bpjs_non_pbi = d.name" x-bind:checked="d.name == itemsindividukk.bpjs_non_pbi" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki jaminan BPJS PBI (Penerima bantuan) aktif?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.bpjs_pbi = d.name" x-bind:checked="d.name == itemsindividukk.bpjs_pbi" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki jaminan kesehatan lainnya?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.bpjs_jamkses = d.name" x-bind:checked="d.name == itemsindividukk.bpjs_jamkses" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> ikut serta dalam program Kartu Pra-Kerja?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.prakerja = d.name" x-bind:checked="d.name == itemsindividukk.prakerja" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki BPJS jamainan kecelakaan keja aktif?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.bpjs_kecelakaan = d.name" x-bind:checked="d.name == itemsindividukk.bpjs_kecelakaan" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki BPJS jaminan kematian aktif?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.bpjs_kematian = d.name" x-bind:checked="d.name == itemsindividukk.bpjs_kematian" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki BPJS jaminan hari tua aktif?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.bpjs_hari_tua = d.name" x-bind:checked="d.name == itemsindividukk.bpjs_hari_tua" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki BPJS jaminan pensiun aktif?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.bpjs_pensiun = d.name" x-bind:checked="d.name == itemsindividukk.bpjs_pensiun" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> memiliki jaminan pensiun/jaminan hari tua lainnya (Taspen/Program pensiun swasta)?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.jaminan_hari_tua = d.name" x-bind:checked="d.name == itemsindividukk.jaminan_hari_tua" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> ikut serta dalam Program Kredit Usaha Rakyat?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.kur = d.name" x-bind:checked="d.name == itemsindividukk.kur" type="radio"/>
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
                            <div class="font-semibold mb-3">Dalam satu tahun terakhir apakah <strong x-text="itemsindividukk.nama"></strong> ikut dalam Program Pembiayaan Usaha Mikro (UMi)?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemsindividukk.jaminan_usaha_mikro = d.name" x-bind:checked="d.name == itemsindividukk.jaminan_usaha_mikro" type="radio"/>
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



    <x-button @click="updateSosial()" type="submit" spinner icon="o-paper-airplane" class="btn-circle btn-sm h-14 w-14 z-50 text-base-100 shadow-lg bg-teal-500 hover:bg-teal-700 fixed bottom-5 right-3" />

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

    function dataBidangUsaha(){
        return{
            selek: [],
            items: [],

             async getData(){
                 this.items = await JSON.parse(localStorage.getItem('ref_bidang_usaha'))
             },

             async getSelek(i){
                this.itemsindividukk.json_bidang_usaha.includes(i) ? this.selek.push(i) : '';
             },

             klik(){
                 this.itemsindividukk.json_bidang_usaha = this.selek
                 console.log(this.itemsindividukk.json_bidang_usaha);
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
                if(this.itemsindividukk.json_usaha_lainnya){
                    this.itemsindividukk.json_usaha_lainnya.includes(i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividukk.json_usaha_lainnya = this.selek
                 console.log(this.itemsindividukk.json_usaha_lainnya);
                //  await this.updateIndividu()
             }



        }
    }
    
    function dataIjinUsaha(){
        return{
            selek: [],
            items: [],

             async getData(){
                if(localStorage.getItem('ref_izin_usaha')){
                    this.items = await JSON.parse(localStorage.getItem('ref_izin_usaha'))
                }
             },

             async getSelek(i){
                if(this.itemsindividukk.json_izin_usaha){
                    this.itemsindividukk.json_izin_usaha.find(j=> j==i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividukk.json_izin_usaha = this.selek
                 console.log(this.itemsindividukk.json_izin_usaha);
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
                if(this.itemsindividukk.json_kode_internet_usaha){
                    this.itemsindividukk.json_kode_internet_usaha.includes(i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividukk.json_kode_internet_usaha = this.selek
                 console.log(this.itemsindividukk.json_kode_internet_usaha);
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
                if(this.itemsindividukk.json_kode_penyakit){
                    this.itemsindividukk.json_kode_penyakit.includes(i) ? this.selek.push(i) : '';
                }
             },

             klik(){
                 this.itemsindividukk.json_kode_penyakit = this.selek
                 console.log(this.itemsindividukk.json_kode_penyakit);
                //  await this.updateIndividu()
             }



        }
    }

</script>
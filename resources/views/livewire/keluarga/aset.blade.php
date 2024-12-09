<div x-data="crudIndex" class="sm:p-5 md:p-7 p-2 pb-12" x-init="getDataFromIndexedDB(),getKeluargaId(getId())">

    <div class="flex justify-between gap-3 items-center px-2  pt-16 mt-3">
        <div>
            <x-icon name="s-briefcase" class="bg-indigo-400 text-base-100 p-2 rounded h-9" />
        </div>
        <div class="w-full">
            <div class="font-bold uppercase">Keikutsertaan Program, Kepemilikan Aset dan Layanan</div>
            <div class="text-xs mt-2 font-semibold uppercase" x-text="itemskeluarga.nama"></div>
            <div class="flex items-center mt-1">
                <div class="flex items-center mt-1 text-indigo-500">
                    <x-icon name="o-user" class="h-3 me-1" />
                    <div x-text="itemskeluarga.jenis_kelamin == 'L' ? 'Pria' : 'Wanita'" class="text-xs me-4"></div>
                    <x-icon name="o-calendar-days" class="h-3 me-1" />
                    <div x-text="'Lahir '+itemskeluarga.tanggal_lahir" class="text-xs me-4"></div>
                    <x-icon name="o-key" class="h-3 me-1" />
                    <div x-text="itemskeluarga.nomor_kk ? 'KK '+itemskeluarga.nomor_kk : 'ID Keluarga '+itemskeluarga.id_keluarga"
                        class="text-xs"></div>
                </div>
            </div>
            <div>

            </div>
        </div>

    </div>




    <div class="">&nbsp;</div>


    <x-tabs wire:model="selectedTab" active-class="bg-indigo-400 rounded text-white h-full px-3"
        label-class="font-semibold px-3 text-sm w-full h-full"
        label-div-class="bg-base-100 h-10 rounded inline-flex w-full overflow-x-auto shadow-lg">

        {{-- Tab Program --}}
        <x-tab name="program-tab" label="Keikutsertaan Program">

            <div
                class="bg-blue-100 dark:bg-gray-800 col-span-full rounded-lg border items-center -mt-3 -mx-1 flex gap-3 p-4">
                <div>
                    <x-icon name="o-cursor-arrow-rays" class="h-7"></x-icon>
                </div>
                <div>
                    <div class="font-semibold">Keikutsertaan program</div>
                    Selama satu tahun terakhir, apakah keluarga Anda pernah menerima program berikut?
                </div>
            </div>

            <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-2 -mx-1">
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
                            <div class="font-semibold mb-3">Program Bantuan Sosial Sembako/BPNT</div>
                            <div class="gap-3"
                                x-effect="itemskeluarga.program_bpnt !== 'Ya' ? itemskeluarga.periode_program_bpnt = '' : '' ">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.program_bpnt = d.name"
                                            x-bind:checked="d.name == itemskeluarga.program_bpnt" type="radio" />
                                        <label x-text='d.name'
                                            class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="itemskeluarga.program_bpnt == 'Ya'" class="mt-3">
                        <div x-data="{periode_program_bpnt: ''}">
                            <div class="font-semibold text-sm mb-2 mt-3">Periode Program</div>
                            <input @keyup="itemskeluarga.periode_program_bpnt = periode_program_bpnt"
                                x-model="periode_program_bpnt" x-bind:value="itemskeluarga.periode_program_bpnt"
                                class="text-sm h-9 rounded-lg text-center w-28 border px-4" x-mask="99/9999"
                                placeholder="Bulan/Tahun" />
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
                            <div class="font-semibold mb-3">Program Bantuan Keluarga Harapan (PKH)</div>
                            <div class="gap-3"
                                x-effect="itemskeluarga.program_pkh !== 'Ya' ? itemskeluarga.periode_program_pkh = '' : '' ">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.program_pkh = d.name"
                                            x-bind:checked="d.name == itemskeluarga.program_pkh" type="radio" />
                                        <label x-text='d.name'
                                            class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="itemskeluarga.program_pkh == 'Ya'" class="mt-3">
                        <div x-data="{periode_program_pkh: ''}">
                            <div class="font-semibold text-sm mb-2 mt-3">Periode Program</div>
                            <input @keyup="itemskeluarga.periode_program_pkh = periode_program_pkh"
                                x-model="periode_program_pkh" x-bind:value="itemskeluarga.periode_program_pkh"
                                class="text-sm h-9 rounded-lg text-center w-28 border px-4" x-mask="99/9999"
                                placeholder="Bulan/Tahun" />
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
                            <div class="font-semibold mb-3">Program Bantuan Langsung Tunai (BLT)</div>
                            <div class="gap-3"
                                x-effect="itemskeluarga.program_blt !== 'Ya' ? itemskeluarga.periode_program_blt = '' : '' ">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.program_blt = d.name"
                                            x-bind:checked="d.name == itemskeluarga.program_blt" type="radio" />
                                        <label x-text='d.name'
                                            class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="itemskeluarga.program_blt == 'Ya'" class="mt-3">
                        <div x-data="{periode_program_blt: ''}">
                            <div class="font-semibold text-sm mb-2 mt-3">Periode Program</div>
                            <input @keyup="itemskeluarga.periode_program_blt = periode_program_blt"
                                x-model="periode_program_blt" x-bind:value="itemskeluarga.periode_program_blt"
                                class="text-sm h-9 rounded-lg text-center w-28 border px-4" x-mask="99/9999"
                                placeholder="Bulan/Tahun" />
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
                            <div class="font-semibold mb-3">Program Subside Listrik 450/900VA (Gratis/Pemotongan Biaya)
                            </div>
                            <div class="gap-3"
                                x-effect="itemskeluarga.program_subsidi_listrik !== 'Ya' ? itemskeluarga.periode_program_subsidi_listrik = '' : '' ">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.program_subsidi_listrik = d.name"
                                            x-bind:checked="d.name == itemskeluarga.program_subsidi_listrik"
                                            type="radio" />
                                        <label x-text='d.name'
                                            class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="itemskeluarga.program_subsidi_listrik == 'Ya'" class="mt-3">
                        <div x-data="{periode_program_subsidi_listrik: ''}">
                            <div class="font-semibold text-sm mb-2 mt-3">Periode Program</div>
                            <input
                                @keyup="itemskeluarga.periode_program_subsidi_listrik = periode_program_subsidi_listrik"
                                x-model="periode_program_subsidi_listrik"
                                x-bind:value="itemskeluarga.periode_program_subsidi_listrik"
                                class="text-sm h-9 rounded-lg text-center w-28 border px-4" x-mask="99/9999"
                                placeholder="Bulan/Tahun" />
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
                            <div class="font-semibold mb-3">Program Bantuan Pemerintah Daerah (PEMDA)</div>
                            <div class="gap-3"
                                x-effect="itemskeluarga.program_bantuan_pemda !== 'Ya' ? itemskeluarga.periode_program_bantuan_pemda = '' : '' ">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.program_bantuan_pemda = d.name"
                                            x-bind:checked="d.name == itemskeluarga.program_bantuan_pemda"
                                            type="radio" />
                                        <label x-text='d.name'
                                            class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="itemskeluarga.program_bantuan_pemda == 'Ya'" class="mt-3">
                        <div x-data="{periode_program_bantuan_pemda: ''}">
                            <div class="font-semibold text-sm mb-2 mt-3">Periode Program</div>
                            <input @keyup="itemskeluarga.periode_program_bantuan_pemda = periode_program_bantuan_pemda"
                                x-model="periode_program_bantuan_pemda"
                                x-bind:value="itemskeluarga.periode_program_bantuan_pemda"
                                class="text-sm h-9 rounded-lg text-center w-28 border px-4" x-mask="99/9999"
                                placeholder="Bulan/Tahun" />
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
                            <div class="font-semibold mb-3">Program Bantuan Subsidi Pupuk</div>
                            <div class="gap-3"
                                x-effect="itemskeluarga.program_subsidi_pupuk !== 'Ya' ? itemskeluarga.periode_program_subsidi_pupuk = '' : '' ">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.program_subsidi_pupuk = d.name"
                                            x-bind:checked="d.name == itemskeluarga.program_subsidi_pupuk"
                                            type="radio" />
                                        <label x-text='d.name'
                                            class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="itemskeluarga.program_subsidi_pupuk == 'Ya'" class="mt-3">
                        <div x-data="{periode_program_subsidi_pupuk: ''}">
                            <div class="font-semibold text-sm mb-2 mt-3">Periode Program</div>
                            <input @keyup="itemskeluarga.periode_program_subsidi_pupuk = periode_program_subsidi_pupuk"
                                x-model="periode_program_subsidi_pupuk"
                                x-bind:value="itemskeluarga.periode_program_subsidi_pupuk"
                                class="text-sm h-9 rounded-lg text-center w-28 border px-4" x-mask="99/9999"
                                placeholder="Bulan/Tahun" />
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
                            <div class="font-semibold mb-3">Menggunakan Gas LPG 3 Kg</div>
                            <div class="gap-3">
                                <div class="gap-3"
                                    x-effect="itemskeluarga.menggunakan_gas_3kg !== 'Ya' ? itemskeluarga.periode_menggunakan_gas_3kg = '' : '' ">
                                    <template x-for="d in data">
                                        <div class="flex gap-3 items-center mb-1">
                                            <input @click="itemskeluarga.menggunakan_gas_3kg = d.name"
                                                x-bind:checked="d.name == itemskeluarga.menggunakan_gas_3kg"
                                                type="radio" />
                                            <label x-text='d.name'
                                                class="text-sm text-slate-700 dark:text-slate-200"></label>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-show="itemskeluarga.menggunakan_gas_3kg == 'Ya'" class="mt-3">
                        <div x-data="{periode_menggunakan_gas_3kg: ''}">
                            <div class="font-semibold text-sm mb-2 mt-3">Periode Program</div>
                            <input @keyup="itemskeluarga.periode_menggunakan_gas_3kg = periode_menggunakan_gas_3kg"
                                x-model="periode_menggunakan_gas_3kg"
                                x-bind:value="itemskeluarga.periode_menggunakan_gas_3kg"
                                class="text-sm h-9 rounded-lg text-center w-28 border px-4" x-mask="99/9999"
                                placeholder="Bulan/Tahun" />
                        </div>
                    </div>
                </x-card>


            </div>
                    
        </x-tab>

        {{-- Tab Asset --}}
        <x-tab name="aset-tab" label="Aset Bergerak">

            <div
                class="bg-green-100 dark:bg-gray-800 col-span-full rounded-lg border items-center -mt-3 -mx-1 flex gap-3 p-4">
                <div>
                    <x-icon name="o-cursor-arrow-rays" class="h-7"></x-icon>
                </div>
                <div>
                    <div class="font-semibold">Kepemilikan aset bergerak</div>
                    Berapa jumlah asset bergerak berikut yang dimiliki oleh keluarga saat ini?
                </div>
            </div>
            <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-2 -mx-1">
                <x-card x-data="{jumlah_tabung_gas_5kg: ''}">
                    <label for="" class="font-semibold">Tabung Gas 5,5 Kg atau lebih</label>
                    <x-input @keyup="itemskeluarga.jumlah_tabung_gas_5kg = jumlah_tabung_gas_5kg"
                    x-model="jumlah_tabung_gas_5kg" x-bind:value="itemskeluarga.jumlah_tabung_gas_5kg" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>

                <x-card x-data="{jumlah_kulkas: ''}">
                    <label for="" class="font-semibold">Lemari Es atau Kulkas</label>
                    <x-input @keyup="itemskeluarga.jumlah_kulkas = jumlah_kulkas"
                    x-model="jumlah_kulkas" x-bind:value="itemskeluarga.jumlah_kulkas" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_ac: ''}">
                    <label for="" class="font-semibold">Air Conditioner (AC)</label>
                    <x-input @keyup="itemskeluarga.jumlah_ac = jumlah_ac"
                    x-model="jumlah_ac" x-bind:value="itemskeluarga.jumlah_ac" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_pemanas_air: ''}">
                    <label for="" class="font-semibold">Pemanas Air (water heater)  </label>
                    <x-input @keyup="itemskeluarga.jumlah_pemanas_air = jumlah_pemanas_air"
                    x-model="jumlah_pemanas_air" x-bind:value="itemskeluarga.jumlah_pemanas_air" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_telepon_rumah: ''}">
                    <label for="" class="font-semibold">Telepon rumah (PSTN)</label>
                    <x-input @keyup="itemskeluarga.jumlah_telepon_rumah = jumlah_telepon_rumah"
                    x-model="jumlah_telepon_rumah" x-bind:value="itemskeluarga.jumlah_telepon_rumah" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_tv: ''}">
                    <label for="" class="font-semibold">Televisi layar datar minimal 30 inchi</label>
                    <x-input @keyup="itemskeluarga.jumlah_tv = jumlah_tv"
                    x-model="jumlah_tv" x-bind:value="itemskeluarga.jumlah_tv" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_perhiasan: ''}">
                    <label for="" class="font-semibold">Emas atau periasan</label>
                    <x-input @keyup="itemskeluarga.jumlah_perhiasan = jumlah_perhiasan"
                    x-model="jumlah_perhiasan" x-bind:value="itemskeluarga.jumlah_perhiasan" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_komputer: ''}">
                    <label for="" class="font-semibold">Komputer/laptop/tablet</label>
                    <x-input @keyup="itemskeluarga.jumlah_komputer = jumlah_komputer"
                    x-model="jumlah_komputer" x-bind:value="itemskeluarga.jumlah_komputer" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_sepeda_motor: ''}">
                    <label for="" class="font-semibold">Sepeda motor</label>
                    <x-input @keyup="itemskeluarga.jumlah_sepeda_motor = jumlah_sepeda_motor"
                    x-model="jumlah_sepeda_motor" x-bind:value="itemskeluarga.jumlah_sepeda_motor" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_sepeda: ''}">
                    <label for="" class="font-semibold">Sepeda</label>
                    <x-input @keyup="itemskeluarga.jumlah_sepeda = jumlah_sepeda"
                    x-model="jumlah_sepeda" x-bind:value="itemskeluarga.jumlah_sepeda" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_mobil: ''}">
                    <label for="" class="font-semibold">Mobil</label>
                    <x-input @keyup="itemskeluarga.jumlah_mobil = jumlah_mobil"
                    x-model="jumlah_mobil" x-bind:value="itemskeluarga.jumlah_mobil" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_perahu_non_motor: ''}">
                    <label for="" class="font-semibold">Kapal/Perahu Non Motor</label>
                    <x-input @keyup="itemskeluarga.jumlah_perahu_non_motor = jumlah_perahu_non_motor"
                    x-model="jumlah_perahu_non_motor" x-bind:value="itemskeluarga.jumlah_perahu_non_motor" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_perahu_motor: ''}">
                    <label for="" class="font-semibold">Kapal/Perahu Motor</label>
                    <x-input @keyup="itemskeluarga.jumlah_perahu_motor = jumlah_perahu_motor"
                    x-model="jumlah_perahu_motor" x-bind:value="itemskeluarga.jumlah_perahu_motor" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>
                
                <x-card x-data="{jumlah_smartphone: ''}">
                    <label for="" class="font-semibold">Kapal/Perahu Motor</label>
                    <x-input @keyup="itemskeluarga.jumlah_smartphone = jumlah_smartphone"
                    x-model="jumlah_smartphone" x-bind:value="itemskeluarga.jumlah_smartphone" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                </x-card>

            </div>
        </x-tab>


        {{-- Tab Asset Tidak bergerak --}}
        <x-tab name="asset-tidak-tab" label="Asset Tidak Bergerak">
            <div
                class="bg-emerald-100 dark:bg-gray-800 col-span-full rounded-lg border items-center -mt-3 -mx-1 flex gap-3 p-4">
                <div>
                    <x-icon name="o-cursor-arrow-rays" class="h-7"></x-icon>
                </div>
                <div>
                    <div class="font-semibold">Kepemilikan aset tidak bergerak</div>
                    Keluarga memiliki aset tidak bergerak sebagai berikut?
                </div>
            </div>
            <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-2 -mx-1">



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
                            ]
                        }">
                        <div>
                            <div class="font-semibold mb-3">Lahan (selain yang ditempati)?</div>
                            <div class="gap-3">
                                <template x-for="d in data">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.punya_lahan_lainnya = d.name"
                                            x-bind:checked="d.name == itemskeluarga.punya_lahan_lainnya"
                                            type="radio" />
                                        <label x-text='d.name'
                                            class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div x-data="{jumlah_rumah_lainnya: ''}" class="mt-2" x-show="itemskeluarga.punya_lahan_lainnya == 'Ya'">
                        <label for="" class="font-semibold">Berapa jumlah rumah/bangunan ditempat lain?</label>
                        <x-input @keyup="itemskeluarga.jumlah_rumah_lainnya = jumlah_rumah_lainnya"
                        x-model="jumlah_rumah_lainnya" x-bind:value="itemskeluarga.jumlah_rumah_lainnya" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                    </div>
                </x-card>

                <x-card>
                    <div
                        class="bg-base-200 text-indigo-600 col-span-full text-sm rounded-lg border items-center -mt-1 py-2  px-3">
                        Jumlah kepemilikan ternak?
                    </div>
                    <div class="grid grid-cols-2 gap-1 mt-2">
                        <div x-data="{jumlah_sapi: ''}">
                            <label for="" class="font-semibold">Sapi</label>
                            <x-input @keyup="itemskeluarga.jumlah_sapi = jumlah_sapi"
                                 x-model="jumlah_sapi" x-bind:value="itemskeluarga.jumlah_sapi" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                        </div>
                        <div x-data="{jumlah_kerbau: ''}">
                            <label for="" class="font-semibold">Kerbau</label>
                            <x-input @keyup="itemskeluarga.jumlah_kerbau = jumlah_kerbau"
                                 x-model="jumlah_kerbau" x-bind:value="itemskeluarga.jumlah_kerbau" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                        </div>
                        <div x-data="{jumlah_kuda: ''}">
                            <label for="" class="font-semibold">Kuda</label>
                            <x-input @keyup="itemskeluarga.jumlah_kuda = jumlah_kuda"
                                 x-model="jumlah_kuda" x-bind:value="itemskeluarga.jumlah_kuda" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                        </div>
                        <div x-data="{jumlah_babi: ''}">
                            <label for="" class="font-semibold">Babi</label>
                            <x-input @keyup="itemskeluarga.jumlah_babi = jumlah_babi"
                                 x-model="jumlah_babi" x-bind:value="itemskeluarga.jumlah_babi" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                        </div>
                        <div x-data="{jumlah_kambing: ''}">
                            <label for="" class="font-semibold">Kambing</label>
                            <x-input @keyup="itemskeluarga.jumlah_kambing = jumlah_kambing"
                                 x-model="jumlah_kambing" x-bind:value="itemskeluarga.jumlah_kambing" type="number" placeholder="Jumlah" class="input-sm"></x-input>
                        </div>
                    </div>
                </x-card>

            </div>
        </x-tab>


        {{-- Tab layanan --}}
        <x-tab name="layanan-tab" label="Layanan">

            <div
                class="bg-pink-100 dark:bg-gray-800 col-span-full rounded-lg border items-center -mt-3 -mx-1 flex gap-3 p-4">
                <div>
                    <x-icon name="o-cursor-arrow-rays" class="h-7"></x-icon>
                </div>
                <div>
                    <div class="font-semibold">Layanan</div>
                    Fasilitas/Layanan yang digunakan oleh keluarga
                </div>
            </div>
            <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-2 -mx-1">
                <x-card>
                    <div>
                        <div>
                            <div class="font-semibold mb-3">Apa jenis internet utama yang digunakan oleh keluarga Anda
                                selema sebulan terakhir? </div>
                            <div class="gap-3">
                                <template x-for="d in getReferensiData('ref_akses_internet')">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.id_akses_internet = parseInt(d.id_akses_internet)" x-bind:checked="d.id_akses_internet == itemskeluarga.id_akses_internet" type="radio"/>
                                        <label x-text='d.akses_internet'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div >
                        <div>
                            <div class="font-semibold mb-3">Apa keluarga Anda memiliki rekening aktif atau dompet
                                digital (Gopay/OVO/Dana/LinkAja/ShopeePay dll)? </div>
                            <div class="gap-3">
                                <template x-for="d in getReferensiData('ref_dompet_digital')">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.id_dompet_digital = parseInt(d.id_dompet_digital)" x-bind:checked="d.id_dompet_digital == itemskeluarga.id_dompet_digital" type="radio"/>
                                        <label x-text='d.dompet_digital'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div>
                        <div>
                            <div class="font-semibold mb-3">Apa sumber pendapatan utama keluarga Anda? </div>
                            <div class="gap-3">
                                <template x-for="d in getReferensiData('ref_pendapatan_utama')">
                                    <div class="flex gap-3 items-center mb-1">
                                        <input @click="itemskeluarga.id_pendapatan_utama = parseInt(d.id_pendapatan_utama)" x-bind:checked="d.id_pendapatan_utama == itemskeluarga.id_pendapatan_utama" type="radio"/>
                                        <label x-text='d.pendapatan_utama'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </x-card>

            </div>

        </x-tab>

    </x-tabs>





    <x-button @click="updateData()" type="submit" spinner icon="o-paper-airplane"
        class="btn-circle btn-sm h-14 w-14 z-50 text-base-100 shadow-lg bg-indigo-500 hover:bg-indigo-700 fixed bottom-5 right-3" />

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
</script>
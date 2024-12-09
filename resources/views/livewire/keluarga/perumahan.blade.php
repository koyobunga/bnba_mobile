<div x-data="crudIndex" class="sm:p-5 md:p-7 p-2" x-init="getDataFromIndexedDB(),getKeluargaId(getId())">

<div class="flex justify-between gap-3 items-center px-2  pt-16 mt-3">
        <div>
            <x-icon name="s-home-modern" class="bg-green-500 text-base-100 p-2 rounded h-9" />
        </div>
        <div class="w-full">
            <div class="font-bold uppercase">Perumahan</div>
            <div class="text-xs mt-1 uppercase" x-text="itemskeluarga.nama"></div>
            <div class="flex items-center mt-1 text-green-600">
                <x-icon name="o-user" class="h-3 me-1" />
                <div x-text="itemskeluarga.jenis_kelamin == 'L' ? 'Pria' : 'Wanita'" class="text-xs me-4"></div>
                <x-icon name="o-calendar-days" class="h-3 me-1" />
                <div x-text="'Lahir '+itemskeluarga.tanggal_lahir" class="text-xs me-4"></div>
                <x-icon name="o-key" class="h-3 me-1" />
                <div x-text="itemskeluarga.nomor_kk ? 'KK '+itemskeluarga.nomor_kk : 'ID Keluarga '+itemskeluarga.id_keluarga" class="text-xs"></div>
            </div>
            <div>

            </div>
        </div>

    </div>


    <div class="grid grid-cols-1 mt-8 sm:grid-cols-2 gap-3">

        <x-card class="">
            <div class="font-semibold">Foto Rumah</div>
            <div class="flex gap-3">
                <div class="w-1/2">
                    <div x-data="imageCropper()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInput" x-on:change="openModal" accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInput.click()"
                                :src="itemskeluarga.foto_depan_rumah ? itemskeluarga.foto_depan_rumah : 'icons/nophoto.jpg'" alt="Cropped Image"
                                class="w-full object-cover rounded border p-1 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpen"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll"
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="image" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImage">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text mt-2 text-xs text-slate-500">* Tampak Depan</div>
                </div>

                <div class="w-1/2">

                    <div x-data="imageCropperTamu()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInputTamu" x-on:change="openModalTamu"
                            accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInputTamu.click()"
                                :src="itemskeluarga.foto_ruang_tamu ? itemskeluarga.foto_ruang_tamu : 'icons/nophoto.jpg'" alt="Cropped Image"
                                class="w-full object-cover rounded border p-1 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpenTamu"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll"
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="imageTamu" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImageTamu">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text mt-2 text-xs text-slate-500">* Ruang Tamu</div>
                </div>
            </div>
        </x-card>

        <x-card >

            <div class="gap-3" x-data="{jumlah_tingkat_rumah: 0}">
                <div class="font-semibold mt-2 mb-1">Berapa Tingkat Bangunan Tempat Tinggal</div>
                <input @keyup="itemskeluarga.jumlah_tingkat_rumah = jumlah_tingkat_rumah" x-model="jumlah_tingkat_rumah" x-bind:value="itemskeluarga.jumlah_tingkat_rumah" maxlength="2" type="number" class="border border-primary rounded-lg px-3 py-1 w-full" />
            </div>

        </x-card>



        <x-card>

            <div class="font-semibold mb-3">Status penguasaan bangunan tempat tinggal yang ditempati</div>

            <div class="gap-3">
                <template x-for="(d, i) in getReferensiData('ref_kepemilikan_tt')" x-ket="i">
                    <div class="flex gap-3 items-center mb-1">
                        <input @click="itemskeluarga.id_kepemilikan_tt = parseInt(d.id_kepemilikan_tt)" x-bind:checked="d.id_kepemilikan_tt == itemskeluarga.id_kepemilikan_tt" type="radio"/>
                        <label x-text='d.kepemilikan_tt'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                    </div>
                </template>
            </div>

        </x-card>


        <x-card class="gap-1" x-data="{
                luas_tanah: '', 
                luas_bangunan: '', 
                jumlah_keluarga_menempati: 0,
            }">
            <div class="font-semibold mb-1">Luas tanah (M<sup>2</sup>)</div>
            <x-input @keyup="itemskeluarga.luas_tanah = luas_tanah" x-model="luas_tanah" x-bind:value="itemskeluarga.luas_tanah" class="input-sm" />
            
            <div class="font-semibold mt-2 mb-1">Berapa luas bangunan (M<sup>2</sup>)</div>
            <x-input @keyup="itemskeluarga.luas_bangunan = luas_bangunan" x-model="luas_bangunan" x-bind:value="itemskeluarga.luas_bangunan" class="input-sm" />
            
            <div class="font-semibold mt-2 mb-1">Berapa jumlah keluarga yang menempati bangunan tempat tinggal tersebut</div>
            <input @keyup="itemskeluarga.jumlah_keluarga_menempati = parseInt(jumlah_keluarga_menempati)" x-model="jumlah_keluarga_menempati" x-bind:value="itemskeluarga.jumlah_keluarga_menempati" type="number" class="border border-primary rounded-lg px-3 py-1 w-full" />
        </x-card>


        <x-card>
            <div class="flex">
                <div class="w-1/2">
                    <div class="font-semibold mb-3">Jenis lantai terluas</div>
                    <div class="gap-3">
                        <template x-for="d in getReferensiData('ref_jenis_lantai')">
                            <div class="flex gap-3 items-center mb-1">
                                <input @click="itemskeluarga.id_jenis_lantai = parseInt(d.id_jenis_lantai)" x-bind:checked="d.id_jenis_lantai == itemskeluarga.id_jenis_lantai" type="radio"/>
                                <label x-text='d.jenis_lantai'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                            </div>
                        </template>
                    </div>
                </div>


                <div class="w-1/2">
                    <div class="font-semibold mb-3">Foto lantai terluas</div>
                    <div x-data="imageCropperLantai()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInputLantai" x-on:change="openModalLantai"
                            accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInputLantai.click()"
                                :src="itemskeluarga.foto_lantai ? itemskeluarga.foto_lantai : 'icons/nophoto.jpg'" alt="Cropped Image"
                                class="w-full object-cover rounded border p-1 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpenLantai"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll"
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="imageLantai" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImageLantai">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </x-card>


        <x-card>
            <div>
                <div>
                    <div class="font-semibold mb-3">Jenis dinding terluas pada sisi terluar banguanan tempat tinggal
                    </div>
                    <div class="gap-3">
                        <template x-for="d in getReferensiData('ref_jenis_dinding')">
                            <div class="flex gap-3 items-center mb-1">
                                <input @click="itemskeluarga.id_jenis_dinding = parseInt(d.id_jenis_dinding)" x-bind:checked="d.id_jenis_dinding == itemskeluarga.id_jenis_dinding" type="radio"/>
                                <label x-text='d.jenis_dinding'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                            </div>
                        </template>
                    </div>
                </div>


                <div>
                    <div class="font-semibold mb-3 mt-4">Foto dinding terluas</div>
                    <div x-data="imageCropperDinding()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInputDinding" x-on:change="openModalDinding"
                            accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInputDinding.click()"
                                :src="itemskeluarga.foto_dinding ? itemskeluarga.foto_dinding : 'icons/nophoto.jpg'"
                                alt="Cropped Image" class="w-full object-cover rounded border p-2 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpenDinding"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll"
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="imageDinding" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImageDinding">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </x-card>


        <x-card>
            <div>
                <div>
                    <div class="font-semibold mb-3">Jenis atap terluas
                    </div>
                    <div class="gap-3">
                        <template x-for="d in getReferensiData('ref_jenis_atap')">
                            <div class="flex gap-3 items-center mb-1">
                                <input @click="itemskeluarga.id_jenis_atap = parseInt(d.id_jenis_atap)" x-bind:checked="d.id_jenis_atap == itemskeluarga.id_jenis_atap" type="radio"/>
                                <label x-text='d.jenis_atap'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                            </div>
                        </template>
                    </div>
                </div>


                <div>
                    <div class="font-semibold mb-3 mt-4">Foto atap terluas</div>
                    <div x-data="imageCropperAtap()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInputAtap" x-on:change="openModalAtap"
                            accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInputAtap.click()"
                                :src="itemskeluarga.foto_atap ? itemskeluarga.foto_atap : 'icons/nophoto.jpg'" alt="Cropped Image"
                                class="w-full object-cover rounded border p-2 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpenAtap"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll"
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="imageAtap" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImageAtap">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </x-card>


        <x-card>
            <div>
                <div>
                    <div class="font-semibold mb-3">Sumber air minum utama
                    </div>
                    <div class="gap-3">
                        <template x-for="d in getReferensiData('ref_sumber_air_minum')">
                            <div class="flex gap-3 items-center mb-1">
                                <input @click="itemskeluarga.kode_sumber_air_minum = d.kode_sumber_air_minum" x-bind:checked="d.kode_sumber_air_minum == itemskeluarga.kode_sumber_air_minum" type="radio"/>
                                <label x-text='d.sumber_air_minum'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                            </div>
                        </template>
                    </div>
                </div>


                <div>
                    <div class="font-semibold mb-3 mt-4">Foto sumber air minum</div>
                    <div x-data="imageCropperAir()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInputAir" x-on:change="openModalAir"
                            accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInputAir.click()"
                                :src="itemskeluarga.foto_sumber_air_minum ? itemskeluarga.foto_sumber_air_minum : 'icons/nophoto.jpg'" alt="Cropped Image"
                                class="w-full object-cover rounded border p-2 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpenAir"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll"
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="imageAir" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImageAir">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </x-card>


        <x-card>

            <div class="font-semibold mb-3">Sumber penerangan utama</div>

            <div class="gap-3">
                <template x-for="d in getReferensiData('ref_jenis_listrik')">
                    <div class="flex gap-3 items-center mb-1">
                        <input @click="itemskeluarga.id_jenis_listrik = parseInt(d.id_jenis_listrik)" x-bind:checked="d.id_jenis_listrik == itemskeluarga.id_jenis_listrik" type="radio"/>
                        <label x-text='d.jenis_listrik'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                    </div>
                </template>
            </div>

        </x-card>
        
        <x-card x-show="itemskeluarga.id_jenis_listrik == 1" 
            x-effect="itemskeluarga.id_jenis_listrik != 1 ? itemskeluarga.id_daya_listrik = null : ''">

            <div class="font-semibold mb-3"> Berapa jumlah meteran listrik yang terpasang di rumah ini  </div>

            <div class="gap-3">
                <template x-for="d in getReferensiData('ref_daya_listrik')">
                    <div class="flex gap-3 items-center mb-1">
                        <input @click="itemskeluarga.id_daya_listrik = parseInt(d.id_daya_listrik)" x-bind:checked="d.id_daya_listrik == itemskeluarga.id_daya_listrik" type="radio"/>
                        <label x-text='d.daya_listrik'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                    </div>
                </template>
            </div>

        </x-card>
        
        <x-card>

            <div class="font-semibold mb-3"> Berapa pengeluaran listrik perbulan di keluarga (Rupiah)?   </div>

            <div class="gap-3">
                <template x-for="d in getReferensiData('ref_biaya_listrik')">
                    <div class="flex gap-3 items-center mb-1">
                        <input @click="itemskeluarga.id_biaya_listrik = parseInt(d.id_biaya_listrik)" x-bind:checked="d.id_biaya_listrik == itemskeluarga.id_biaya_listrik" type="radio"/>
                        <label x-text='d.biaya_listrik'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                    </div>
                </template>
            </div>

        </x-card>


        <x-card>
            <div>
                <div>
                    <div class="font-semibold mb-3">Bahan bakar/energi utama untuk memasak
                    </div>
                    <div class="gap-3">
                        <template x-for="d in getReferensiData('ref_bahan_bakar_memasak')">
                            <div class="flex gap-3 items-center mb-1">
                                <input @click="itemskeluarga.kode_bahan_bakar_memasak = d.kode_bahan_bakar_memasak" x-bind:checked="d.kode_bahan_bakar_memasak == itemskeluarga.kode_bahan_bakar_memasak" type="radio"/>
                                <label x-text='d.bahan_bakar_memasak'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                            </div>
                        </template>
                    </div>
                </div>


                <div>
                    <div class="font-semibold mb-3 mt-4">Foto bahan bakar memasak/dapur</div>
                    <div x-data="imageCropperBahanbakar()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInputBahanbakar" x-on:change="openModalBahanbakar"
                            accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInputBahanbakar.click()"
                                :src="itemskeluarga.foto_dapur ? itemskeluarga.foto_dapur : 'icons/nophoto.jpg'"
                                alt="Cropped Image" class="w-full object-cover rounded border p-2 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpenBahanbakar"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll"
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="imageBahanbakar" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImageBahanbakar">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </x-card>


        <x-card>
            <div class="font-semibold mb-3">Kepemilikan dan penggunaan fasilitas tempat buang air besar </div>

            <div class="gap-3">
                <template x-for="d in getReferensiData('ref_fas_bab')">
                    <div class="flex gap-3 items-center mb-1">
                        <input @click="itemskeluarga.id_fas_bab = parseInt(d.id_fas_bab)" x-bind:checked="d.id_fas_bab == itemskeluarga.id_fas_bab" type="radio"/>
                        <label x-text='d.fas_bab'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                    </div>
                </template>
            </div>

        </x-card>


        <x-card>
            <div >
                <div>
                    <div class="font-semibold mb-3">Tempat pembuangan akhir tinja
                    </div>
                    <div class="gap-3">
                        <template x-for="d in getReferensiData('ref_jenis_kloset')">
                            <div class="flex gap-3 items-center mb-1">
                                <input @click="itemskeluarga.id_jenis_kloset = parseInt(d.id_jenis_kloset)" x-bind:checked="d.id_jenis_kloset == itemskeluarga.id_jenis_kloset" type="radio"/>
                                <label x-text='d.jenis_kloset'  class="text-sm text-slate-700 dark:text-slate-200"></label>
                            </div>
                        </template>
                    </div>
                </div>


                <div>
                    <div class="font-semibold mb-3 mt-4">Foto tempat akhir tinja</div>
                    <div x-data="imageCropperAkhirtinja()" class="w-full">
                        <!-- Input File -->
                        <input type="file" class="hidden" x-ref="fileInputAkhirtinja" x-on:change="openModalAkhirtinja"
                            accept="image/*" />

                        <!-- Preview Cropped Image -->
                        <div class="mt-4 text-center">
                            <img x-on:click="$refs.fileInputAkhirtinja.click()"
                                :src="itemskeluarga.foto_akhir_tinja ? itemskeluarga.foto_akhir_tinja : 'icons/nophoto.jpg'"
                                alt="Cropped Image" class="w-full object-cover rounded border p-2 bg-white mx-auto" />
                        </div>

                        <!-- Modal -->
                        <div x-show="isModalOpenAkhirtinja"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-scroll "
                            x-transition>
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">
                                <h2 class="text-lg font-bold mb-4">Crop Gambar</h2>

                                <!-- Crop Area -->
                                <div class="relative">
                                    <img x-ref="imageAkhirtinja" class="max-w-full rounded shadow-md" />
                                </div>

                                <!-- Modal Buttons -->
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                        x-on:click="closeModal">
                                        Batal
                                    </button>
                                    <button type="button"
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        x-on:click="cropImageAkhirtinja">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </x-card>

    </div>



    <x-button type="submit" @click="updateData" spinner icon="o-paper-airplane" class="btn-circle btn-sm h-14 w-14 z-30 text-base-100 shadow-lg bg-green-500 hover:bg-green-800 fixed bottom-5 right-3" />


    <div x-show="toast"
        x-transition:enter="transform ease-out duration-500"
        x-transition:enter-start="translate-y-4 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transform ease-in duration-500"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-4 opacity-0"
        class="fixed flex px-5 justify-between items-center z-40 text-green-600 left-0 bottom-0 bg-base-200 text-sm w-full shadow-lg p-3 rounded-t-lg">
        <span x-text="message"></span>
        <x-icon name="s-check-circle"/>
    </div>


</div>


<script>


function imageCropperAkhirtinja() 
    {
        return {
            isModalOpenAkhirtinja: false,
            cropperAkhirtinja: null,
            imageSrcAkhirtinja: null,
            croppedImageAkhirtinja: null,

            openModalAkhirtinja(event) {
                const file = event.target.files[0];
                if (!file) {
                    this.imageSrcAkhirtinja = null;
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageSrcAkhirtinja = e.target.result;
                    this.isModalOpenAkhirtinja = true;

                    this.$nextTick(() => {
                        const imageElement = this.$refs.imageAkhirtinja;

                        if (this.cropperAkhirtinja) {
                            this.cropperAkhirtinja.destroy();
                        }

                        imageElement.src = this.imageSrcAkhirtinja;

                        // Inisialisasi Cropper.js
                        this.cropperAkhirtinja = new Cropper(imageElement, {
                            aspectRatio: 3/2, // Ubah sesuai kebutuhan
                            viewMode: 2,
                        });
                    });
                };
                reader.readAsDataURL(file);
            },

            closeModal() {
                this.isModalOpenAkhirtinja = false;

                if (this.cropperAkhirtinja) {
                    this.cropperAkhirtinja.destroy();
                    this.cropperAkhirtinja = null;
                }
            },

            cropImageAkhirtinja() {
                if (!this.cropperAkhirtinja) return;

                // Ambil hasil crop
                const canvas = this.cropperAkhirtinja.getCroppedCanvas({
                    width: 600, // Ukuran hasil crop
                    height: 400,
                });

                this.croppedImageAkhirtinja = canvas.toDataURL('image/png');
                this.itemskeluarga.foto_akhir_tinja = this.croppedImageAkhirtinja;
                
                this.closeModal();
            },
        };
    }


function imageCropperBahanbakar() 
    {
        return {
            isModalOpenBahanbakar: false,
            cropperBahanbakar: null,
            imageSrcBahanbakar: null,
            croppedImageBahanbakar: null,

            openModalBahanbakar(event) {
                const file = event.target.files[0];
                if (!file) {
                    this.imageSrcBahanbakar = null;
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageSrcBahanbakar = e.target.result;
                    this.isModalOpenBahanbakar = true;

                    this.$nextTick(() => {
                        const imageElement = this.$refs.imageBahanbakar;

                        if (this.cropperBahanbakar) {
                            this.cropperBahanbakar.destroy();
                        }

                        imageElement.src = this.imageSrcBahanbakar;

                        // Inisialisasi Cropper.js
                        this.cropperBahanbakar = new Cropper(imageElement, {
                            aspectRatio: 3/2, // Ubah sesuai kebutuhan
                            viewMode: 2,
                        });
                    });
                };
                reader.readAsDataURL(file);
            },

            closeModal() {
                this.isModalOpenBahanbakar = false;

                if (this.cropperBahanbakar) {
                    this.cropperBahanbakar.destroy();
                    this.cropperBahanbakar = null;
                }
            },

            cropImageBahanbakar() {
                if (!this.cropperBahanbakar) return;

                // Ambil hasil crop
                const canvas = this.cropperBahanbakar.getCroppedCanvas({
                    width: 600, // Ukuran hasil crop
                    height: 400,
                });

                this.croppedImageBahanbakar = canvas.toDataURL('image/png');
                this.itemskeluarga.foto_dapur = this.croppedImageBahanbakar;
                
                this.closeModal();
            },
        };
    }

function imageCropperAir() 
    {
        return {
            isModalOpenAir: false,
            cropperAir: null,
            imageSrcAir: null,
            croppedImageAir: null,

            openModalAir(event) {
                const file = event.target.files[0];
                if (!file) {
                    this.imageSrcAir = null;
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageSrcAir = e.target.result;
                    this.isModalOpenAir = true;

                    this.$nextTick(() => {
                        const imageElement = this.$refs.imageAir;

                        if (this.cropperAir) {
                            this.cropperAir.destroy();
                        }

                        imageElement.src = this.imageSrcAir;

                        // Inisialisasi Cropper.js
                        this.cropperAir = new Cropper(imageElement, {
                            aspectRatio: 3/2, // Ubah sesuai kebutuhan
                            viewMode: 2,
                        });
                    });
                };
                reader.readAsDataURL(file);
            },

            closeModal() {
                this.isModalOpenAir = false;

                if (this.cropperAir) {
                    this.cropperAir.destroy();
                    this.cropperAir = null;
                }
            },

            cropImageAir() {
                if (!this.cropperAir) return;

                // Ambil hasil crop
                const canvas = this.cropperAir.getCroppedCanvas({
                    width: 600, // Ukuran hasil crop
                    height: 400,
                });

                this.croppedImageAir = canvas.toDataURL('image/png');
                this.itemskeluarga.foto_sumber_air_minum = this.croppedImageAir;
                
                this.closeModal();
            },
        };
    }


function imageCropperAtap() 
        {
            return {
                isModalOpenAtap: false,
                cropperAtap: null,
                imageSrcAtap: null,
                croppedImageAtap: null,

                openModalAtap(event) {
                    const file = event.target.files[0];
                    if (!file) {
                        this.imageSrcAtap = null;
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageSrcAtap = e.target.result;
                        this.isModalOpenAtap = true;

                        this.$nextTick(() => {
                            const imageElement = this.$refs.imageAtap;

                            if (this.cropperAtap) {
                                this.cropperAtap.destroy();
                            }

                            imageElement.src = this.imageSrcAtap;

                            // Inisialisasi Cropper.js
                            this.cropperAtap = new Cropper(imageElement, {
                                aspectRatio: 3/2, // Ubah sesuai kebutuhan
                                viewMode: 2,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },

                closeModal() {
                    this.isModalOpenAtap = false;

                    if (this.cropperAtap) {
                        this.cropperAtap.destroy();
                        this.cropperAtap = null;
                    }
                },

                cropImageAtap() {
                    if (!this.cropperAtap) return;

                    // Ambil hasil crop
                    const canvas = this.cropperAtap.getCroppedCanvas({
                        width: 600, // Ukuran hasil crop
                        height: 400,
                    });

                    this.croppedImageAtap = canvas.toDataURL('image/png');
                    this.itemskeluarga.foto_atap =  this.croppedImageAtap;
                    
                    this.closeModal();
                },
            };
        }


function imageCropperDinding() 
        {
            return {
                isModalOpenDinding: false,
                cropperDinding: null,
                imageSrcDinding: null,
                croppedImageDinding: null,

                openModalDinding(event) {
                    const file = event.target.files[0];
                    if (!file) {
                        this.imageSrcDinding = null;
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageSrcDinding = e.target.result;
                        this.isModalOpenDinding = true;

                        this.$nextTick(() => {
                            const imageElement = this.$refs.imageDinding;

                            if (this.cropperDinding) {
                                this.cropperDinding.destroy();
                            }

                            imageElement.src = this.imageSrcDinding;

                            // Inisialisasi Cropper.js
                            this.cropperDinding = new Cropper(imageElement, {
                                aspectRatio: 3/2, // Ubah sesuai kebutuhan
                                viewMode: 2,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },

                closeModal() {
                    this.isModalOpenDinding = false;

                    if (this.cropperDinding) {
                        this.cropperDinding.destroy();
                        this.cropperDinding = null;
                    }
                },

                cropImageDinding() {
                    if (!this.cropperDinding) return;

                    // Ambil hasil crop
                    const canvas = this.cropperDinding.getCroppedCanvas({
                        width: 600, // Ukuran hasil crop
                        height: 400,
                    });

                    this.croppedImageDinding = canvas.toDataURL('image/png');
                    this.itemskeluarga.foto_dinding = this.croppedImageDinding
                    
                    this.closeModal();
                },
            };
        }

    
    function imageCropperLantai() 
        {
            return {
                isModalOpenLantai: false,
                cropperLantai: null,
                imageSrcLantai: null,
                croppedImageLantai: null,

                openModalLantai(event) {
                    const file = event.target.files[0];
                    if (!file) {
                        this.imageSrcLantai = null;
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageSrcLantai = e.target.result;
                        this.isModalOpenLantai = true;

                        this.$nextTick(() => {
                            const imageElement = this.$refs.imageLantai;

                            if (this.cropperLantai) {
                                this.cropperLantai.destroy();
                            }

                            imageElement.src = this.imageSrcLantai;

                            // Inisialisasi Cropper.js
                            this.cropperLantai = new Cropper(imageElement, {
                                aspectRatio: 3/2, // Ubah sesuai kebutuhan
                                viewMode: 2,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },

                closeModal() {
                    this.isModalOpenLantai = false;

                    if (this.cropperLantai) {
                        this.cropperLantai.destroy();
                        this.cropperLantai = null;
                    }
                },

                cropImageLantai() {
                    if (!this.cropperLantai) return;

                    // Ambil hasil crop
                    const canvas = this.cropperLantai.getCroppedCanvas({
                        width: 600, // Ukuran hasil crop
                        height: 400,
                    });

                    this.croppedImageLantai = canvas.toDataURL('image/png');
                    this.itemskeluarga.foto_lantai = this.croppedImageLantai
                    
                    this.closeModal();
                },
            };
        }


    function imageCropperTamu() {
            return {
                isModalOpenTamu: false,
                cropperTamu: null,
                imageSrcTamu: null,
                croppedImageTamu: null,

                openModalTamu(event) {
                    const file = event.target.files[0];
                    if (!file) {
                        this.imageSrcTamu = null;
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageSrcTamu = e.target.result;
                        this.isModalOpenTamu = true;

                        this.$nextTick(() => {
                            const imageElement = this.$refs.imageTamu;

                            if (this.cropperTamu) {
                                this.cropperTamu.destroy();
                            }

                            imageElement.src = this.imageSrcTamu;

                            // Inisialisasi Cropper.js
                            this.cropperTamu = new Cropper(imageElement, {
                                aspectRatio: 3/2, // Ubah sesuai kebutuhan
                                viewMode: 2,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },

                closeModal() {
                    this.isModalOpenTamu = false;

                    if (this.cropperTamu) {
                        this.cropperTamu.destroy();
                        this.cropperTamu = null;
                    }
                },

                cropImageTamu() {
                    if (!this.cropperTamu) return;

                    // Ambil hasil crop
                    const canvas = this.cropperTamu.getCroppedCanvas({
                        width: 600, // Ukuran hasil crop
                        height: 400,
                    });

                    this.croppedImageTamu = canvas.toDataURL('image/png');
                    this.itemskeluarga.foto_ruang_tamu = this.croppedImageTamu

                    
                    this.closeModal();
                },
            };
        }



     function imageCropper() {
            return {
                isModalOpen: false,
                cropper: null,
                imageSrc: null,
                croppedImage: null,

                openModal(event) {
                    const file = event.target.files[0];
                    if (!file) {
                        this.imageSrc = null;
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageSrc = e.target.result;
                        this.isModalOpen = true;

                        this.$nextTick(() => {
                            const imageElement = this.$refs.image;

                            if (this.cropper) {
                                this.cropper.destroy();
                            }

                            imageElement.src = this.imageSrc;

                            // Inisialisasi Cropper.js
                            this.cropper = new Cropper(imageElement, {
                                aspectRatio: 3/2, // Ubah sesuai kebutuhan
                                viewMode: 2,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },

                closeModal() {
                    this.isModalOpen = false;

                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                },

                cropImage() {
                    if (!this.cropper) return;

                    // Ambil hasil crop
                    const canvas = this.cropper.getCroppedCanvas({
                        width: 600, // Ukuran hasil crop
                        height: 400,
                    });

                    this.croppedImage = canvas.toDataURL('image/png');
                    this.itemskeluarga.foto_depan_rumah = this.croppedImage
                    
                    this.closeModal();
                },
            };
        }


        // window.addEventListener("beforeunload", function (event) {
        //         // Menampilkan pesan konfirmasi
        //         const confirmationMessage = "Apakah Anda yakin ingin meninggalkan halaman ini?";
                
        //         // Menampilkan pesan konfirmasi pada browser
        //         event.returnValue = confirmationMessage; 
        //         return confirmationMessage;
        //     });


function getId(){
    const params = new URLSearchParams(window.location.search);
    console.log(params.get('id'));

    return params.get('id'); 
}


function getReferensiData(item_name) {
    if (localStorage.getItem(item_name)) {
        return this.results = JSON.parse(localStorage.getItem(item_name));
            
    }
}


</script>
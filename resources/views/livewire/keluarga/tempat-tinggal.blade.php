<div x-data="crudIndex" class="sm:p-5 md:p-7 p-2 pb-10" x-init="getDataFromIndexedDB(),getKeluargaId(getId())">

    <div class="flex justify-between gap-3 items-center px-2  pt-16 mt-3">
        <div>
            <x-icon name="s-map-pin" class="bg-pink-400 text-base-100 p-2 rounded h-9" />
        </div>
        <div class="w-full">
            <div class="font-bold uppercase">Keterangan Tempat Tinggal</div>
            <div x-text="itemskeluarga.nama" class="uppercase"></div>
            <div class="flex items-center mt-1 text-pink-500">
                <x-icon name="o-user" class="h-3 me-1" />
                <div x-text="itemskeluarga.jenis_kelamin == 'L' ? 'Pria' : 'Wanita'" class="text-xs me-4"></div>
                <x-icon name="o-calendar-days" class="h-3 me-1" />
                <div x-text="'Lahir '+itemskeluarga.tanggal_lahir" class="text-xs me-4"></div>
                <x-icon name="o-key" class="h-3 me-1" />
                <div x-text="itemskeluarga.nomor_kk ? 'KK '+itemskeluarga.nomor_kk : 'ID Keluarga '+itemskeluarga.id_keluarga"
                    class="text-xs"></div>
            </div>
            <div>

            </div>
        </div>

    </div>


    <x-card class="mt-5">

        <div x-data="{
        rt: '',
        rw: '',
        provinsi: '',
        kab: '',
        kec: '',
        kel: '',
        alamat: '',
        latitude: '',
        longitude: '',
        }">

            <div class="grid gap-2 grid-cols-2 sm:grid-cols-3">
                <div class="">
                    <span class="font-semibold text-sm">Provinsi</span>
                    <select required>
                        <option value="Gorontalo" selected>Gorontalo</option>
                    </select>
                </div>
                <div>
                    <span class="font-semibold text-sm">Kabupaten/Kota</span>
                    <select x-model="kab" required>
                        <option value="" selected hidden>Pilih opsi...</option>
                        <template x-for="(item, index) in getReferensiData('wil_kab')" x-key="index">
                            <option x-bind:selected="itemskeluarga.kode_kab == item.kode_kab"
                                x-bind:value="item.kode_kab" x-text="item.kabkota"></option>
                        </template>
                    </select>
                </div>
                <div x-data="{kecamatan:[], get filterKec(){
                return this.kab ? this.kecamatan.filter(k => k.kode_kab == kab) : this.kecamatan;
            }}" x-init="kecamatan = getReferensiData('wil_kec')">
                    <span class="font-semibold text-sm">Kecamatan</span>
                    <select x-model="kec" disabled required>
                        <option value="" selected hidden>Pilih opsi...</option>
                        <template x-for="(item, index) in filterKec" x-key="index">
                            <option x-bind:selected="itemskeluarga.kode_kec == item.kode_kec"
                                x-bind:value="item.kode_kec" x-text="item.kecamatan"></option>
                        </template>
                    </select>
                </div>

                <div x-data="{kelurahan:[], get filterKel(){
                return this.kec ? this.kelurahan.filter(k => k.kode_kec == kec) : this.kelurahan;
            }}" x-init="kelurahan = getReferensiData('wil_kel')">
                    <span class="font-semibold text-sm">Desa/Kelurahan</span>
                    <select @change="itemskeluarga.kode_kel=kel" x-model="kel" required disabled>
                        <option value="" selected hidden>Pilih opsi...</option>
                        <template x-for="item in filterKel" x-key="item.kode_kel">
                            <option x-bind:selected="itemskeluarga.kode_kel == item.kode_kel"
                                x-bind:value="item.kode_kel" x-text="item.kelurahan"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <span class="font-semibold text-sm">RT/Dusun</span>
                    <x-input disabled @keyup="itemskeluarga.rt = rt" x-model="rt" x-bind:value="itemskeluarga.rt"
                        class="text-sm h-9 w-full input-sm" placeholder="RT" />
                </div>
                <div>
                    <span class="font-semibold text-sm">RW</span>
                    <x-input @keyup="itemskeluarga.rw = rw" x-model="rw" x-bind:value="itemskeluarga.rw"
                        class="text-sm h-9 w-full input-sm" placeholder="RW" />
                </div>

                <div class="col-span-full">
                    <x-input @keyup="itemskeluarga.alamat_rumah = alamat" x-model="alamat"
                        x-bind:value="itemskeluarga.alamat_rumah" label="Alamat" class="text-sm h-9 w-full input-sm"
                        placeholder="Alamat" />
                </div>
            </div>
        </div>

    </x-card>

    <x-card subtitle="Klik tombol get untuk mengambil lokasi saat ini" shadow separator class="mt-3">
        <div x-data="locationTracker()" class="grid grid-cols-2 gap-1">
            <div>
                <x-input @change="itemskeluarga.koordinat_lat = latitude" x-model="latitude"
                    x-bind:value="itemskeluarga.koordinat_lat" label="Latitude" class="input-sm h-9" />
            </div>
            <div>
                <x-input @change="itemskeluarga.koordinat_lng = longitude" x-model="longitude"
                    x-bind:value="itemskeluarga.koordinat_lng" label="Longitude" class="input-sm h-9" />
            </div>
            <div class="col-span-full flex items-center justify-between">
                <p x-text="errorMessage" x-show="errorMessage" class="text-red-500 mt-2 text-sm"></p>
                <x-button @click="getLocation" spinner label="Set Lokasi" icon="s-map-pin" class="btn-sm btn-outline" />
            </div>
        </div>
    </x-card>


    <x-card class="mt-3" x-data="{responden_nama:'', signShow: true}">
        <div>
            <div>
                <div class="font-semibold mb-3">Keterangan?</div>
                <div class="gap-3">
                    <template x-for="d in getReferensiData('ref_responden_sedia')">
                        <div class="flex gap-3 items-center mb-1">
                            <input @click="itemskeluarga.id_responden_sedia = parseInt(d.id_responden_sedia)"
                                x-bind:checked="d.id_responden_sedia == itemskeluarga.id_responden_sedia"
                                type="radio" />
                            <label x-text='d.responden_sedia'
                                class="text-sm text-slate-700 dark:text-slate-200"></label>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div x-data="signaturePad">
            <div class="grid w-full mt-7 mb-3 justify-center" x-show="itemskeluarga.id_responden_sedia == 1"
                x-effect="itemskeluarga.responden_ttd != null ? signShow=false : signShow=true ">

                <div x-show="signShow"
                    class="border signature-pad border-pink-400 border-dashed dark:bg-slate-400 rounded-lg"
                    style="width: 270px; height:150px" x-ref="pad" @mousedown="startDrawing($event)"
                    @mousemove="draw($event)" @mouseup="stopDrawing" @mouseleave="stopDrawing"
                    @touchstart="startDrawing($event)" @touchmove="draw($event)" @touchend="stopDrawing"></div>

                <div x-show="!signShow" class=" dark:bg-slate-400 rounded-lg">
                    <img :src="itemskeluarga.responden_ttd" width="100%" alt="">
                </div>

                <!-- Tombol kontrol -->
                <div x-show="signShow" class="flex justify-end gap-1 pe-2 mb-4 z-30 -mt-10 ">
                    <x-button icon="o-trash" class="btn-sm btn-circle" @click="clearPad"></x-button>
                    <x-button icon="s-check-circle" class="btn-sm btn-circle text-white btn-success"
                        @click="saveSignature"></x-button>
                </div>
                <div x-show="!signShow" class="flex justify-end gap-1 pe-2 mb-4 z-30 -mt-10 ">
                    <x-button icon="s-arrow-path" class="btn-sm btn-circle " @click="signShow = !signShow"></x-button>
                </div>


                <x-input @keyup="itemskeluarga.responden_nama = responden_nama" x-model="responden_nama"
                    x-bind:value="itemskeluarga.responden_nama || itemskeluarga.nama"
                    class="text-sm h-9 font-bold w-full text-center max-w-72 input-sm" placeholder="Nama Responden" />
                <div class="text-sm text-slate-500">Nama Anggota Keluarga/Responden</div>
                <div x-effect="itemskeluarga.tanggal_pendataan = new Date().toLocaleString()" x-text="new Date().toLocaleString()" class="text-sm text-slate-500"></div>
            </div>
        </div>

    </x-card>



    <x-button type="submit" @click="updateData()" spinner icon="o-paper-airplane"
        class="btn-circle btn-sm h-14 w-14 z-30 text-base-100 shadow-lg bg-pink-500 hover:bg-pink-700 fixed bottom-5 right-3" />

    @livewire('components.toast')

</div>

<script>
    function locationTracker() {
        return {
            latitude: null,
            longitude: null,
            errorMessage: null,

            // Function to get the user's location
            getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.latitude = position.coords.latitude;
                            this.longitude = position.coords.longitude;
                            this.errorMessage = null; // Reset error message if successful
                        },
                        (error) => {
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    this.errorMessage = "User denied the request for Geolocation.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    this.errorMessage = "Location information is unavailable.";
                                    break;
                                case error.TIMEOUT:
                                    this.errorMessage = "The request to get user location timed out.";
                                    break;
                                default:
                                    this.errorMessage = "An unknown error occurred.";
                                    break;
                            }
                        }
                    );
                } else {
                    this.errorMessage = "Geolocation is not supported by this browser.";
                }
            },
        };
    }



    function getId(){
        const params = new URLSearchParams(window.location.search);
        console.log(params.get('id'));
        
        return params.get('id'); 
    }


    function getReferensiData(item_name) {
        if (localStorage.getItem(item_name)) {
            return this.results = JSON.parse(localStorage.getItem(item_name));
            console.log(this.results);
            
        }
    }
    




    document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                base64Signature: '',
                isDrawing: false,
                lastPosition: { x: 0, y: 0 },
                ctx: null,
                canvas: null,

                init() {
                    // Buat canvas secara dinamis di dalam div
                    const pad = this.$refs.pad;
                    this.canvas = document.createElement('canvas');
                    this.canvas.width = pad.clientWidth;
                    this.canvas.height = pad.clientHeight;
                    pad.appendChild(this.canvas);
                    this.ctx = this.canvas.getContext('2d');
                    this.ctx.lineWidth = 2;
                    this.ctx.lineCap = 'round';
                },

                getPosition(event) {
                    const rect = this.canvas.getBoundingClientRect();
                    if (event.touches) {
                        return {
                            x: event.touches[0].clientX - rect.left,
                            y: event.touches[0].clientY - rect.top,
                        };
                    }
                    return {
                        x: event.clientX - rect.left,
                        y: event.clientY - rect.top,
                    };
                },

                startDrawing(event) {
                    this.isDrawing = true;
                    const pos = this.getPosition(event);
                    this.lastPosition = pos;
                    this.ctx.beginPath();
                    this.ctx.moveTo(pos.x, pos.y);
                },

                draw(event) {
                    if (!this.isDrawing) return;
                    const pos = this.getPosition(event);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.stroke();
                    this.lastPosition = pos;
                },

                stopDrawing() {
                    this.isDrawing = false;
                    this.ctx.closePath();
                },

                clearPad() {
                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    this.base64Signature = '';
                },

                saveSignature() {
                    this.base64Signature = this.canvas.toDataURL('image/png');
                    this.itemskeluarga.responden_ttd = this.base64Signature;
                    console.log(this.itemskeluarga.responden_ttd);
                    
                },
            }));
        });

</script>
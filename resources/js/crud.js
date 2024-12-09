

const databaseName = "bnbaDB";
const databaseVersion = 1;

createTwoTables();


Alpine.data('crudIndex', () => ({
    dataindividu: [],
    datakeluarga: [],
    currentindividu: '',
    currentkeluarga: '',
    anggotakeluarga: [],
    itemskeluarga:'',
    itemsindividukk:'',
    itemsindividu:'',
    currentTable: '',
    searchKeluarga: '',
    searchAnggota: '',
    currentItem: null,
    toast: false,
    toasterror: false,
    message: '',
    modalAdd: false,
    itemAddIndividu: {
            nik: '',
            nama: '',
            jenis_kelamin: '',
            id_keluarga: '',
            id_individu: '',
        },
    itemAddKeluarga: {
            nomor_kk: '',
            id_keluarga: '',
            kode_kel: '',
            kelurahan: '',
            kode_kec: '',
            kecamatan: '',
            kode_kab: '',
            kabkota: '',
        },
    individu_insertserver: '',
    keluarga_insertserver: '',
    individu_created: '',
    keluarga_created: '',
    individu_updated: '',
    keluarga_updated: '',
    menolak: '',
    showDataList: [],
    showDataList_title: '',
    online: navigator.onLine,
    
    
    showList(data, title){
        this.showDataList = data;
        this.showDataList_title = title;
    },

    filterKeluarga(){
        const data =  this.datakeluarga.filter((item) => {
            return item.items.nama.toUpperCase().includes(this.searchKeluarga.toUpperCase()) || item.items.nomor_kk === this.searchKeluarga;
        });
        
        return data.sort((a, b) => b.id - a.id);
        
    },
    
    filterAnggota(){
        return this.anggotakeluarga.filter((item) => item.items.nama.toUpperCase().includes(this.searchAnggota.toUpperCase()));
    },

    

    getKeluargaId(id) {

        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;

            // Membaca data dari keluarga
            const transactionkeluarga = db.transaction('keluarga', 'readwrite');
            const keluargaStore = transactionkeluarga.objectStore('keluarga');
            const getDatakeluarga = keluargaStore.get(Number(id));

            getDatakeluarga.onsuccess = () => {
                this.currentkeluarga = getDatakeluarga.result;
                this.itemskeluarga = this.currentkeluarga.items;

                const cek = this.dataindividu.filter(item => item.items.nik === this.itemskeluarga.nik);

                if(cek.length > 0) {
                    this.currentindividu = cek[0];
                    this.itemsindividukk = this.currentindividu.items;
                }

                const anggota = this.dataindividu.filter(item => item.items.id_keluarga === this.itemskeluarga.id_keluarga);
                if(anggota.length > 0) {
                    this.anggotakeluarga = anggota;
                }

                console.log(this.anggotakeluarga);
                
                
            };

            transactionkeluarga.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },
    
    getIndividuId(id) {

        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;

            // Membaca data dari individu
            const transactionindividu = db.transaction('individu', 'readonly');
            const individuStore = transactionindividu.objectStore('individu');
            const getDataindividu = individuStore.get(Number(id));

            getDataindividu.onsuccess = () => {
                this.currentindividu = getDataindividu.result;
                this.itemsindividu = this.currentindividu.items;
                console.log(this.itemsindividu);
                
            };

            // Membaca data dari keluarga

            transactionindividu.oncomplete = () => {
                db.close();
            };
            
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    // Fungsi untuk membuka database dan membaca data
    getDataFromIndexedDB() {

        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;

            // Membaca data dari individu
            const transactionindividu = db.transaction('individu', 'readonly');
            const individuStore = transactionindividu.objectStore('individu');
            const getAllRequestindividu = individuStore.getAll();

            getAllRequestindividu.onsuccess = () => {
                this.dataindividu = getAllRequestindividu.result;
                this.individu_insertserver = this.dataindividu.filter(i => i.insertserver == true)
                this.individu_created = this.dataindividu.filter(i => i.created == true)
                this.individu_updated = this.dataindividu.filter(i => i.updated == true)
                
                console.log(this.dataindividu);

                
            };

            // Membaca data dari keluarga
            const transactionkeluarga = db.transaction('keluarga', 'readonly');
            const keluargaStore = transactionkeluarga.objectStore('keluarga');
            const getAllRequestkeluarga = keluargaStore.getAll();

            getAllRequestkeluarga.onsuccess = () => {
                this.datakeluarga = getAllRequestkeluarga.result;
                
                this.keluarga_insertserver = this.datakeluarga.filter(i => i.insertserver === true)
                this.keluarga_created = this.datakeluarga.filter(i => i.created === true)
                this.keluarga_updated = this.datakeluarga.filter(i => i.updated === true)
                this.menolak = this.datakeluarga.filter(i => i.items.id_responden_sedia == 2)

                console.log(this.datakeluarga);
                
                
            };

            transactionindividu.oncomplete = () => {
                db.close();
            };
            transactionkeluarga.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },


    addDataKeluarga() {
        const request = indexedDB.open(databaseName, databaseVersion);
        const table = 'keluarga';
        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction(table, 'readwrite');
            const store = transaction.objectStore(table);
            const addRequest = store.add(
                {
                    items: JSON.parse(JSON.stringify(this.itemAddKeluarga)),
                    updated: true,
                    created: true,
                    insertserver: false,
                }
            );

            addRequest.onsuccess = () => {

                this.itemAddIndividu.id_individu = this.itemAddKeluarga.id_keluarga+11;
                this.itemAddIndividu.id_keluarga = this.itemAddKeluarga.id_keluarga
                this.itemAddIndividu.nik = this.itemAddKeluarga.nik
                this.itemAddIndividu.nama = this.itemAddKeluarga.nama
                this.itemAddIndividu.id_hubungan_keluarga = '1'

                
                this.getDataFromIndexedDB(); // Reload data
                this.itemAddKeluarga = '';
                
                
                this.addDataIndividu();

                this.toast = true;
                        this.message = "Data ditambahkan!";
                        setTimeout(() => {
                            this.toast = false;
                        }, 2000)
            };

            addRequest.onerror = (event) => {
                console.error('Error adding data:', event.target.errorCode);
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },


    // Fungsi untuk menambahkan data
    addDataIndividu() {
        const request = indexedDB.open(databaseName, databaseVersion);
        const table = 'individu';
        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction(table, 'readwrite');
            const store = transaction.objectStore(table);
            const addRequest = store.add(
                {
                    items: JSON.parse(JSON.stringify(this.itemAddIndividu)),
                    updated: true,
                    created: true,
                    insertserver: false,
                }
            );

            addRequest.onsuccess = () => {

                this.getDataFromIndexedDB(); // Reload data
                this.itemAddIndividu = '';
                const params = new URLSearchParams(window.location.search);
                if(params.get('id')){
                    this.getKeluargaId(params.get('id'));
                }


                this.toast = true;
                        this.message = "Data ditambahkan!";
                        setTimeout(() => {
                            this.toast = false;
                        }, 2000)
            };

            addRequest.onerror = (event) => {
                console.error('Error adding data:', event.target.errorCode);
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    updateSosial(){
        this.updateData()
        this.updateIndividuKK()
    },


    updateIndividu() {
        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction('individu', 'readwrite');
            const store = transaction.objectStore('individu');
            const getRequest = store.get(this.currentindividu.id);

            getRequest.onsuccess = () => {
                const item = getRequest.result;
                this.currentindividu.items = JSON.parse(JSON.stringify(this.itemsindividu));
                this.currentindividu.updated = true;

                if (item) {
                    Object.assign(item, JSON.parse(JSON.stringify(this.currentindividu)));
                    const putRequest = store.put(item);

                    putRequest.onsuccess = () => {
                        this.getDataFromIndexedDB(); // Reload data
                        this.toast = true;
                        this.message = "Data diperbarui!";
                        setTimeout(() => {
                            this.toast = false;
                        }, 2000)
                    };

                    putRequest.onerror = (event) => {
                        console.error('Error updating data:', event.target.errorCode);
                    };
                } else {
                    alert('Item not found.');
                }
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    updateIndividuKK() {
        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction('individu', 'readwrite');
            const store = transaction.objectStore('individu');
            const getRequest = store.get(this.currentindividu.id);

            getRequest.onsuccess = () => {
                const item = getRequest.result;
                this.currentindividu.items = JSON.parse(JSON.stringify(this.itemsindividukk));
                this.currentindividu.updated = true;

                if (item) {
                    Object.assign(item, JSON.parse(JSON.stringify(this.currentindividu)));
                    const putRequest = store.put(item);

                    putRequest.onsuccess = () => {
                        this.getDataFromIndexedDB(); // Reload data
                        this.toast = true;
                        this.message = "Data diperbarui!";
                        setTimeout(() => {
                            this.toast = false;
                        }, 2000)
                    };

                    putRequest.onerror = (event) => {
                        console.error('Error updating data:', event.target.errorCode);
                    };
                } else {
                    alert('Item not found.');
                }
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    // Fungsi untuk memperbarui data
    updateData() {
        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction('keluarga', 'readwrite');
            const store = transaction.objectStore('keluarga');
            const getRequest = store.get(this.currentkeluarga.id);

            getRequest.onsuccess = () => {
                const item = getRequest.result;
                this.currentkeluarga.items = JSON.parse(JSON.stringify(this.itemskeluarga));
                this.currentkeluarga.updated = true;
                if (item) {
                    Object.assign(item, JSON.parse(JSON.stringify(this.currentkeluarga)));
                    const putRequest = store.put(item);

                    putRequest.onsuccess = () => {
                        this.getDataFromIndexedDB(); // Reload data
                        this.toast = true;
                        this.message = "Data diperbarui!";
                        setTimeout(() => {
                            this.toast = false;
                        }, 2000)
                    };

                    

                    putRequest.onerror = (event) => {
                        console.error('Error updating data:', event.target.errorCode);
                    };
                } else {
                    alert('Item not found.');
                }
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    updateStatusKeluarga(id) {
        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction('keluarga', 'readwrite');
            const store = transaction.objectStore('keluarga');
            const getRequest = store.get(id);

            getRequest.onsuccess = () => {
                const item = getRequest.result;
                if (item) {
                    item.updated = false;
                    item.insertserver = true;
                    const putRequest = store.put(item);

                    putRequest.onsuccess = () => {
                        this.getDataFromIndexedDB(); // Reload data
                        this.toast = true;
                        this.message = "Berhasil singkron Keluarga!";
                        setTimeout(() => {
                            this.toast = false;
                        }, 2000)
                    };

                    

                    putRequest.onerror = (event) => {
                        console.error('Error updating data:', event.target.errorCode);
                    };
                } else {
                    alert('Item not found.');
                }
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    updateStatusIndividu(id) {
        const request = indexedDB.open(databaseName, databaseVersion);

        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction('individu', 'readwrite');
            const store = transaction.objectStore('individu');
            const getRequest = store.get(id);

            getRequest.onsuccess = () => {
                const item = getRequest.result;
                if (item) {
                    item.updated = false;
                    item.insertserver = true;
                    const putRequest = store.put(item);

                    putRequest.onsuccess = () => {
                        this.getDataFromIndexedDB(); // Reload data
                        this.toast = true;
                        this.message = "Berhasil singkron Individu";
                        setTimeout(() => {
                            this.toast = false;
                        }, 2000)
                    };

                    

                    putRequest.onerror = (event) => {
                        console.error('Error updating data:', event.target.errorCode);
                    };
                } else {
                    alert('Item not found.');
                }
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    // Fungsi untuk menghapus data
    deleteIndividu(id) {
        
        const request = indexedDB.open(databaseName, databaseVersion);
        const table = 'individu';
        request.onsuccess = (event) => {
            const db = event.target.result;
            const transaction = db.transaction(table, 'readwrite');
            const store = transaction.objectStore(table);
            const deleteRequest = store.delete(id);

            deleteRequest.onsuccess = () => {
                this.getDataFromIndexedDB();
                window.history.back();
            };

            deleteRequest.onerror = (event) => {
                console.error('Error deleting data:', event.target.errorCode);
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    deleteKeluarga(id) {
        
        const request = indexedDB.open(databaseName, databaseVersion);
        const table = 'keluarga';
        request.onsuccess = (event) => {
            
            const db = event.target.result;
            const transaction = db.transaction(['individu','keluarga'], 'readwrite');
            const store = transaction.objectStore(table);
            
            const storeInd = transaction.objectStore('individu');
            const dindividu = storeInd.getAll();
            dindividu.onsuccess = (event) => {
                const ambil = dindividu.result.filter(d => d.items.id_keluarga == this.currentkeluarga.items.id_keluarga);     
                ambil.forEach(element => {
                    storeInd.delete(element.id);
                });
            }
            
            const deleteRequest = store.delete(id);

            deleteRequest.onsuccess = () => {
                this.getDataFromIndexedDB(); // Reload data
                window.location = '/';
            };

            deleteRequest.onerror = (event) => {
                console.error('Error deleting data:', event.target.errorCode);
            };

            transaction.oncomplete = () => {
                db.close();
            };
        };

        request.onerror = (event) => {
            console.error('Error opening database:', event.target.errorCode);
        };
    },

    // Fungsi untuk memilih tabel yang aktif
    selectTable(table) {
        this.currentTable = table;
    },

    showToast() {
        this.isToastVisible = true;
        setTimeout(() => {
          this.isToastVisible = false;
        }, 3000); // Hide toast after 3 seconds
      },
    onLine(){
        window.addEventListener('online', () => {
            this.online = true;   
        });
        window.addEventListener('offline', () => {
            this.online = false;
        });
        Livewire.on('alert-keluarga-up', (data) => {
                        
            this.updateStatusKeluarga(data[0]);
        })
        Livewire.on('alert-individu-up', (data) => {
            
            this.updateStatusIndividu(data[0]);
        })
    },
    
    keluargaUpServer(){
        if(this.keluarga_updated.length > 0){

            
            if(this.online){
                Livewire.dispatch('keluarga-up', {data: this.keluarga_updated})
                
            }else{
                this.toasterror = true;
                this.message = "Anda sedang offline!";
                    setTimeout(() => {
                    this.toasterror = false;
                }, 2000)
            }
        }else{
            this.toasterror = true;
                this.message = "Tidak ada data untuk disinkron !";
                    setTimeout(() => {
                    this.toasterror = false;
                }, 2000)
        }
        
        
    },
    
    individuUpServer(){
        if(this.individu_updated.length > 0){
            if(this.online){
                Livewire.dispatch('individu-up', {data: this.individu_updated})
            }else{
                this.toasterror = true;
                this.message = "Anda sedang offline!";
                    setTimeout(() => {
                    this.toasterror = false;
                }, 2000)
            }
        }else{
            this.toasterror = true;
                this.message = "Tidak ada data untuk disinkron!";
                    setTimeout(() => {
                    this.toasterror = false;
                }, 2000)
        }
        
        
    },

}))







Livewire.on('insertData', (data) => {

    const request = indexedDB.open(databaseName, databaseVersion);

    request.onsuccess = (event) => {

        const db = event.target.result;

        // Membuka transaksi untuk kedua tabel
        const transaction = db.transaction(['individu', 'keluarga'], 'readwrite');

        // Referensi untuk individu
        const individuStore = transaction.objectStore('individu');

        const keluargaStore = transaction.objectStore('keluarga');

        keluargaStore.clear();
        individuStore.clear();

        // Menambahkan data ke individu
        const dt = JSON.parse(JSON.stringify(...data));

        const dataForkeluarga = dt.keluarga
        const dataForindividu = dt.individu

        // Menambahkan data ke individu
        dataForindividu.forEach((item) => {
            const addRequest = individuStore.add({
                items: item,
                updated: false,
                created: false,
                insertserver: false,
            });
            addRequest.onsuccess = () => console.log('Data added to individu');
            addRequest.onerror = (event) =>
                console.error('Error adding data to individu:', event.target.errorCode);
        });
        
        // Menambahkan data ke keluarga
        dataForkeluarga.forEach((item) => {
            const addRequest = keluargaStore.add({
                items: item,
                updated: false,
                created: false,
                insertserver: false,

            });
            addRequest.onsuccess = () => console.log('Data added to individu');
            addRequest.onerror = (event) =>
                console.error('Error adding data to individu:', event.target.errorCode);
        });


        transaction.oncomplete = () => {
            console.log('Transaction completed: Data successfully added to both tables.');
            db.close();
        };

        transaction.onerror = (event) => {
            console.error('Transaction error:', event.target.errorCode);
        };
    };

    request.onerror = (event) => {
        console.error('Error opening database:', event.target.errorCode);
    };
});






function createTwoTables() {

    const request = indexedDB.open(databaseName, databaseVersion);

    request.onupgradeneeded = (event) => {
        const db = event.target.result;

        // Membuat tabel pertama jika belum ada
        if (!db.objectStoreNames.contains('individu')) {
            db.createObjectStore('individu', { keyPath: 'id', autoIncrement: true });
            console.log('Tabel "Individu" berhasil dibuat.');
        }

        // Membuat tabel kedua jika belum ada
        if (!db.objectStoreNames.contains('keluarga')) {
            db.createObjectStore('keluarga', { keyPath: 'id', autoIncrement: true });
            console.log('Tabel "Keluarga" berhasil dibuat.');
        }
    };

    request.onsuccess = (event) => {
        console.log('Database berhasil dibuat atau dibuka.');
        const db = event.target.result;
        db.close(); // Menutup koneksi database
    };

    request.onerror = (event) => {
        console.error('Error saat membuka database:', event.target.errorCode);
    };


}


Livewire.on('createLocalStorage', (data)=> {
    const dt = JSON.parse(JSON.stringify(...data));
    localStorage.setItem(dt.name, JSON.stringify(dt.data))
})






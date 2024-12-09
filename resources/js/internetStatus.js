document.addEventListener('alpine:init', () => {
    Alpine.data('internetStatus', ()=> ({
        
        online: navigator.onLine,

        init() {
      // Listen for online and offline events
            window.addEventListener('online', () => {
                this.online = true;
            });
            window.addEventListener('offline', () => {
                this.online = false;
            });
        }
    }))
})

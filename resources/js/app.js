import './bootstrap';

import './internetStatus.js';

import './crud.js';

import mask from '@alpinejs/mask'
 
Alpine.plugin(mask)

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
      .then(function(registration) {
        console.log('Service Worker registered with scope:', registration.scope);
      })
      .catch(function(error) {
        console.log('Service Worker registration failed:', error);
      });
  }




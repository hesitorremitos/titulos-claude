import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Alpine.js setup
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import persist from '@alpinejs/persist';

Alpine.plugin(collapse);
Alpine.plugin(persist);

window.Alpine = Alpine;
Alpine.start();

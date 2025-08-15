import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Livewire v3 + Alpine.js integration
import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Import only the Alpine.js plugins that are NOT included in Livewire by default
// Note: Livewire v3 already includes: persist, intersect, morph, navigate, etc.
import collapse from '@alpinejs/collapse';

// Register only the plugins not included by default in Livewire
Alpine.plugin(collapse);

// Start Livewire (this automatically starts Alpine as well)
Livewire.start();

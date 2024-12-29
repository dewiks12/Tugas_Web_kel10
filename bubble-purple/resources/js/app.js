import './bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';

window.Alpine = Alpine;
Alpine.start();

// Theme handling
document.addEventListener('DOMContentLoaded', () => {
    const theme = localStorage.getItem('theme') || 'light';
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    }
});

// Theme toggle function
window.toggleTheme = function() {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    
    // Save theme preference to server
    axios.post('/settings/theme', {
        theme: isDark ? 'dark' : 'light'
    });
};

// Ajax setup
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}

// Global Ajax loading indicator
let loadingTimeout;
axios.interceptors.request.use(config => {
    loadingTimeout = setTimeout(() => {
        document.body.classList.add('loading');
    }, 200);
    return config;
});

axios.interceptors.response.use(
    response => {
        clearTimeout(loadingTimeout);
        document.body.classList.remove('loading');
        return response;
    },
    error => {
        clearTimeout(loadingTimeout);
        document.body.classList.remove('loading');
        
        if (error.response?.status === 419) {
            // CSRF token mismatch, reload the page
            window.location.reload();
        }
        
        return Promise.reject(error);
    }
);

// Global Ajax functions
window.ajaxRequest = async function(method, url, data = null, options = {}) {
    try {
        const response = await axios({
            method,
            url,
            data,
            ...options
        });
        return response.data;
    } catch (error) {
        console.error('Ajax request failed:', error);
        throw error;
    }
};

// Notification handling
window.showNotification = function(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } transition-opacity duration-500`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
};

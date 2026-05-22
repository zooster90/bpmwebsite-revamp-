import axios from 'axios';
window.axios = axios;

// 为所有的 AJAX 请求设置默认的 Header，这样 Laravel 才能识别它们
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
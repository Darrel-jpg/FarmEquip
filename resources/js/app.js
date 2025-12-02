import './bootstrap';
import 'flowbite';

document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('flash-alert');
    if (flash) {
        setTimeout(() => {
            flash.classList.add('fade-out');
            setTimeout(() => flash.remove(), 500);
        }, 3200);
    }
});
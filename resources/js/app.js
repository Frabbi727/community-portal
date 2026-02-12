import './bootstrap';

const menuToggle = document.querySelector('[data-menu-toggle]');
const header = document.querySelector('.site-header');

if (menuToggle && header) {
    menuToggle.addEventListener('click', () => {
        header.classList.toggle('is-open');
    });
}

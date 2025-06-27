import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;

import Swiper from 'swiper';
import { Autoplay, EffectCoverflow, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/effect-coverflow';
import 'swiper/css/pagination';

document.addEventListener('DOMContentLoaded', function () {

    // Inisialisasi untuk Home Slider (Efek Coverflow)
    const homeSlider = new Swiper(".home-slider", {
        modules: [Autoplay, EffectCoverflow], // <-- Daftarkan modul yang digunakan
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true,
        coverflowEffect: {
            rotate: 20,
            stretch: -20, // Nilai negatif agar slide saling berdekatan
            depth: 250,
            modifier: 1,
            slideShadows: true,
        },
        autoplay: {
            delay: 3500, // <-- Disesuaikan agar tidak terlalu cepat
            disableOnInteraction: false,
        },
    });

    // Inisialisasi untuk Review Slider
    const reviewSlider = new Swiper(".review-slider", {
        modules: [Autoplay, Pagination], // <-- Daftarkan modul yang digunakan
        slidesPerView: 1,
        grabCursor: true,
        loop: true,
        spaceBetween: 20, // Memberi jarak antar slide
        pagination: {
            el: '.swiper-pagination', // <-- Menghubungkan ke elemen pagination di HTML
            clickable: true,
        },
        breakpoints: {
            640: { // Untuk layar > 640px
                slidesPerView: 2,
            },
            1024: { // Untuk layar > 1024px
                slidesPerView: 3,
            },
        },
        autoplay: {
            delay: 4000, // <-- Disesuaikan agar tidak terlalu cepat
            disableOnInteraction: false,
        }
    });

    // Kode untuk Mobile Menu & Theme Toggler dari sebelumnya
    // (Jika Anda menaruhnya di sini)
    const menuBars = document.getElementById('menu-bars');
    const mobileMenu = document.getElementById('mobile-menu');
    if(menuBars && mobileMenu) {
        menuBars.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            menuBars.querySelector('i').classList.toggle('fa-bars');
            menuBars.querySelector('i').classList.toggle('fa-times');
        });
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                menuBars.querySelector('i').classList.add('fa-bars');
                menuBars.querySelector('i').classList.remove('fa-times');
            });
        });
    }

    const themeToggler = document.getElementById('theme-toggler');
    const toggleBtn = document.getElementById('toggle-btn');
    if(themeToggler && toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            themeToggler.classList.toggle('-right-full');
            themeToggler.classList.toggle('right-0');
        });

        document.querySelectorAll('.theme-btn').forEach(button => {
            button.addEventListener('click', () => {
                const color = button.style.backgroundColor;
                document.documentElement.style.setProperty('--main-color', color);
            });
        });
    }
});

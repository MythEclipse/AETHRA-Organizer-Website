import './bootstrap';

import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
window.Alpine = Alpine;
document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper(".home-slider", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        initialSlide: 1,
        coverflowEffect: {
            rotate: 20,    // Tetap dengan rotasi untuk efek miring
            stretch: -20,  // <--- UBAH INI: Berikan nilai negatif untuk membuat slide berdempet
            depth: 250,    // Tetap dengan kedalaman untuk efek "di belakang"
            modifier: 1,   // Tetap dengan modifier
            slideShadows: true,
        },
        loop: true,
        autoplay: {
            delay: 1000,
            disableOnInteraction: false,
        },
    });

    var swiper2 = new Swiper(".review-slider", {
        slidesPerView: 1,
        grabCursor: true,
        loop: true,
        centeredSlides: true,
        initialSlide: 1,
        spaceBetween: 10,
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            700: {
                slidesPerView: 2,
            },
            1050: {
                slidesPerView: 3,
            },
        },
        autoplay: {
            delay: 1000,
            disableOnInteraction: false,
        }
    });
});

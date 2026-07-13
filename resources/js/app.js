import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

window.Alpine = Alpine;

Alpine.start();

// Fade Up Animation on Scroll
document.addEventListener('DOMContentLoaded', () => {

    const animateElements = document.querySelectorAll('.animate');

    if (animateElements.length === 0) return;

    const observerOptions = {
        root: null,
        rootMargin: '-150px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    animateElements.forEach(element => {
        observer.observe(element);
    });

    // Initialize Featured Edit Swiper
    const featuredSwiper = document.querySelector('.featured-swiper');
    if (featuredSwiper) {
        new Swiper('.featured-swiper', {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next-featured',
                prevEl: '.swiper-button-prev-featured',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }

    // Initialize Brands Swiper
    const brandsSwiper = document.querySelector('.brands-swiper');
    if (brandsSwiper) {
        new Swiper('.brands-swiper', {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next-brands',
                prevEl: '.swiper-button-prev-brands',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }

});

import Alpine from 'alpinejs';

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

});

import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

window.Alpine = Alpine;

// Alpine.js components
window.productAvailabilityCalendar = function(availabilityData = {}) {
    return {
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        availability: availabilityData,

        get monthYear() {
            const date = new Date(this.currentYear, this.currentMonth);
            return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        },

        get calendarDays() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);

            let firstDayOfWeek = firstDay.getDay();
            firstDayOfWeek = firstDayOfWeek === 0 ? 7 : firstDayOfWeek;

            const days = [];

            for (let i = firstDayOfWeek - 1; i > 0; i--) {
                days.push({
                    day: prevLastDay.getDate() - i + 1,
                    date: null,
                    isCurrentMonth: false,
                    status: null
                });
            }

            for (let i = 1; i <= lastDay.getDate(); i++) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                days.push({
                    day: i,
                    date: dateStr,
                    isCurrentMonth: true,
                    status: this.availability[dateStr] || 'available'
                });
            }

            const remainingDays = 35 - days.length;
            for (let i = 1; i <= remainingDays; i++) {
                days.push({
                    day: i,
                    date: null,
                    isCurrentMonth: false,
                    status: null
                });
            }

            return days;
        },

        previousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },

        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        }
    };
};

window.availabilityCalendar = function(availabilityData = {}) {
    return {
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        availability: availabilityData,

        get monthYear() {
            const date = new Date(this.currentYear, this.currentMonth);
            return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        },

        get calendarDays() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);

            const firstDayOfWeek = firstDay.getDay() === 0 ? 7 : firstDay.getDay();
            const days = [];

            for (let i = firstDayOfWeek - 1; i > 0; i--) {
                days.push({
                    day: prevLastDay.getDate() - i + 1,
                    date: null,
                    isCurrentMonth: false,
                    status: null
                });
            }

            for (let i = 1; i <= lastDay.getDate(); i++) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                days.push({
                    day: i,
                    date: dateStr,
                    isCurrentMonth: true,
                    status: this.availability[dateStr] || 'available'
                });
            }

            const remainingDays = 35 - days.length;
            for (let i = 1; i <= remainingDays; i++) {
                days.push({
                    day: i,
                    date: null,
                    isCurrentMonth: false,
                    status: null
                });
            }

            return days;
        },

        toggleDate(dateStr) {
            if (!dateStr) return;

            const current = this.availability[dateStr] || 'available';
            const statuses = ['available', 'unavailable', 'confirm'];
            const nextIndex = (statuses.indexOf(current) + 1) % statuses.length;
            this.availability[dateStr] = statuses[nextIndex];
        },

        previousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },

        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        }
    };
};

window.colourSelector = function(colours, selected = []) {
    return {
        colours: colours,
        selectedColours: selected.map(id => parseInt(id)),
        open: false,
        search: '',

        get filteredColours() {
            if (!this.search) return this.colours;
            const searchLower = this.search.toLowerCase();
            return this.colours.filter(colour =>
                colour.name.toLowerCase().includes(searchLower)
            );
        },

        getColourName(id) {
            const colour = this.colours.find(c => c.id === parseInt(id));
            return colour ? colour.name : '';
        },

        removeColour(id) {
            const index = this.selectedColours.indexOf(parseInt(id));
            if (index > -1) {
                this.selectedColours.splice(index, 1);
            }
        }
    };
};

// Favorites functionality
window.migrateFavoritesFormat = function() {
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

    if (favorites.length > 0 && typeof favorites[0] === 'number') {
        favorites = favorites.map(id => ({
            id: id,
            addedAt: Date.now()
        }));
        localStorage.setItem('favorites', JSON.stringify(favorites));
    }

    return favorites;
};

window.syncFavoritesWithUrl = function(routeUrl) {
    const favorites = window.migrateFavoritesFormat();
    const urlParams = new URLSearchParams(window.location.search);
    const urlIds = urlParams.getAll('ids[]').map(id => parseInt(id));
    const favoriteIds = favorites.map(f => f.id);

    const idsMatch = favoriteIds.length === urlIds.length &&
                     favoriteIds.every(id => urlIds.includes(id)) &&
                     urlIds.every(id => favoriteIds.includes(id));

    if (!idsMatch) {
        if (favoriteIds.length > 0) {
            const params = new URLSearchParams();
            favoriteIds.forEach(id => params.append('ids[]', id));
            window.location.replace(`${routeUrl}?${params.toString()}`);
        } else {
            window.location.replace(routeUrl);
        }
    }
};

window.favoritesPageData = function() {
    return {
        favorites: JSON.parse(localStorage.getItem('favorites') || '[]'),
        get favoriteCount() {
            return this.favorites.length;
        },
        updateCount() {
            this.favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        },
        getAddedAtForProduct(productId) {
            const favorite = this.favorites.find(f => f.id === productId);
            return favorite ? favorite.addedAt : null;
        }
    };
};

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

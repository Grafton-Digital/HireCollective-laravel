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
        activeDate: null,

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

        openDropdown(dateStr) {
            this.activeDate = this.activeDate === dateStr ? null : dateStr;
        },

        setStatus(dateStr, status) {
            this.availability[dateStr] = status;
            this.activeDate = null;
        },

        previousMonth() {
            this.activeDate = null;
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },

        nextMonth() {
            this.activeDate = null;
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
        selectedColours: selected.map(id => String(id)),
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
            const colour = this.colours.find(c => String(c.id) === String(id));
            return colour ? colour.name : '';
        },

        removeColour(id) {
            this.selectedColours = this.selectedColours.filter(c => String(c) !== String(id));
        }
    };
};

window.occasionSelector = function(occasions, selected = []) {
    return {
        occasions: occasions,
        selectedOccasions: selected.map(id => String(id)),
        open: false,
        search: '',

        get filteredOccasions() {
            if (!this.search) return this.occasions;
            const searchLower = this.search.toLowerCase();
            return this.occasions.filter(occasion =>
                occasion.name.toLowerCase().includes(searchLower)
            );
        },

        getOccasionName(id) {
            const occasion = this.occasions.find(o => String(o.id) === String(id));
            return occasion ? occasion.name : '';
        },

        removeOccasion(id) {
            this.selectedOccasions = this.selectedOccasions.filter(o => String(o) !== String(id));
        }
    };
};

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

window.bookingForm = function(productId) {
    return {
        loading: false,
        submitted: false,
        errors: {},
        form: {
            product_id: productId,
            product_variant_id: '',
            customer_name: '',
            customer_email: '',
            customer_phone: '',
            desired_dates: '',
            message: '',
        },

        async submitForm() {
            this.loading = true;
            this.errors = {};

            try {
                const response = await fetch('/enquiry', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });

                if (response.ok) {
                    this.submitted = true;
                } else if (response.status === 422) {
                    const data = await response.json();
                    const fieldErrors = data.errors || {};
                    for (const [key, messages] of Object.entries(fieldErrors)) {
                        this.errors[key] = messages[0];
                    }
                }
            } catch (e) {
                this.errors.message = 'Something went wrong. Please try again.';
            }

            this.loading = false;
        },

        resetForm() {
            this.submitted = false;
            this.errors = {};
            this.form.product_variant_id = '';
            this.form.customer_name = '';
            this.form.customer_email = '';
            this.form.customer_phone = '';
            this.form.desired_dates = '';
            this.form.message = '';
        }
    };
};

window.collaborationForm = function() {
    return {
        loading: false,
        submitted: false,
        errors: {},
        form: {
            name: '',
            company: '',
            email: '',
            message: '',
        },

        async submitForm() {
            this.loading = true;
            this.errors = {};

            try {
                const response = await fetch('/collaboration', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });

                if (response.ok) {
                    this.submitted = true;
                } else if (response.status === 422) {
                    const data = await response.json();
                    const fieldErrors = data.errors || {};
                    for (const [key, messages] of Object.entries(fieldErrors)) {
                        this.errors[key] = messages[0];
                    }
                }
            } catch (e) {
                this.errors.message = 'Something went wrong. Please try again.';
            }

            this.loading = false;
        },

        resetForm() {
            this.submitted = false;
            this.errors = {};
            this.form.name = '';
            this.form.company = '';
            this.form.email = '';
            this.form.message = '';
        }
    };
};

Alpine.data('productAvailabilityCalendar', window.productAvailabilityCalendar);
Alpine.data('availabilityCalendar', window.availabilityCalendar);
Alpine.data('colourSelector', window.colourSelector);
Alpine.data('occasionSelector', window.occasionSelector);
Alpine.data('bookingForm', window.bookingForm);
Alpine.data('collaborationForm', window.collaborationForm);
Alpine.data('favoritesPageData', window.favoritesPageData);

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

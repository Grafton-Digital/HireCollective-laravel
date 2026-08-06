import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'trix';
import 'trix/dist/trix.css';

window.Alpine = Alpine;

// Alpine.js components
window.productAvailabilityCalendar = function(availabilityData = {}) {
    const MIN_DAYS = 4;

    function addDays(dateStr, n) {
        const d = new Date(dateStr);
        d.setDate(d.getDate() + n);
        return d.toISOString().split('T')[0];
    }

    return {
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        availability: availabilityData,
        startDate: null,
        endDate: null,
        hoveredDate: null,
        errorMessage: null,

        get monthYear() {
            const date = new Date(this.currentYear, this.currentMonth);
            return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        },

        get minEndDate() {
            if (!this.startDate) return null;
            return addDays(this.startDate, MIN_DAYS - 1);
        },

        getStatus(dateStr) {
            return this.availability[dateStr] || 'available';
        },

        hasUnavailableBetween(from, to) {
            let d = addDays(from, 1);
            while (d <= to) {
                if (this.getStatus(d) === 'unavailable') return true;
                d = addDays(d, 1);
            }
            return false;
        },

        get selectionLabel() {
            if (!this.startDate) return '';
            if (!this.endDate) return `From: ${this.formatDate(this.startDate)} — select end date`;
            return `${this.formatDate(this.startDate)} — ${this.formatDate(this.endDate)}`;
        },

        formatDate(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
        },

        showError(msg) {
            this.errorMessage = msg;
            setTimeout(() => { this.errorMessage = null; }, 4000);
        },

        canStartFrom(dateStr) {
            for (let i = 0; i < MIN_DAYS; i++) {
                const d = addDays(dateStr, i);
                if (this.getStatus(d) === 'unavailable') return false;
            }
            return true;
        },

        selectDay(day) {
            if (!day.isCurrentMonth || !day.date) return;
            if (day.status === 'unavailable') return;
            this.errorMessage = null;

            if (!this.startDate || this.endDate) {
                if (!this.canStartFrom(day.date)) {
                    this.showError(`Minimum booking is ${MIN_DAYS} days. There are unavailable dates too close to the selected start date.`);
                    return;
                }
                this.startDate = day.date;
                this.endDate = null;
            } else {
                if (day.date < this.startDate) {
                    if (!this.canStartFrom(day.date)) {
                        this.showError(`Minimum booking is ${MIN_DAYS} days. There are unavailable dates too close to the selected start date.`);
                        return;
                    }
                    this.startDate = day.date;
                    this.endDate = null;
                } else if (day.date < this.minEndDate) {
                    this.showError(`Minimum booking is ${MIN_DAYS} days.`);
                } else if (this.hasUnavailableBetween(this.startDate, day.date)) {
                    this.showError('Selected range contains unavailable dates. Please choose dates within an available period.');
                } else {
                    this.endDate = day.date;
                }
            }
        },

        clearSelection() {
            this.startDate = null;
            this.endDate = null;
            this.errorMessage = null;
        },

        hoverDay(day) {
            if (!day.isCurrentMonth || !day.date) return;
            if (this.startDate && !this.endDate) {
                this.hoveredDate = day.date;
            }
        },

        hoverLeave() {
            this.hoveredDate = null;
        },

        getDayState(day) {
            if (!day.isCurrentMonth || !day.date) return '';
            if (day.date === this.startDate) return 'selected-start';
            if (day.date === this.endDate) return 'selected-end';
            if (this.startDate && !this.endDate && day.date > this.startDate && day.date < this.minEndDate) return 'disabled-range';
            if (this.startDate && this.endDate && day.date > this.startDate && day.date < this.endDate) return 'in-range';
            if (this.startDate && !this.endDate && this.hoveredDate && day.date > this.startDate && day.date <= this.hoveredDate && day.date >= this.minEndDate && !this.hasUnavailableBetween(this.startDate, this.hoveredDate)) return 'hover-range';
            return '';
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
    const MIN_DAYS = 4;

    return {
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        availability: availabilityData,
        activeDate: null,
        startDate: null,
        endDate: null,
        hoveredDate: null,
        showStatusPicker: false,

        get monthYear() {
            const date = new Date(this.currentYear, this.currentMonth);
            return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        },

        get minEndDate() {
            if (!this.startDate) return null;
            const d = new Date(this.startDate);
            d.setDate(d.getDate() + MIN_DAYS - 1);
            return d.toISOString().split('T')[0];
        },

        get rangeLabel() {
            if (!this.startDate) return '';
            if (!this.endDate) return `From: ${this.formatDate(this.startDate)} — select end date (min. ${MIN_DAYS} days)`;
            return `${this.formatDate(this.startDate)} — ${this.formatDate(this.endDate)}`;
        },

        formatDate(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
        },

        selectDay(dateStr) {
            if (!dateStr) return;

            if (!this.startDate || (this.startDate && this.endDate)) {
                this.startDate = dateStr;
                this.endDate = null;
                this.showStatusPicker = false;
            } else {
                if (dateStr < this.startDate) {
                    this.startDate = dateStr;
                    this.endDate = null;
                    this.showStatusPicker = false;
                } else if (dateStr < this.minEndDate) {
                    return;
                } else {
                    this.endDate = dateStr;
                    this.showStatusPicker = true;
                }
            }
        },

        hoverDay(dateStr) {
            if (this.startDate && !this.endDate) {
                this.hoveredDate = dateStr;
            }
        },

        hoverLeave() {
            this.hoveredDate = null;
        },

        applyStatus(status) {
            if (!this.startDate || !this.endDate) return;
            const start = new Date(this.startDate);
            const end = new Date(this.endDate);
            const updated = { ...this.availability };
            for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
                const dateStr = d.toISOString().split('T')[0];
                updated[dateStr] = status;
            }
            this.availability = updated;
            this.startDate = null;
            this.endDate = null;
            this.hoveredDate = null;
            this.showStatusPicker = false;
        },

        clearSelection() {
            this.startDate = null;
            this.endDate = null;
            this.hoveredDate = null;
            this.showStatusPicker = false;
        },

        getDayRangeState(dateStr) {
            if (!dateStr) return '';
            if (dateStr === this.startDate) return 'selected-start';
            if (dateStr === this.endDate) return 'selected-end';
            if (this.startDate && !this.endDate && dateStr > this.startDate && dateStr < this.minEndDate) return 'disabled-range';
            if (this.startDate && this.endDate && dateStr > this.startDate && dateStr < this.endDate) return 'in-range';
            if (this.startDate && !this.endDate && this.hoveredDate && this.hoveredDate >= this.minEndDate && dateStr > this.startDate && dateStr <= this.hoveredDate) return 'hover-range';
            return '';
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
            this.availability = { ...this.availability, [dateStr]: status };
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
        selectedStart: null,
        selectedEnd: null,
        form: {
            product_id: productId,
            product_variant_id: '',
            customer_name: '',
            customer_email: '',
            customer_phone: '',
            desired_dates: '',
            message: '',
        },

        formatDisplayDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
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

window.bookTestForm = function(productId) {
    return {
        loading: false,
        submitted: false,
        errors: {},
        form: {
            product_id: productId,
            customer_name: '',
            customer_email: '',
            customer_phone: '',
        },

        async submitForm() {
            this.loading = true;
            this.errors = {};

            try {
                const response = await fetch('/book-test', {
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
                this.errors.customer_email = 'Something went wrong. Please try again.';
            }

            this.loading = false;
        },

        resetForm() {
            this.submitted = false;
            this.errors = {};
            this.form.customer_name = '';
            this.form.customer_email = '';
            this.form.customer_phone = '';
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
Alpine.data('bookTestForm', window.bookTestForm);
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

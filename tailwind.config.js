import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
                serif: ['Cormorant Garamond', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                cream: {
                    50: '#F9F7F6',
                    100: '#F5EDE3',
                    200: '#F1ECE6',
                },
                gold: {
                    DEFAULT: '#C4975A',
                },
            },
            fontSize: {
                '2xs': ['10px', '14px'],
            },
        },
    },

    plugins: [forms],
};

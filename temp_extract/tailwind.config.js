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
                sans: ['Vazirmatn', ...defaultTheme.fontFamily.sans],
                num: ['Inter', 'Vazirmatn', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    red: '#C0392B',
                    'red-dark': '#A93226',
                    orange: '#E67E22',
                    'orange-dark': '#CA6F1E',
                    charcoal: '#1A1A1A',
                    'charcoal-light': '#2C2C2C',
                    offwhite: '#F5F5F5',
                },
            },
        },
    },

    plugins: [forms],
};

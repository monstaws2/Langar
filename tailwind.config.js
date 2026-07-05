/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                'brand-red': '#C0392B',
                'brand-red-dark': '#A93226',
                'brand-charcoal': '#1A1A1A',
                'brand-charcoal-light': '#2D2D2D',
                'brand-offwhite': '#F8F7F5',
                'brand-orange': '#E67E22',
            },
            fontFamily: {
                sans: ['Vazirmatn', 'Inter', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
};

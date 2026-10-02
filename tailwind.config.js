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
            colors: {
                brand: {
                    green: '#155d36',
                    'green-dark': '#0f4628',
                    'green-light': '#1b7444',
                    bg: '#faf7f0',
                    'bg-alt': '#f6f3eb',
                    card: '#ffffff',
                    blue: '#4d88df',
                    'blue-light': '#ebf3fe',
                    coral: '#eb5757',
                    'coral-light': '#fdefef',
                    gold: '#f2c94c',
                    'gold-light': '#fef9e7',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};

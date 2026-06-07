import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                japanese: ['"Noto Sans JP"', 'Inter', 'sans-serif'],
            },
            colors: {
                niholo: {
                    indigo: '#4f46e5',
                    pink: '#ec4899',
                    dark: '#0f172a',
                },
                pastel: {
                    blue: '#ADE6FF',
                    green: '#B6FABF',
                    yellow: '#FFFEC7',
                    orange: '#FAE9B8',
                    pink: '#FFCCC1',
                }
            },
        },
    },

    plugins: [
        forms,
        function ({ addUtilities }) {
            addUtilities({
                '.preserve-3d': {
                    'transform-style': 'preserve-3d',
                },
                '.backface-hidden': {
                    'backface-visibility': 'hidden',
                },
                '.rotate-y-180': {
                    transform: 'rotateY(180deg)',
                },
            });
        }
    ],
};

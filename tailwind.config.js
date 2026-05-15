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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    yellow:  '#FACC15',
                    'yellow-light': '#FDE047',
                    'yellow-dark':  '#EAB308',
                    dark:    '#111827',
                    darker:  '#0D1117',
                    card:    '#1F2937',
                    surface: '#F9FAFB',
                },
            },
            boxShadow: {
                'glow-yellow': '0 0 24px 0 rgba(250,204,21,0.25)',
                'glow-sm':     '0 0 12px 0 rgba(250,204,21,0.15)',
                'card':        '0 2px 8px 0 rgba(0,0,0,0.06), 0 0 0 1px rgba(0,0,0,0.04)',
                'card-hover':  '0 8px 32px 0 rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.04)',
                'premium':     '0 20px 60px -12px rgba(0,0,0,0.25)',
                'float':       '0 4px 24px 0 rgba(0,0,0,0.18)',
            },
            backdropBlur: {
                xs: '2px',
            },
            animation: {
                'fade-up':       'fadeUp 0.5s ease both',
                'fade-in':       'fadeIn 0.3s ease both',
                'slide-down':    'slideDown 0.2s ease both',
                'pulse-yellow':  'pulseYellow 2s ease-in-out infinite',
                'shimmer':       'shimmer 1.6s linear infinite',
            },
            keyframes: {
                fadeUp: {
                    '0%':   { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideDown: {
                    '0%':   { opacity: '0', transform: 'translateY(-8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                pulseYellow: {
                    '0%, 100%': { boxShadow: '0 0 0 0 rgba(250,204,21,0)' },
                    '50%':      { boxShadow: '0 0 0 8px rgba(250,204,21,0.15)' },
                },
                shimmer: {
                    '0%':   { backgroundPosition: '-400px 0' },
                    '100%': { backgroundPosition: '400px 0' },
                },
            },
            transitionTimingFunction: {
                'bounce-out': 'cubic-bezier(0.34, 1.56, 0.64, 1)',
            },
        },
    },

    plugins: [forms],
};

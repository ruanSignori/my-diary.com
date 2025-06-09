import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typografy from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
              bg: {
                DEFAULT: 'var(--color-bg)',
                light: 'var(--color-bg-light)',
                dark: 'var(--color-bg-dark)',
                lighter: 'var(--color-bg-lighter)',
                darker: 'var(--color-bg-darker)',
                desaturated: 'var(--color-bg-desaturated)',
                muted: 'var(--color-bg-muted)',
              },
              text: 'var(--color-text)',
              primary: {
                DEFAULT: 'var(--color-primary)',
                light: 'var(--color-primary-light)',
                dark: 'var(--color-primary-dark)',
                darker: 'var(--color-primary-darker)',
                lighter: 'var(--color-primary-lighter)',
                lightest: 'var(--color-primary-lightest)',
                desaturated: 'var(--color-primary-desaturated)',
              },
              secondary: 'var(--color-secondary)',
              accent: 'var(--color-accent)',
              component: 'var(--color-component-bg)',
              border: 'var(--color-border)',
            }
        },
    },

    plugins: [forms,  typografy,],
};

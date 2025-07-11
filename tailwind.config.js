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
        primary: 'var(--main-color)', // Menggunakan variabel CSS untuk warna tema
      },
      fontFamily: {
        // Menggunakan font 'Instrument Sans' seperti di file asli
        sans: ['"Instrument Sans"', 'sans-serif'],
      }
    },
  },

    plugins: [forms],
};

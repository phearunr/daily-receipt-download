const defaultTheme = require('tailwindcss/defaultTheme');
function px(pixels) {
    return `${pixels / 16}rem`;
}
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        fontSize: {
            xs: px(12),
            sm: px(14),
            base: px(15),
            lg: px(18),
            xl: px(20),
            "2xl": px(24),
            "3xl": px(30),
            "4xl": px(36),
            "5xl": px(48),
            "6xl": px(64),
        },
        extend: {
            screens: {
                xs: "480px",
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};

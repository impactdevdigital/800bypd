/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                ink: '#312E81', inkdeep: '#1E1B4B', grape: '#7C3AED', sun: '#FACC15',
                cream: '#FFFDF9', lilac: '#F4F1FF', peach: '#FFF5E6', blush: '#FFF0F5', mint: '#ECFDF5',
            },
            fontFamily: { fun: ['Fredoka', 'sans-serif'] },
            boxShadow: {
                soft: '0 1px 2px rgba(49,46,129,.04), 0 8px 24px -12px rgba(49,46,129,.18)',
                lift: '0 24px 48px -24px rgba(49,46,129,.35)',
            },
        },
    },
    plugins: [],
};

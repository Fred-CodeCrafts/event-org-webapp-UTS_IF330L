/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/*/*.php',
    './public/*/*/*.php',
    './public/*/*/*/*.php',
    './src/*.css'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('daisyui'),
    require('flowbite/plugin'),
    // plugin(function({ addBase, theme }) {
    //   addBase({
    //     'h1': { fontSize: theme('fontSize.2xl') },
    //     'h2': { fontSize: theme('fontSize.xl') },
    //     'h3': { fontSize: theme('fontSize.lg') },
    //   })
    // })
  ],
}


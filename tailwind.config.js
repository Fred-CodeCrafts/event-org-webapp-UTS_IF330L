/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/*/*.php',
    './src/*.css'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('daisyui'),
    require('flowbite/plugin')
  ],
}


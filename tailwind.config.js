const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
    './source/**/*.php',
    './source/**/*.html',
    './source/**/*.md',
  ],
  theme: {
    extend: {
      typography: theme => ({
        DEFAULT: {
          css: {
            'h1, h2, h3, h4, h5, h6': {
              fontFamily: theme('fontFamily.sans').join(', '),
            },
            'a:hover': {
              color: theme('colors.gray.900'),
              backgroundColor: theme('colors.peach.100'),
            },
          },
        },
      }),
      colors: {
        peach: {
          50: '#fffdfd',
          100: '#fef6f5',
          200: '#feebe9',
          300: '#fddad7',
          400: '#fbbcb6',
          500: '#f7897f',
          600: '#f34131',
          700: '#c41b0c',
          800: '#851208',
          900: '#370803'
        }
      },
      fontFamily: {
        display: ['Rubik', ...defaultTheme.fontFamily.sans],
        sans: ['Rubik', ...defaultTheme.fontFamily.sans],
        serif: ['Georgia', ...defaultTheme.fontFamily.serif],
        mono: ['IBM\ Plex\ Mono', ...defaultTheme.fontFamily.mono],
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
}

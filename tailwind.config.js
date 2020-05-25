const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  purge: [
    './source/**/*.php',
    './source/**/*.html',
    './source/**/*.md',
    './source/_assets/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        gray: {
          50: '#f9fafb',
          100: '#f4f5f7',
          200: '#e5e7eb',
          300: '#d2d6dc',
          400: '#9fa6b2',
          500: '#6b7280',
          600: '#4b5563',
          700: '#374151',
          800: '#252f3f',
          900: '#161e2e',
        },
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        mono: ['IBM Plex Mono', ...defaultTheme.fontFamily.mono],
      },
    },
  },
  variants: {
    width: ['responsive', 'focus'],
    margin: ['responsive', 'first'],
  },
}

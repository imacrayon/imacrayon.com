const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
  content: require('fast-glob').sync([
    'source/**/*.{blade.php,md,html}',
    '!source/**/_tmp/*' // exclude temporary files
  ], { dot: true }),
  theme: {
    colors: {
      current: colors.current,
      transparent: colors.transparent,
      white: colors.white,
      black: colors.black,
      gray: colors.slate,
      gold: {
        50: '#F6EFD7',
        100: '#EEDFAF',
        200: '#E5CF87',
        300: '#DDBF5F',
        400: '#D4AF37',
        500: '#AA8C2C',
        600: '#7F6921',
        700: '#554616',
        800: '#2A230B'
      }
    },
    fontFamily: {
      sans: ['Inter', ...defaultTheme.fontFamily.sans],
      mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
    },
    extend: {
      typography: theme => ({
        DEFAULT: {
          css: {
            'h1, h2, h3, h4, h5, h6': {
              fontWeight: 500,
            },
            'a:hover': {
              color: theme('colors.gray.900'),
              backgroundColor: theme('colors.gold.100'),
            },
          },
        },
      }),
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

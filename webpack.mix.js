let mix = require('laravel-mix')
let build = require('./tasks/build.js')

mix.disableSuccessNotifications()
mix.setPublicPath('source/assets/build/')
mix.webpackConfig({
  plugins: [
    build.jigsaw,
    build.browserSync('imacrayon.test'),
    build.watch([
      'config.php',
      'source/**/*.md',
      'source/**/*.php',
      'source/_assets/**/*.css',
      'source/_assets/**/*.js',
    ]),
  ],
})

mix
  .js('source/_assets/js/main.js', 'js')
  .sourceMaps()
  .postCss('source/_assets/css/main.css', 'css/main.css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('postcss-nesting'),
  ])

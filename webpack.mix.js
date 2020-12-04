const mix = require('laravel-mix')
require('laravel-mix-jigsaw')

mix.disableSuccessNotifications()
mix.setPublicPath('source/assets/build')

mix.jigsaw({ watch: ['config.php', 'source/**/*.md', 'source/**/*.php', 'source/**/*.scss'] })
.postCss('source/_assets/css/main.css', 'css/main.css', [require('tailwindcss')])

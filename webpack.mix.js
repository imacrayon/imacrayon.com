let mix = require('laravel-mix')
let build = require('./tasks/build.js')
let tailwindcss = require('tailwindcss')
require('laravel-mix-purgecss')

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
            'source/**/*.scss',
        ]),
    ],
})

mix.js('source/_assets/js/main.js', 'js')
    .sourceMaps()
    .postCss('source/_assets/css/main.css', 'css/main.css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-nesting'),
    ])
    .purgeCss({
        extensions: ['html', 'md', 'js', 'php'],
        folders: ['source'],
        whitelistPatterns: [/language/, /hljs/],
    })

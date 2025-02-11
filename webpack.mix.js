const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').js('resources/js/site.js', 'public/js')
    // .sass('resources/sass/admin.sass', 'public/css')
    .sass('resources/sass/site.sass', 'public/css').sourceMaps()
    // .sass('resources/sass/adaptive.sass', 'public/css')
    // .sass('resources/sass/site-other.sass', 'public/css').sourceMaps()



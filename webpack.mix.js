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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    // .sourceMaps()
    .copyDirectory('resources/template', 'public/template')
    // .copy('resources/template/css', 'public/template/css')
    // .copy('resources/template/scss', 'public/template/scss')
    // .copy('resources/template/vendor', 'public/template/vendor')
    // .copy('resources/template/js', 'public/template/js')


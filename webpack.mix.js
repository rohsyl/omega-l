let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.js('resources/assets/js/public.js', 'public/js')
    .sass('resources/assets/sass/public.scss', 'public/css');

mix.scripts([
    'resources/assets/js/assets/moxie.min.js',
    'resources/assets/js/assets/plupload.full.min.js'
], 'public/js/bundle.js');

// copy all page-specific js files to the public folder
mix.copyDirectory('resources/assets/js/omega/admin', 'public/js/omega/admin');
mix.copyDirectory('resources/assets/img', 'public/images');



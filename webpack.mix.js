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

mix.js(
    [
         'resources/assets/js/app.js',
         'node_modules/moment/moment.js',
         'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
         'resources/assets/js/jquery.bootstrap.treeselect.js',
         'resources/assets/js/custom.js'
    ],
    'public/js/app.js'
  )
  .sass('resources/assets/sass/app.scss', 'public/css')
  .styles(
      [
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'
      ],
      'public/css/lib.css'
  );

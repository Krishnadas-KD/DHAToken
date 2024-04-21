const mix = require('laravel-mix');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 require('dotenv').config();


mix.js('resources/js/appReceive.js', 'public/js')
    .js('resources/js/appSend.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', []);
    
    if (!mix.inProduction()) {
        mix.sourceMaps(); // Enable source maps for easier debugging
    } else {
        mix.version(); // Versioning for production assets
    }

mix.options({
    hmrOptions:{
        host:'localhost',
        port:8080
    }
})
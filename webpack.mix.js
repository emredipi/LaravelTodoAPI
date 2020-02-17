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
let url = process.env.APP_URL.replace(/(^\w+:|^)\/\//, '');
mix.options({
    hmrOptions: {
        host: url,
        port: 8080
    }
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
mix.disableSuccessNotifications();
if(mix.inProduction()){
    mix.version();
}else{
    mix.sourceMaps();
}

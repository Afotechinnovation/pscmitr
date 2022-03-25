const mix = require('laravel-mix');
const path = require('path');

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

let source = 'app/Admin/Resources/es';

mix.webpackConfig({
    resolve: {
        alias: {
            Base: path.resolve(source, 'Base.js'),
            Component: path.resolve(source, 'Component.js'),
            Config: path.resolve(source, 'Config.js'),
            Plugin: path.resolve(source, 'Plugin.js'),
            Menubar: path.resolve(source, 'Section/Menubar.js'),
            GridMenu: path.resolve(source, 'Section/GridMenu.js'),
            Sidebar: path.resolve(source, 'Section/Sidebar.js'),
            PageAside: path.resolve(source, 'Section/PageAside.js'),
            Site: path.resolve(source, 'Site.js'),
            BaseApp: path.resolve(source, 'BaseApp.js')
        }
    }
});

mix.js('app/Admin/Resources/js/scripts.js', 'public/admin/js')
    .js('app/Admin/Resources/js/ckeditor.js', 'public/admin/js')
    .sass('app/Admin/Resources/scss/bootstrap.scss', 'public/admin/css')
    .sass('app/Admin/Resources/scss/bootstrap-extend.scss', 'public/admin/css')
    .sass('app/Admin/Resources/scss/site.scss', 'public/admin/css')
    .sourceMaps();


mix.copyDirectory('app/Admin/Resources/images', 'public/admin/images');

/*
mix.styles([
    'public/css/vendor/normalize.css',
    'public/css/vendor/videojs.css'
], 'public/css/vendor.css');*/

/*
mix.scripts([
    'public/js/admin.js',
    'public/js/dashboard.js'
], 'public/js/all.js');
    */

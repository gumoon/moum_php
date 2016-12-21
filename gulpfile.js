const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir((mix) => {

    mix.sass('app.scss')
       .webpack('app.js')
       .styles('home.css', 'public/css/home.css');

    //有更新时，文件名不一样，确保浏览器不会使用缓存
    mix.version(['css/app.css', 'js/app.js', 'css/home.css']);

    //同步更新改变
    mix.browserSync({
    	proxy: 'moum.dev'
    });

});


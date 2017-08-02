var elixir = require('laravel-elixir');
var theme = 'tvpp';

elixir.config.assetsPath = './';
elixir.config.publicPath = './';
elixir.config.sourcemaps = true;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Statamic theme. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass(theme + '.scss', 'css/' + theme + '.css')

    //mix.version('css/' + theme + '.css');

    // mix.scripts([
    //     'site/**.js',
    // ], './js/tvpp.js')

    mix.rollup('js/app/index.js','js/tvpp.js')

    .browserSync({
      proxy: 'tvpp'
    });
});

let mix = require('laravel-mix');
const  path = require('path');

function resolve (dir) {
    return path.join(__dirname, 'resources/js', dir)
}
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

mix.browserSync({
    proxy: process.env.APP_URL
});


mix.webpackConfig({
    resolve: {
        alias: {
            '@': resolve('.'),
        }
    },
    module: {
        rules: [
            {
                test: /\.pug$/,
                oneOf: [
                    {
                        resourceQuery: /^\?vue/,
                        use: ['pug-plain-loader']
                    },
                    {
                        use: ['raw-loader', 'pug-plain-loader']
                    }
                ]
            }
        ]
    }

});

mix.js('resources/js/app.js', 'public/js').version();

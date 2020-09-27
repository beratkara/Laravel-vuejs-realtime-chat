const path = require("path");
const mix = require("laravel-mix");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
//const LodashModuleReplacementPlugin = require("lodash-webpack-plugin");

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


let configWebPack = {
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@': __dirname + '/resources/js',
            '@services': '@/services/',
        },
    },
};

mix.options({
    hmrOptions: {
        host: '127.0.0.1',
        port: 8080
    },
});

configWebPack.output = {
    filename:'[name].js',
    chunkFilename: 'js/chunks/[name].js',
    publicPath: '/',
};

configWebPack.plugins = [
    new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: ['public/css/*','public/js/*']
    }),
    new CompressionPlugin({
        filename: "[path].gz[query]",
        algorithm: "gzip",
        test: /\.js$|\.css$|\.html$|\.svg$/,
        threshold: 1024,
        minRatio: 10
    })
];

mix.version();

mix.webpackConfig(configWebPack);

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css");

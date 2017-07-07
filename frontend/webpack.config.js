/**
 * Created by ZIMkaRU on 09.03.2016.
 */
'use strict';

const NODE_ENV = process.env.NODE_ENV;
const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const WebpackMd5Hash = require('webpack-md5-hash');
const ManifestPlugin = require('webpack-manifest-plugin');

//Доступна мультикомпиляция, кот. задается массивом:
// "module.exports = [{...}, {...}, {...}]"
module.exports = {
    // Контекст относительно которого будет идти поиск файлов
    context: path.resolve(__dirname, 'src'),

    // Точки входа
    entry: {
        // Явное указание, что ./public/js/common.js должен содержать код из
        // ./frontend/src/common.js и др. файлов при необходимости,
        // например так (задается массивом): "["./message", "./common"]",
        // но экспортируется последний, т.е. "./common"
        app: ['babel-polyfill', './app']
    },

    // Файл в кот. все компилится
    output: {
        // Обсалютный путь к директории сборки
        path: path.resolve(__dirname, "../web/public"),

        // Указывает как из инета получить наши файлы (важно при AMD)
        publicPath: NODE_ENV == "production" ? "/public/" : "http://localhost:9000/public/",

        // То куда все собирается, в [name] подставляется имена из entry
        filename: 'js/[name].js?' + (NODE_ENV == "development" ? '[hash]' : '[chunkhash:10]'),

        // Применяется ко фрагментам сборки при require.ensure()
        chunkFilename: 'js/[id].js?' + (NODE_ENV == "development" ? '[hash]' : '[chunkhash:10]'),

        // Глобальная переменная доступная вне webpack
        library: '[name]'
    },

    // Авто пересборка при изменении файлов
    //watch: NODE_ENV == "development",

    watchOptions: {
        aggregateTimeout: 100
    },

    // Source maps: в prod - source-map, в dev - eval или cheap-inline-module-source-map
    devtool: NODE_ENV == "production" ? null : "cheap-module-eval-source-map",

    // Хотим ловить сообщения об ошибках
    debug: NODE_ENV == "development",
    devServer: {
        contentBase: path.resolve(__dirname, "../web"),
        hot: true,
        host: "localhost",
        port: 9000,
        compress: true,
        historyApiFallback: true,
        stats: { colors: true },
        //clientLogLevel: "error",//Possible values are none, error, warning or info (default).
        overlay: {
            warnings: true,
            errors: true
        },
        headers: {
            "Access-Control-Allow-Origin": "*",
        },
        // proxy: [{
        //    path: /.*/,
        //    target: "http://landing/app_dev.php/"
        // }]
    },

    //Плигины
    plugins: [
        // При возникновении ошибки не генерит файлы
        new webpack.NoErrorsPlugin(),

        // Для установки переменных окружения
        new webpack.DefinePlugin({
            NODE_ENV: JSON.stringify(NODE_ENV),
            "process.browser": JSON.stringify(true)//todo
        }),

        // Объеденяет общий код в точках входа и помещает в файл с именем заданным в name
        // Можно использовать "new webpack.optimize.CommonsChunkPlugin" несколько раз с разными опциями
        new webpack.optimize.CommonsChunkPlugin({
            name: 'app',

            // Мин. кол-во повторяющихся чусочков
            minChunks: 2

            // Явное указание из каких модулей выносить общий код
            // chunks: ["index", "catalog"]
        }),

        // Для создания глобальной переменной нужному модулю,
        // кот. можно использовать в коде без require
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.$": "jquery",
            "window.jQuery": "jquery",
            Holder: 'holderjs',
        }),

        // В какой файл нужно собрать стили
        new ExtractTextPlugin("css/[name].css?[contenthash:10]", { allChunks: true, disable: NODE_ENV == "development"}),

        // Для задания контекста того какую часть модуля нужно require
        // new webpack.ContextReplacementPlugin(/node_modules\/moment\/locale/, /ru|en-gb/),

        // Для задания того какую часть модуля игнорировать при require
        // new webpack.IgnorePlugin(/node_modules\/moment\/locale/, /ru/),

        new WebpackMd5Hash(),
        new ManifestPlugin(),
        // new ChunkManifestPlugin({
        //     filename: "chunk-manifest.json",
        //     manifestVariable: "webpackManifest"
        // }),
        new webpack.optimize.OccurenceOrderPlugin(),
    ],

    // Поиск: модули вообще
    resolve: {
        //дополнительный каталог в кот. будут искатся модули
        root: path.resolve(__dirname, "vendor"),

        // Перенаправляем пути при require модулей
        alias: {
            //old: "old/dist/old",
            jquery: path.resolve(__dirname, "bower_components/jquery/dist/jquery")
        },

        // В каких директориях искать модуль если не указан путь
        modulesDirectories: ["node_modules", "bower_components"],

        // С какими расширениями следует искать модуль
        extensions: ["", ".js", ".scss"]
    },

    // Поиск: модули для лоадеров
    resolveLoader: {
        modulesDirectories: ["node_modules"],
        moduleTemplates: ["*-loader", "*"],
        extensions: ["", ".js"]
    },

    // Модули
    module: {

        // Загрузщики
        loaders: [
            {
                // Регулярное выражение для проверки расширения
                test: /\.js$/,

                // Рег. выр. для проверки имени файлов кот. НЕ включаем или путь
                exclude: /(node_modules|bower_components)/,

                // Рег. выр. для проверки имени файлов кот. включаем или путь
                //include: path.resolve(__dirname, "frontend"),

                // Название загрузщика
                loader: "babel"
            },
            {
                test   : /\.css$/,
                loader: ExtractTextPlugin.extract('style', 'css!autoprefixer!resolve-url?sourceMap', {publicPath: "../"})
            },
            {
                test   : /\.(scss|sass)$/,
                loader: ExtractTextPlugin.extract('style', 'css!autoprefixer!resolve-url?sourceMap!sass?sourceMap', {publicPath: "../"})
            },
            {
                test   : /\.less$/,
                loader: ExtractTextPlugin.extract('style', 'css!autoprefixer!less', {publicPath: "../"})
            },
            {
                test: /\.(png|jpg|jpeg|ico|gif)$/,
                exclude: /(node_modules|bower_components)/,
                loader: "file?name=images/[name].[ext]?[hash]!image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false"
            },
            {
                test: /\.(png|jpg|jpeg|ico|gif)$/,
                include: /(node_modules)/,
                loader: "file?context=node_modules/&name=images/[path][name].[ext]?[hash]!image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false"
            },
            {
                test: /\.(png|jpg|jpeg|ico|gif)$/,
                include: /(bower_components)/,
                loader: "file?context=bower_components/&name=images/[path][name].[ext]?[hash]!image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false"
            },
            {
                test: /\.jade$/,
                loader: 'jade',
                exclude: /(node_modules|bower_components)/
            },
            {
                test: /\.woff(\?v=\d+\.\d+\.\d+)?$/,
                loader: "url?limit=10000&mimetype=application/font-woff&name=fonts/[name].[ext]?[hash]"
            },
            {
                test: /\.woff2(\?v=\d+\.\d+\.\d+)?$/,
                loader: "url?limit=10000&mimetype=application/font-woff2&name=fonts/[name].[ext]?[hash]"
            },
            {
                test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/,
                loader: "url?limit=10000&mimetype=application/font-sfnt&name=fonts/[name].[ext]?[hash]"
            },
            {
                test: /\.eot(\?v=\d+\.\d+\.\d+)?$/,
                loader: "url?limit=10000&mimetype=application/vnd.ms-fontobject&name=fonts/[name].[ext]?[hash]"
            },
            {
                test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,
                loader: "url?limit=10000&mimetype=image/svg+xml&name=fonts/[name].[ext]?[hash]"
            },
            {
                test: /\.otf(\?v=\d+\.\d+\.\d+)?$/,
                loader: "url?limit=10000&mimetype=application/font-sfnt&name=fonts/[name].[ext]?[hash]"
            },
        ],

        // Указываем то, что не нужно разберать webpack-ом
        //noParse: wrapRegexp(/\/node_modules\/(jquary|...)/, 'noParse')
    },

    externals: {
        //Ключь jquery, "$" - глобальная переменная,
        //делает так, что если require(jquery) то кладет его в глобальную переменную "$",
        //необходимо при использовании CDN библиотек
        // jQuery: "jquery",
        // jquery: "$",
    }
};

// Плагин для минификации собранных файлов
if (NODE_ENV == "production") {
    module.exports.plugins.push(
        new webpack.optimize.UglifyJsPlugin({
            minimize: true,
            sourceMap: false,
            output: {
                comments: false
            },
            compress: {
                warnings: false,
                drop_console: true,
                unsafe: true
            },
            // include: [/allplugin\.js/, /allplugin\.css/],
        })
    );

    module.exports.plugins.push(
        new CleanWebpackPlugin(['public'], {
            root: path.resolve(__dirname, "../web"),
            verbose: true,
            dry: false,
            exclude: ['assets']
        })
    );
}
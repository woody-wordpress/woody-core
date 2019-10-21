const webpack = require('webpack');
const path = require('path');

const config = require('../lib/config');
const mode = require('../lib/mode');
const publicPath = config.browserSync.publicPath;

config.js.node_modules = path.resolve(config.core, config.js.node_modules);
config.js.src = path.resolve(
    config.core,
    config.js.src.replace('WP_SITE_KEY', mode.site_key)
);
config.js.dist = path.resolve(config.dist, config.js.dist);

// Create path
const MODULES = JSON.parse(JSON.stringify(config.js.modules));
MODULES.forEach(function(part, index, array) {
    array[index] = path.resolve(
        config.core,
        part.replace('WP_SITE_KEY', mode.site_key)
    );
});
MODULES.push(config.js.node_modules);
MODULES.push(config.js.src);

const webpackConfig = {
    mode: 'production',
    context: config.js.src,
    entry: config.js.entry,
    output: {
        path: config.js.dist,
        filename: '[name].js',
        publicPath
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: config.js.node_modules,
                loader: 'babel-loader',
                options: {
                    presets: [
                        [
                            config.js.node_modules + '/babel-preset-env',
                            {
                                modules: false
                            }
                        ]
                    ]
                }
            }
        ]
    },
    resolveLoader: {
        modules: [config.js.node_modules]
    },
    resolve: {
        modules: MODULES,
        extensions: ['.json', '.js']
    },
    plugins: []
};

// Added Externals libs
if (mode.env == 'dev') {
    webpackConfig.devtool = 'inline-source-map';
} else {
    webpackConfig.devtool = false;
}

// Added Externals libs
if (config.js.hasOwnProperty('externals')) {
    webpackConfig.externals = config.js.externals;
}

/**
 * Modify webpackConfig depends on mode
 */
if (mode.action == 'sync') {
    webpackConfig.entry.app.unshift(
        'webpack-hot-middleware/client?reload=true'
    );
    webpackConfig.plugins.push(new webpack.HotModuleReplacementPlugin());
} else {
    webpackConfig.plugins.push(new webpack.NoEmitOnErrorsPlugin());
}

module.exports = webpackConfig;

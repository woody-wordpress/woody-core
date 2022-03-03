/**
 * Build JS
 */
const gulp = require('gulp');

const webpack = require('webpack');
const del = require('del');
const path = require('path');

const config = require('../lib/config');

const webpackConfig = require('./webpack.config');
const Log = require('../lib/logger');
const mode = require('../lib/mode');

const entries = mode.light ? config.js.light_entry : config.js.entry;
gulp.task('js_clean', done => {
    let filesPaths = [];
    Object.values(entries).forEach(entry => {
        filesPaths.push(path.resolve(config.dist, config.js.dist, entry));
        filesPaths.push(path.resolve(config.dist, config.js.dist, entry.replace('.js', '-*.js')));
    });
    del.sync(filesPaths, {
        force: true
    });

    // Async signal
    done();
});

gulp.task('js_compile', done => {
    webpack(webpackConfig).run(webPackBuild(done));

    function webPackBuild(done) {
        return function (err, stats) {
            if (err) {
                new Log('Webpack', err).error();
                if (done) {
                    done();
                }
            } else {
                new Log(
                    'Webpack',
                    stats.toString({
                        assets: true,
                        chunks: false,
                        chunkModules: false,
                        colors: true,
                        hash: false,
                        timings: true,
                        version: false
                    })
                ).info();
                if (done) {
                    done();
                }
            }
        };
    }
});

// Main Task
gulp.task('js', gulp.series('js_clean', 'js_compile'));

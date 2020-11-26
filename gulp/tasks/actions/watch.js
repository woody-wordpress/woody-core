/**
 * WATCHER
 */
const gulp = require('gulp');

const watch = require('gulp-watch');
const path = require('path');
const del = require('del');

const config = require('../lib/config');
const mode = require('../lib/mode');

gulp.task('watch_clean', done => {
    del.sync(path.resolve(config.dist, 'rev-manifest.json'), {
        force: true
    });
    done();
});

gulp.task('watch_compile', done => {
    const folders = ['img', 'static', 'fonts', 'css', 'js'];
    console.log('WATCH EXCLUDE (all)', '!' + config.dist);
    folders.forEach(task => {
        // Watch modules
        if (config[task].hasOwnProperty('modules')) {
            config[task].modules.forEach(part => {
                if (
                    part.indexOf('web/app/themes') > 0 ||
                    part == 'web/app/themes'
                ) {
                    part = part.replace(
                        'web/app/themes',
                        'web/app/themes/woody-theme'
                    );
                }
                var src = path.resolve(
                    config.core,
                    part.replace('WP_SITE_KEY', mode.site_key),
                    '**/',
                    config[task].extensions
                );
                console.log('WATCH INCLUDE (' + task + ')', src);
                gulp.watch(
                    [src, '!' + config.dist],
                    { interval: 1000, usePolling: true },
                    gulp.series(task, 'size')
                );
            });

            var src = path.resolve(
                config.core,
                config[task].src.replace('WP_SITE_KEY', mode.site_key),
                '**/',
                config[task].extensions
            );
            console.log('WATCH INCLUDE (' + task + ')', src);
            gulp.watch(
                [src, '!' + config.dist],
                { interval: 1000, usePolling: true },
                gulp.series(task, 'size')
            );
        } else if (Array.isArray(config[task].src)) {
            config[task].src.forEach(function (part) {
                console.log('WATCH INCLUDE (' + task + ')', part);
                gulp.watch(
                    [part, '!' + config.dist],
                    { interval: 1000, usePolling: true },
                    gulp.series(task, 'size')
                );
            });
        } else {
            console.log('WATCH INCLUDE (' + task + ')', config[task].src);
            gulp.watch(
                [config[task].src, '!' + config.dist],
                { interval: 1000, usePolling: true },
                gulp.series(task, 'size')
            );
        }
    });
});

// Main Task
gulp.task('watch', gulp.series('watch_clean', 'watch_compile'));

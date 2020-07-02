/**
 * Build Addon
 */
const gulp = require('gulp');

const path = require('path');
const del = require('del');
const glob = require('glob');

const config = require('../lib/config');

gulp.task('addons_clean', done => {
    del.sync(path.resolve(config.dist, 'addons'), {
        force: true
    });

    // Async signal
    done();
});

gulp.task('addons_move', done => {
    config.addons.src.forEach(function (item) {
        glob(path.resolve(config.core, item) + "/*", function (er, dirs) {
            dirs.forEach(addon => {
                gulp
                    .src(addon + '/dist/**/*.*')
                    .pipe(gulp.dest(path.resolve(config.dist, 'addons/' + addon.split('/').pop())));
            });
        })
    });

    // Async signal
    done();
});

// Main Task
gulp.task('addons', gulp.series('addons_clean', 'addons_move'));

/**
 * Build Addon
 */
const gulp = require('gulp');
const path = require('path');
const del = require('del');
const glob = require('glob');
const fs = require('fs');

const config = require('../lib/config');
const mode = require('../lib/mode');

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

gulp.task('addons_symlink', done => {
    config.addons.src.forEach(function (item) {
        glob(path.resolve(config.core, item) + "/*", function (er, dirs) {
            dirs.forEach(addon => {
                var source = addon + '/dist/';
                var target = path.resolve(config.dist, 'addons/' + addon.split('/').pop()) + '/';

                try {
                    if (fs.existsSync(source)) {
                        // console.log(source, '>', target);
                        gulp
                            .src(source)
                            .pipe(gulp.symlink(target));
                    }
                } catch (err) {
                    // console.log('!', source, '>', target);
                }
            });
        })
    });

    // Async signal
    done();
});

// Main Task
if (mode.env == 'dev') {
    gulp.task('addons', gulp.series('addons_clean', 'addons_symlink'));
} else {
    gulp.task('addons', gulp.series('addons_clean', 'addons_move'));
}

gulp.task('addons_debug', gulp.series('addons_clean', 'addons_symlink'));

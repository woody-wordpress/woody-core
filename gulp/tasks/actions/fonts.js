/**
 * Build font assets
 */
const gulp = require('gulp');
// const {
//     reload
// } = require('browser-sync');
const path = require('path');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const gulpif = require('gulp-if');
const changed = require('gulp-changed');
const del = require('del');

const config = require('../lib/config');
const mode = require('../lib/mode');

// Create path
config.fonts.src.forEach(function(part, index, array) {
    array[index] = path.resolve(
        config.core,
        part.replace('WP_SITE_KEY', mode.site_key),
        '**/',
        config.fonts.extensions
    );
});

gulp.task('fonts_clean', done => {
    del.sync(path.resolve(config.dist, config.fonts.dist), {
        force: true
    });
    done();
});

gulp.task('fonts_compile', () => {
    return gulp
        .src(config.fonts.src)
        .pipe(
            gulpif(
                mode.action == 'watch',
                plumber({
                    errorHandler: notify.onError({
                        title: 'Error Fonts',
                        message: '<%= error.message %>',
                        sound: 'Frog'
                    })
                })
            )
        )
        .pipe(
            gulpif(
                mode.action != 'watch',
                plumber({
                    errorHandler: function(error) {
                        console.log('Error Fonts : ' + error.message);
                        process.exit(1);
                    }
                })
            )
        )
        .pipe(changed(path.resolve(config.dist, config.fonts.dist)))
        .pipe(gulp.dest(path.resolve(config.dist, config.fonts.dist)));
});

// Main Task
gulp.task('fonts', gulp.series('fonts_clean', 'fonts_compile'));

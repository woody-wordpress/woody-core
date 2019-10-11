/**
 * Build static assets: video, favicons ...
 */

const gulp = require('gulp');

const path = require('path');
const del = require('del');

const config = require('../lib/config');
const mode = require('../lib/mode');

// Create path
config.static.src.forEach(function(part, index, array) {
    array[index] = path.resolve(config.core, part.replace('WP_SITE_KEY', mode.site_key), '**/', config.static.extensions);
});

gulp.task('static_clean', (done) => {
    del.sync(path.resolve(config.dist, config.static.dist), {
        force: true
    });

    // Async signal
    done();
});

gulp.task('static_compile', () => {
    return gulp
        .src(config.static.src)
        .pipe(gulp.dest(path.resolve(config.dist, config.static.dist)));
});

// Main Task
gulp.task('static', gulp.series('static_clean', 'static_compile'));

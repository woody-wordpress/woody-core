/**
 * Revision
 */
const gulp = require('gulp');
const rev = require('gulp-rev');
const path = require('path');

const config = require('../lib/config');

gulp.task('rev', () => {
    return gulp
        .src([
            path.resolve(config.dist, '**/*.+(css|js|ico|png)'),
            '!' + path.resolve(config.dist, 'addons/**/*'),
            '!' + path.resolve(config.dist, 'fonts/**/*'),
            '!' + path.resolve(config.dist, 'img/**/*')
        ])
        .pipe(rev())
        .pipe(gulp.dest(config.dist)) // write rev'd assets to build dir
        .pipe(rev.manifest())
        .pipe(gulp.dest(config.dist)); // write manifest to build dir
});

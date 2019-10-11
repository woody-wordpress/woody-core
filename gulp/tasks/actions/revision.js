/**
 * Revision
 */
const gulp = require('gulp');
const rev = require('gulp-rev');
const path = require('path');

const config = require('../lib/config');

gulp.task('rev', () => {
    return gulp
        .src(path.resolve(config.dist, '**/*.+(css|js)'))
        .pipe(rev())
        .pipe(gulp.dest(config.dist)) // write rev'd assets to build dir
        .pipe(rev.manifest())
        .pipe(gulp.dest(config.dist)) // write manifest to build dir
});

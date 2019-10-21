/**
 * Size report
 */
const gulp = require('gulp');
const sizereport = require('gulp-sizereport');
const path = require('path');

const config = require('../lib/config');

gulp.task('size', () => {
    return gulp.src(path.resolve(config.dist, '**/*.+(css|js)')).pipe(
        sizereport({
            gzip: true
        })
    );
});

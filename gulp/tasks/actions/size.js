/**
 * Size report
 */
const gulp = require('gulp');
const sizereport = require('gulp-sizereport');
const path = require('path');

const config = require('../lib/config');

gulp.task('size', () => {
    return gulp.src([
        path.resolve(config.dist, '**/*.+(css|js)'),
        '!' + path.resolve(config.dist, 'addons/**/*'),
        '!' + path.resolve(config.dist, 'fonts/**/*'),
        '!' + path.resolve(config.dist, 'img/**/*')
    ]).pipe(
        sizereport({
            gzip: true
        })
    );
});

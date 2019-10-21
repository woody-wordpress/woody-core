const gulp = require('gulp');
const path = require('path');
const del = require('del');

const config = require('../lib/config');
const mode = require('../lib/mode');

var iconfont = require('gulp-iconfont');
var iconfontCss = require('gulp-iconfont-css');
var runTimestamp = Math.round(Date.now() / 1000);

// Create path
config.icons.src.forEach(function(part, index, array) {
    array[index] = path.resolve(
        config.core,
        part.replace('WP_SITE_KEY', mode.site_key),
        '**/',
        config.icons.extensions
    );
});

// Recreate dest / tpl
config.icons.dest = path.resolve(
    config.core,
    config.icons.dest.replace('WP_SITE_KEY', mode.site_key)
);
config.icons.tpl = path.resolve(
    config.core,
    config.icons.tpl.replace('WP_SITE_KEY', mode.site_key)
);

gulp.task('icons_clean', done => {
    del.sync([config.icons.dest], {
        force: true
    });
    done();
});

gulp.task('icons_compile', () => {
    return gulp
        .src(config.icons.src)
        .pipe(
            iconfontCss({
                fontName: config.icons.fontName,
                path: config.icons.tpl,
                targetPath: '_icons.scss',
                fontPath: '../fonts/woody-icons/',
                cacheBuster: runTimestamp,
                cssClass: 'wicon'
            })
        )
        .pipe(
            iconfont({
                fontName: config.icons.fontName,
                prependUnicode: true, // recommended option
                formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'], // default, 'woff2' and 'svg' are available
                timestamp: runTimestamp, // recommended to get consistent builds when watching files
                fontHeight: 1001,
                normalize: true
            })
        )
        .pipe(gulp.dest(config.icons.dest));
});

// Main Task
gulp.task('icons', gulp.series('icons_clean', 'icons_compile'));

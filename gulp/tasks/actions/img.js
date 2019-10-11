/**
 * Build image assets
 */
const gulp = require('gulp');
// const {
//     reload
// } = require('browser-sync');
const image = require('gulp-image');
const notify = require('gulp-notify');
const gulpif = require('gulp-if');
const path = require('path');
const plumber = require('gulp-plumber');
const changed = require('gulp-changed');

const config = require('../lib/config');
const mode = require('../lib/mode');

// Create path
config.img.src.forEach(function(part, index, array) {
    array[index] = path.resolve(config.core, part.replace('WP_SITE_KEY', mode.site_key), '**/', config.img.extensions);
});

gulp.task('img_optim', () => {
    return gulp
        .src(path.resolve(config.core, config.img.optim.replace('WP_SITE_KEY', mode.site_key), '**/', config.img.extensions))
        .pipe(gulpif(
            mode.action == 'watch',
            plumber({
                errorHandler: notify.onError({
                    title: 'Error Images',
                    message: "<%= error.message %>",
                    sound: "Frog"
                })
            })
        ))
        .pipe(gulpif(
            mode.action != 'watch',
            plumber({
                errorHandler: function(error) {
                    console.log('Error Images : ' + error.message);
                    process.exit(1);
                }
            })
        ))
        .pipe(changed(
            path.resolve(config.dist, config.img.dist), { hasChanged: changed.compareContents }
        ))
        .pipe(image({
            pngquant: true,
            optipng: false,
            zopflipng: true,
            jpegRecompress: false,
            mozjpeg: true,
            guetzli: false,
            gifsicle: true,
            svgo: true,
            concurrent: 10,
            quiet: false
        }))
        .pipe(gulp.dest(path.resolve(config.core, config.img.optim.replace('WP_SITE_KEY', mode.site_key))));
});

gulp.task('img_move', () => {
    return gulp
        .src(config.img.src)
        .pipe(changed(
            path.resolve(config.dist, config.img.dist), { hasChanged: changed.compareContents }
        ))
        .pipe(gulp.dest(path.resolve(config.dist, config.img.dist)));
});

// Main Task
if (mode.env == 'dev' && mode.action != 'watch') {
    gulp.task('img', gulp.series('img_optim', 'img_move'));
} else {
    gulp.task('img', gulp.series('img_move'));
}

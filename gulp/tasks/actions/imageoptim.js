/**
 * Build image assets
 */
const gulp = require('gulp');

const image = require('gulp-image');
const path = require('path');
const plumber = require('gulp-plumber');

const config = require('../lib/config');
const mode = require('../lib/mode');

config.imageoptim.entry.forEach(entry => {
    gulp.task(entry, () => {
        return gulp
            .src(path.resolve(config.core, entry.replace('WP_SITE_KEY', mode.site_key), '**/', config.imageoptim.extensions))
            .pipe(plumber({
                errorHandler: function(error) {
                    console.log('Error Images : ' + error.message);
                    //process.exit(1);
                }
            }))
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
            .pipe(gulp.dest(path.resolve(config.core, entry.replace('WP_SITE_KEY', mode.site_key))));
    });
});

// Main Task
gulp.task('imageoptim', gulp.parallel(config.imageoptim.entry));

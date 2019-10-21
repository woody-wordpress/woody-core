/**
 * Build image assets
 */
const gulp = require('gulp');

const image = require('gulp-image');
const path = require('path');
const plumber = require('gulp-plumber');

const config = require('../lib/config');
const mode = require('../lib/mode');

// Create path
config.medias.src.forEach(function(part, index, array) {
    array[index] = path.resolve(
        config.core,
        part.replace('WP_SITE_KEY', mode.site_key),
        '**/',
        config.medias.extensions
    );
});

gulp.task('medias', () => {
    return gulp
        .src(config.medias.src)
        .pipe(
            plumber({
                errorHandler: function(error) {
                    console.log('Error Images : ' + error.message);
                    //process.exit(1);
                }
            })
        )
        .pipe(
            image({
                pngquant: false,
                optipng: false,
                zopflipng: false,
                jpegRecompress: false,
                mozjpeg: true,
                guetzli: false,
                gifsicle: false,
                svgo: false,
                concurrent: 2,
                quiet: false
            })
        )
        .pipe(
            gulp.dest(
                path.resolve(
                    config.core,
                    config.medias.dist.replace('WP_SITE_KEY', mode.site_key)
                )
            )
        );
});

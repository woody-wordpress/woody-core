/**
 * Build favicon assets: video, favicon ...
 */

const gulp = require('gulp');
const path = require('path');

const flatMap = require('flat-map').default;
const scaleImages = require('gulp-scale-images');
const ico = require('gulp-to-ico');
const changed = require('gulp-changed');

const config = require('../lib/config');
const mode = require('../lib/mode');

// Create path
config.favicon.src.forEach(function (part, index, array) {
    array[index] = path.resolve(
        config.core,
        part.replace('WP_SITE_KEY', mode.site_key),
        config.favicon.extensions
    );
});

const iconsVariants = (file, done) => {
    const icon192 = file.clone();
    icon192.scale = { maxWidth: 192, maxHeight: 192, format: 'png' };

    const icon180 = file.clone();
    icon180.scale = { maxWidth: 180, maxHeight: 180, format: 'png' };

    const icon167 = file.clone();
    icon167.scale = { maxWidth: 167, maxHeight: 167, format: 'png' };

    const icon152 = file.clone();
    icon152.scale = { maxWidth: 152, maxHeight: 152, format: 'png' };

    const icon128 = file.clone();
    icon128.scale = { maxWidth: 128, maxHeight: 128, format: 'png' };

    const icon120 = file.clone();
    icon120.scale = { maxWidth: 120, maxHeight: 120, format: 'png' };

    const icon64 = file.clone();
    icon64.scale = { maxWidth: 64, maxHeight: 64, format: 'png' };

    const icon32 = file.clone();
    icon32.scale = { maxWidth: 32, maxHeight: 32, format: 'png' };

    const icon16 = file.clone();
    icon16.scale = { maxWidth: 16, maxHeight: 16, format: 'png' };

    done(null, [
        icon192,
        icon180,
        icon167,
        icon152,
        icon128,
        icon120,
        icon64,
        icon32,
        icon16
    ]);
};

gulp.task('icons_touch', () => {
    return gulp
        .src(config.favicon.src)
        .pipe(
            changed(path.resolve(config.dist, config.favicon.dist), {
                hasChanged: changed.compareContents
            })
        )
        .pipe(flatMap(iconsVariants))
        .pipe(scaleImages())
        .pipe(gulp.dest(path.resolve(config.dist, config.favicon.dist)));
});

gulp.task('icons_favicon', () => {
    return gulp
        .src(path.resolve(config.dist, config.favicon.dist) + '/*.png')
        .pipe(
            ico('favicon.ico', { resize: true, sizes: [16, 32, 64, 128, 192] })
        )
        .pipe(gulp.dest(path.resolve(config.dist, config.favicon.dist)));
});

// Main Task
gulp.task('favicon', gulp.series('icons_touch', 'icons_favicon'));

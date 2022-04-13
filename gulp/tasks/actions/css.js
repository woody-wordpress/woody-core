/**
 * Build CSS
 */
const gulp = require('gulp');
// const {
//     reload
// } = require('browser-sync');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const gulpif = require('gulp-if');
const path = require('path');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const del = require('del');

const config = require('../lib/config');
const mode = require('../lib/mode');

const entries = mode.light ? config.css.light_entry : config.css.entry;
// Create path
config.css.modules.forEach(function (part, index, array) {
    array[index] = path.resolve(
        config.core,
        part.replace('WP_SITE_KEY', mode.site_key)
    );
});

gulp.task('css_clean', done => {
    let filesPaths = [];

    if (mode.light) {
        entries.forEach(entry => {
            filesPaths.push(path.resolve(config.dist, config.css.dist, entry.replace('.scss', '.css')));
            filesPaths.push(path.resolve(config.dist, config.css.dist, entry.replace('.scss', '-*.css')));
        });
    } else {
        filesPaths.push(path.resolve(config.dist, config.css.dist));
    }

    del.sync(filesPaths, {
        force: true
    });

    // Async signal
    done();
});

entries.forEach(entry => {
    gulp.task(entry, () => {
        return gulp
            .src(
                path.resolve(
                    config.core,
                    config.css.src.replace('WP_SITE_KEY', mode.site_key),
                    entry
                )
            )
            .pipe(gulpif(mode.env == 'dev', sourcemaps.init()))
            .pipe(
                gulpif(
                    mode.env == 'dev',
                    plumber({
                        errorHandler: function (error) {
                            console.log('Error CSS : ' + error.message);
                        }
                    })
                )
            )
            .pipe(
                gulpif(
                    mode.env != 'dev',
                    plumber({
                        errorHandler: function (error) {
                            console.log('Error CSS : ' + error.message);
                            process.exit(1);
                        }
                    })
                )
            )
            .pipe(
                gulpif(
                    mode.env == 'dev',
                    sass({
                        includePaths: config.css.modules,
                        outputStyle: 'expanded',
                        sourceMap: true,
                        errLogToConsole: true
                    })
                )
            )
            .pipe(
                gulpif(
                    mode.env != 'dev',
                    sass({
                        includePaths: config.css.modules,
                        outputStyle: 'expanded',
                        sourceMap: false,
                        errLogToConsole: true
                    })
                )
            )
            .pipe(
                gulpif(
                    mode.env != 'dev',
                    autoprefixer({
                        overrideBrowserslist: ['last 2 versions and > 0.5%'],
                        cascade: false
                    })
                )
            )
            .pipe(
                gulpif(
                    mode.env != 'dev',
                    cleanCSS({
                        level: 2
                    })
                )
            )
            .pipe(gulpif(mode.env == 'dev', sourcemaps.write()))
            .pipe(gulp.dest(path.resolve(config.dist, config.css.dist)));
    });
});

// Main Task
gulp.task('css', gulp.series('css_clean', gulp.parallel(entries)));

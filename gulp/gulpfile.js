/**
 * @author: Léo POIROUX, Raccourci Agency
 */

const gulp = require('gulp');
const mode = require('./tasks/lib/mode');

require('./tasks/actions/css.js');
require('./tasks/actions/favicon.js');
require('./tasks/actions/fonts.js');
require('./tasks/actions/icons.js');
require('./tasks/actions/img.js');
require('./tasks/actions/js.js');
//require('./tasks/actions/livereload.js');
require('./tasks/actions/medias.js');
require('./tasks/actions/revision.js');
require('./tasks/actions/size.js');
require('./tasks/actions/static.js');
require('./tasks/actions/watch.js');
require('./tasks/actions/imageoptim.js');

if (mode.action == 'build') {
    gulp.task('default', gulp.series('icons', gulp.parallel('img', 'fonts', 'static', 'favicon'), gulp.parallel('css', 'js'), 'size', 'rev'));
} else if (mode.action == 'watch') {
    gulp.task('default', gulp.series('watch'));
} else if (mode.action == 'sync') {
    console.log('Command disable');
    //gulp.task('default', gulp.series('icons', gulp.parallel('img', 'fonts', 'static', 'favicon'), gulp.parallel('css'), 'watch', 'liveReload'));
} else if (mode.action == 'medias') {
    gulp.task('default', gulp.series('medias'));
} else {
    gulp.task('default', gulp.series(mode.action));
}

/**
 * Error, warning, info logger
 */
const path = require('path');
const mode = require('./mode');
const locutus = require('locutus');

var config = require(path.resolve(__dirname, '../../', 'gulp.config'));

// Set CONFIG global
config.core = path.resolve(__dirname, '../../../');
config.site = path.resolve(config.core, config.site.replace('WP_SITE_KEY', mode.site_key));
config.dist = path.resolve(config.core, config.dist.replace('WP_SITE_KEY', mode.site_key));

// Overide global conf by website conf
var override = require(path.resolve(config.site, 'gulp.config'));
config = locutus.php.array.array_replace_recursive(config, override);

// Set PublicPath
config.browserSync.publicPath = config.browserSync.publicPath.replace('WP_SITE_KEY', mode.site_key);
if (mode.action != 'build') config.browserSync.publicPath = 'http://localhost:' + config.browserSync.port + config.browserSync.publicPath;

module.exports = config;

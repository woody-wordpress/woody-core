<?php

/**
 * Your base production configuration goes in this file. Environment-specific
 * overrides go in their respective config/environments/{{WP_ENV}}.php file.
 *
 * A good default policy is to deviate from the production config as little as
 * possible. Try to define as much of your configuration in this file as you
 * can.
 */

use Roots\WPConfig\Config;

/**
 * Directory containing all of the site's files
 */
define('WP_ROOT_DIR', preg_replace('/releases\\/[0-9]*/', 'current', dirname(__DIR__)));
define('WP_WEBROOT_DIR', WP_ROOT_DIR . '/web');
define('WP_VENDOR_DIR', WP_ROOT_DIR . '/vendor');

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();
define('WP_SITE_KEY', env('WP_SITE_KEY'));

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
function array_env($env)
{
    $env = str_replace(array('[', ']', '"', ' '), '', env($env));
    $env = (!empty($env)) ? explode(',', $env) : [];
    return $env;
}

if (file_exists(WP_ROOT_DIR . '/config/sites/' . WP_SITE_KEY . '/.env')) {
    $dotenv = Dotenv\Dotenv::create(WP_ROOT_DIR . '/config/sites/' . WP_SITE_KEY);
    $dotenv->load();
    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST', 'WP_HOME', 'WP_ENV']);
}

if (file_exists(WP_ROOT_DIR . '/web/app/themes/' . WP_SITE_KEY . '/config/.env')) {
    $dotenv = Dotenv\Dotenv::create(WP_ROOT_DIR . '/web/app/themes/' . WP_SITE_KEY . '/config');
    $dotenv->overload();
}

/**
 * Set up our global environment constant and load its config first
 * Default: prod
 */
define('WP_ENV', env('WP_ENV') ?: 'prod');


if (file_exists(WP_ROOT_DIR . '/web/app/themes/' . WP_SITE_KEY . '/config/' . WP_ENV . '/.env')) {
    $dotenv = Dotenv\Dotenv::create(WP_ROOT_DIR . '/web/app/themes/' . WP_SITE_KEY . '/config/' . WP_ENV);
    $dotenv->overload();
}

/**
 * HTTPS
 */
Config::define('FORCE_SSL_ADMIN', env('FORCE_SSL_ADMIN') ?: false);
if (Config::get('FORCE_SSL_ADMIN')) {
    $scheme = 'https';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = $scheme;
    $_SERVER['HTTPS'] = 'on';
} else {
    $scheme = 'http';
    $_SERVER['HTTP_X_FORWARDED_PROTO'] = $scheme;
    $_SERVER['HTTPS'] = 'off';
}
Config::define('WP_SCHEME', $scheme);

/**
 * URLs
 */
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
}

if (!empty($_SERVER['HTTP_HOST'])) {
    Config::define('WP_HOME', $scheme . '://' . $_SERVER['HTTP_HOST']);
} else {
    Config::define('WP_HOME', env('WP_HOME'));
    $_SERVER['HTTP_HOST'] = parse_url(Config::get('WP_HOME'), PHP_URL_HOST);
}

if (empty($_SERVER['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];
}

if (empty($_SERVER['SERVER_PROTOCOL'])) {
    $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
}

Config::define('WP_SITEURL', Config::get('WP_HOME') . '/wp');

/**
 * Custom Content Directory
 */
Config::define('CONTENT_DIR', '/app');
Config::define('WP_CONTENT_DIR', WP_WEBROOT_DIR . Config::get('CONTENT_DIR'));
Config::define('WP_CONTENT_URL', Config::get('WP_HOME') . Config::get('CONTENT_DIR'));
Config::define('WP_UPLOAD_DIR', Config::get('WP_CONTENT_DIR') . '/uploads/' . WP_SITE_KEY);
Config::define('WP_UPLOAD_URL', Config::get('WP_CONTENT_URL') . '/uploads/' . WP_SITE_KEY);
Config::define('WP_DIST_DIR', Config::get('WP_CONTENT_DIR') . '/dist/' . WP_SITE_KEY);
Config::define('WP_DIST_URL', Config::get('WP_CONTENT_URL') . '/dist/' . WP_SITE_KEY);
Config::define('WP_PLUGINS_DIR', Config::get('WP_CONTENT_DIR') . '/plugins');
Config::define('WP_PLUGINS_URL', Config::get('WP_CONTENT_URL') . '/plugins');
Config::define('WP_CACHE_DIR', Config::get('WP_CONTENT_DIR') . '/cache');
Config::define('WP_TIMBER_DIR', Config::get('WP_CACHE_DIR') . '/timber');

/**
 * DB settings
 */
Config::define('DB_NAME', env('DB_NAME'));
Config::define('DB_USER', env('DB_USER'));
Config::define('DB_PASSWORD', env('DB_PASSWORD'));
Config::define('DB_HOST', env('DB_HOST') ?: 'localhost');
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

Config::define('MEMCACHED_HOST', array_env('MEMCACHED_HOST') ?: '');
Config::define('MEMCACHED_PORT', env('MEMCACHED_PORT') ?: '');

/**
 * Authentication Unique Keys and Salts
 */
Config::define('AUTH_KEY', env('AUTH_KEY') ?: '');
Config::define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY') ?: '');
Config::define('LOGGED_IN_KEY', env('LOGGED_IN_KEY') ?: '');
Config::define('NONCE_KEY', env('NONCE_KEY') ?: '');
Config::define('AUTH_SALT', env('AUTH_SALT') ?: '');
Config::define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT') ?: '');
Config::define('LOGGED_IN_SALT', env('LOGGED_IN_SALT') ?: '');
Config::define('NONCE_SALT', env('NONCE_SALT') ?: '');

/**
 * Raccourci WOODY settings
 */
Config::define('WOODY_TIMEZONE', env('WOODY_TIMEZONE') ?: 'Europe/Paris');
Config::define('WOODY_LATITUDE', env('WOODY_LATITUDE') ?: null);
Config::define('WOODY_LONGITUDE', env('WOODY_LONGITUDE') ?: null);
Config::define('WOODY_SSO_CLIENT_ID', env('WOODY_SSO_CLIENT_ID') ?: '');
Config::define('WOODY_IMAGE_WEBP_ENABLE', env('WOODY_IMAGE_WEBP_ENABLE') ?: false);
Config::define('WOODY_SSO_CLIENT_SECRET', env('WOODY_SSO_CLIENT_SECRET') ?: '');
Config::define('WOODY_SSO_SECRET_URL', env('WOODY_SSO_SECRET_URL') ?: '');
Config::define('WOODY_SSO_ADD_URL_TOKEN', env('WOODY_SSO_ADD_URL_TOKEN') ?: '');
Config::define('WOODY_VARNISH_CACHING_ENABLE', env('WOODY_VARNISH_CACHING_ENABLE') ?: false);
Config::define('WOODY_VARNISH_CACHING_DEBUG', env('WOODY_VARNISH_CACHING_DEBUG') ?: false);
Config::define('WOODY_VARNISH_CACHING_TTL', env('WOODY_VARNISH_CACHING_TTL') ?: 2592000);
Config::define('WOODY_VARNISH_CACHING_FOCUSRANDOM_TTL', env('WOODY_VARNISH_CACHING_FOCUSRANDOM_TTL') ?: 86400);
Config::define('WOODY_VARNISH_CACHING_FOCUSSHEET_TTL', env('WOODY_VARNISH_CACHING_FOCUSSHEET_TTL') ?: 7200);
Config::define('WOODY_VARNISH_CACHING_WEATHERPAGE_TTL', env('WOODY_VARNISH_CACHING_WEATHERPAGE_TTL') ?: 14400);
Config::define('WOODY_VARNISH_CACHING_LIVEPAGE_TTL', env('WOODY_VARNISH_CACHING_LIVEPAGE_TTL') ?: 900);
Config::define('WOODY_VARNISH_CACHING_IPS', env('WOODY_VARNISH_CACHING_IPS') ?: '');
Config::define('WOODY_VARNISH_CACHING_PURGE_KEY', env('WOODY_VARNISH_CACHING_PURGE_KEY') ?: '');
Config::define('WOODY_VARNISH_CACHING_COOKIE', env('WOODY_VARNISH_CACHING_COOKIE') ?: '');
Config::define('WOODY_ACF_PRO_KEY', env('WOODY_ACF_PRO_KEY') ?: '');
Config::define('WOODY_SENTRY', env('WOODY_SENTRY') ?: '');

Config::define('WOODY_GTM', env('WOODY_GTM') ?: '');
Config::define('WOODY_ACCESS_LOCKED', env('WOODY_ACCESS_LOCKED') ?: false);
Config::define('WOODY_ACCESS_STAGING', env('WOODY_ACCESS_STAGING') ?: false);
Config::define('WOODY_OPTIONS', array_env('WOODY_OPTIONS') ?: []);
Config::define('WOODY_API_LOGIN', env('WOODY_API_LOGIN') ?: '');
Config::define('WOODY_API_PASSWORD', env('WOODY_API_PASSWORD') ?: '');
Config::define('WOODY_TOURISTIC_MAPS_API_KEY', array_env('WOODY_TOURISTIC_MAPS_API_KEY') ?: []);
Config::define('WOODY_TOURISTIC_MAPS_API_KEY_PROD', array_env('WOODY_TOURISTIC_MAPS_API_KEY_PROD') ?: []);
Config::define('WOODY_IGN_MAPS_API_KEY', array_env('WOODY_IGN_MAPS_API_KEY') ?: []);
Config::define('WOODY_IGN_MAPS_API_KEY_PROD', array_env('WOODY_IGN_MAPS_API_KEY_PROD') ?: []);
Config::define('WOODY_GOOGLE_MAPS_API_KEY', array_env('WOODY_GOOGLE_MAPS_API_KEY') ?: []);
Config::define('WOODY_GOOGLE_MAPS_API_KEY_PROD', array_env('WOODY_GOOGLE_MAPS_API_KEY_PROD') ?: []);

/**
 * MailJet informations
 */
Config::define('WOODY_SMTP_USERNAME', env('WOODY_SMTP_USERNAME') ?: '');
Config::define('WOODY_SMTP_PASSWORD', env('WOODY_SMTP_PASSWORD') ?: '');
Config::define('WOODY_SMTP_SENDER', env('WOODY_SMTP_SENDER') ?: '');
Config::define('WOODY_SMTP_SENDER_NAME', env('WOODY_SMTP_SENDER_NAME') ?: '');

/**
 * Custom Settings
 */
Config::define('AUTOMATIC_UPDATER_DISABLED', true);
Config::define('ALLOW_UNFILTERED_UPLOADS', false);
Config::define('DISALLOW_FILE_EDIT', true);
Config::define('DISALLOW_FILE_MODS', true);
Config::define('DISABLE_WP_CRON', true);

Config::define('EMPTY_TRASH_DAYS', env('EMPTY_TRASH_DAYS') ?: 30);
Config::define('WP_ALLOW_REPAIR', true);
Config::define('WP_AUTO_UPDATE_CORE', false);
Config::define('WP_MEMORY_LIMIT', env('WP_MEMORY_LIMIT') ?: '256M');
Config::define('WP_MAX_MEMORY_LIMIT', env('WP_MAX_MEMORY_LIMIT') ?: '256M');
Config::define('WP_CRON_LOCK_TIMEOUT', 60);
Config::define('WP_POST_REVISIONS', env('WP_POST_REVISIONS') ?: 3);
Config::define('WP_CACHE_KEY_SALT', md5(WP_SITE_KEY . '_' . WP_ENV));

/**
 * Debugging Settings
 */
ini_set('display_errors', 0);
Config::define('SAVEQUERIES', false);
Config::define('ENABLE_LOG_DB', true);
Config::define('ENABLE_LOG_FILES', false);
Config::define('WP_DEBUG', false);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('SCRIPT_DEBUG', false);

// Polylang
Config::define('PLL_COOKIE', false);
Config::define('PLL_CACHE_LANGUAGES', true);
Config::define('PLL_CACHE_HOME_URL', true);

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';
if (file_exists($env_config)) {
    require_once $env_config;
}
Config::apply();

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', WP_WEBROOT_DIR . '/wp/');
}

/**
 * lock mode
 */
require_once('lock.php');

/**
 * debug functions
 */
require_once('debug.php');

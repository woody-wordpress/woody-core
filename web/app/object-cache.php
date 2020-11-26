<?php

defined('\\ABSPATH') || exit;

// Disable Redis Warning
define('WP_REDIS_DISABLE_DROPIN_MANAGE', true);
define('WP_REDIS_DISABLE_BANNERS', true);

if (defined('REDIS_HOST') && !empty(REDIS_HOST)) {
    define('WP_REDIS_HOST', REDIS_HOST);
    define('WP_REDIS_PORT', REDIS_PORT);
    define('WP_REDIS_DATABASE', REDIS_DB);
    require_once('object-cache-redis.php');
} elseif (defined('MEMCACHED_HOST') && !empty(MEMCACHED_HOST)) {
    require_once('object-cache-memcached.php');
}

<?php

require_once __DIR__ . '../../vendor/autoload.php';
use WoodyMonitor\WoodyMonitorStatus;

/**
 * Directory containing all of the site's files
 */
define('WP_ROOT_DIR', preg_replace('/releases\\/[0-9]*/', 'current', dirname(__DIR__)));
define('WP_WEBROOT_DIR', WP_ROOT_DIR . '/web');
define('WP_VENDOR_DIR', WP_ROOT_DIR . '/vendor');

new WoodyMonitorStatus();

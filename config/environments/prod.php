<?php
/**
 * Configuration overrides for WP_ENV === 'prod'
 */

if (WOODY_ACCESS_STAGING) {
    ini_set('display_errors', 1);

    if (defined('WP_CLI') && WP_CLI) {
        define('SAVEQUERIES', false);
    } else {
        define('SAVEQUERIES', true);
    }
} else {
    ini_set('display_errors', 0);
    define('SAVEQUERIES', false);
}

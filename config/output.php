<?php

function output_log($log, $tag = null)
{
    $log = output_array($log, $tag);
    if (defined('WP_CLI') && WP_CLI) {
        \WP_CLI::log($log);
    }

    // Save Error inside custom log
    if (ENABLE_LOG_FILES && substr($log, 0, 3) !== '...') {
        output_log_file($log);
    }

    output_log_db($log);
}

    function output_h1($log, $tag = null)
    {
        $log = output_array($log, $tag);
        $log = '---- ' . mb_strtoupper($log, 'UTF-8') . ' ----';
        output_log($log);
    }

    function output_h2($log, $tag = null)
    {
        $log = output_array($log, $tag);
        $log = '## ' . $log;
        output_log($log);
    }

    function output_h3($log, $tag = null)
    {
        $log = output_array($log, $tag);
        $log = '> ' . $log;
        output_log($log);
    }

    function output_debug($log, $tag = null)
    {
        $log = output_array($log, $tag);
        output_log($log);
    }

function output_warning($log, $tag = null)
{
    $log = output_array($log, $tag);
    if (defined('WP_CLI') && WP_CLI) {
        \WP_CLI::warning($log);
    }

    // Save Error inside custom log
    if (ENABLE_LOG_FILES && substr($log, 0, 3) !== '...') {
        output_log_file($log, 'warning');
    }

    output_log_db($log, 'warning');
}

function output_error($log, $tag = null, $exit = false)
{
    $log = output_array($log, $tag);
    if (defined('WP_CLI') && WP_CLI) {
        \WP_CLI::error($log, $exit);
    }

    // Save Error inside custom log
    if (ENABLE_LOG_FILES && substr($log, 0, 3) !== '...') {
        output_log_file($log, 'error');
    } else {
        // Always log error inside PHP error
        error_log('[' . WP_SITE_KEY . '] ' . $log, 0);
        if (extension_loaded('newrelic')) {
            newrelic_notice_error('[' . WP_SITE_KEY . '] ' . $log);
        }
    }

    output_log_db($log, 'error');
}

function output_success($log, $tag = null)
{
    $log = output_array($log, $tag);
    if (defined('WP_CLI') && WP_CLI) {
        \WP_CLI::success($log);
    }

    // Save Error inside custom log
    if (ENABLE_LOG_FILES && substr($log, 0, 3) !== '...') {
        output_log_file($log, 'success');
    }

    output_log_db($log, 'success');
}

/* --------------------------------------------------- */

function output_log_db($log, $status = 'debug')
{
    if (ENABLE_LOG_DB && substr($log, 0, 3) !== '...') {
        do_action('woody_logs_add', $status, $log);
    }
}

function output_array($log, $tag = null)
{
    if (!empty($tag)) {
        $log = [$tag => $log];
    }

    if (is_array($log) || is_object($log)) {
        $log = json_encode($log);
    }

    return $log;
}

function output_log_file($log, $status = 'debug')
{
    $log_file = __DIR__ . '/../logs/' . WP_SITE_KEY . '.log';
    if (!file_exists($log_file)) {
        file_put_contents(WP_SITE_KEY, $log_file);
    }
    error_log('[' . date('d-m-Y H:i:s') . '] ' . strtoupper($status) . ' : ' . $log . "\n", 3, $log_file);
    error_log('[' . WP_SITE_KEY . '] ' . strtoupper($status) . ' : ' . $log, 0);
}

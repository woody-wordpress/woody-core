<?php

/**
 * Record custom data about this web transaction
 * Ensure PHP agent is available
 */
if (extension_loaded('newrelic') && defined('WOODY_CORE_REVISION') && defined('WOODY_SITE_REVISION')) {
    newrelic_add_custom_parameter('WP_SITE_KEY', WP_SITE_KEY);
    newrelic_add_custom_parameter('WOODY_CORE_REVISION', WOODY_CORE_REVISION);
    newrelic_add_custom_parameter('WOODY_SITE_REVISION', WOODY_SITE_REVISION);

    if (!empty($_SERVER['HTTP_HOST']) && !empty($_SERVER['REQUEST_URI'])) {
        $woody_full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
        $woody_full_url .= $_SERVER['HTTP_HOST'];
        $woody_full_url .= $_SERVER['REQUEST_URI'];
        newrelic_add_custom_parameter('URL', $woody_full_url);
    }
}

/**
 * PHP Debug
 */
function wd($val, $level = 'debug')
{
    do_action('qm/' . $level, $val);
}

function rcd($val)
{
    wd($val);
}

/**
 * console_log
 */
function console_log($output, $tag = 'Say my name, say my name', $with_script_tags = true)
{
    if (WP_ENV == 'dev') {
        $js_code = 'console.log(); console.log("%c'. $tag .'", "background: #222; color: #bada55; padding:3px;", ' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }

        echo $js_code;
    }
}

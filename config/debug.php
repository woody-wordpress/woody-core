<?php

/**
 * Added Sentry.io
 */
if (!empty(WOODY_SENTRY) && WP_ENV != 'dev') {
    $release = json_decode(file_get_contents(WP_ROOT_DIR . '/composer.json'), true);
    $version = (!empty($release['version'])) ? $release['version'] : '0.0.0';

    Sentry\init(['environment' => WP_ENV, 'dsn' => WOODY_SENTRY, 'release' => 'woody@' . $version]);
    Sentry\configureScope(function (Sentry\State\Scope $scope): void {
        $scope->setTag('site_key', WP_SITE_KEY);
    });
}

/**
 * Record custom data about this web transaction
 * Ensure PHP agent is available
 */
if (extension_loaded('newrelic') && defined('WOODY_CORE_REVISION') && defined('WOODY_SITE_REVISION')) {
    newrelic_add_custom_parameter('WP_SITE_KEY', WP_SITE_KEY);
    newrelic_add_custom_parameter('WOODY_CORE_REVISION', WOODY_CORE_REVISION);
    newrelic_add_custom_parameter('WOODY_SITE_REVISION', WOODY_SITE_REVISION);
}

/**
 * PHP Console
 */
function wd($val, $tag = null)
{
    if (WP_ENV == 'dev') {
        if (!class_exists('PC', false) && class_exists('PhpConsole', false)) {
            PhpConsole\Helper::register();
        }

        if (class_exists('PC', false)) {
            PC::debug($val, $tag);
        }
    }
}

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

/**
 * @param  [type] $val     [Valeur à debug]
 * @param  bool   $exit    [Force l'affichage du debug si vrai]
 */
function rcd($val, $exit = false, $pre = true)
{
    if ($pre) {
        print '<pre style="background:lightblue">';
    }
    print_r($val);
    if ($pre) {
        print '</pre>';
    }

    if ($exit) {
        exit();
    }
}

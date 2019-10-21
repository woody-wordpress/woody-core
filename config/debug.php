<?php

/**
 * Added Sentry.io
 */
if (!empty(WOODY_SENTRY) && WP_ENV != 'dev') {
    Sentry\init(['environment' => WP_ENV, 'dsn' => WOODY_SENTRY]);
    Sentry\configureScope(function (Sentry\State\Scope $scope): void {
        $scope->setTag('site_key', WP_SITE_KEY);
    });
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

<?php
// This will let the permissions be 0775
// https://symfony.com/doc/3.3/setup/file_permissions.html
umask(0002);

/** WordPress view bootstrapper */
define('WP_USE_THEMES', true);
require(__DIR__ . '/wp/wp-blog-header.php');

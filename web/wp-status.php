<?php

require_once __DIR__ . '../../vendor/autoload.php';

function array_env($env)
{
    $env = str_replace(array('[', ']', '"', ' '), '', env($env));
    $env = (!empty($env)) ? explode(',', $env) : [];
    return $env;
}

use Symfony\Component\Finder\Finder;

Env::init();
$finder = new Finder();
$finder->files()->followLinks()->ignoreDotFiles(false)->in(__DIR__ . '/../config/sites')->name('.env');

// check if there are any search results
if ($finder->hasResults()) {
    foreach ($finder as $file) {
        $pathinfo = pathinfo($file->getRealPath());
        $dotenv = Dotenv\Dotenv::create($pathinfo['dirname']);
        $dotenv->overload();

        $site_key = explode('/', $pathinfo['dirname']);
        $site_key = end($site_key);

        $sites[] = [
            'site_key' => $site_key,
            'url' => env('WP_HOME'),
            'locked' => env('WOODY_ACCESS_LOCKED'),
            'options' => array_unique(array_env('WOODY_OPTIONS')),
        ];
    }
}
// print '<pre>';
// print_r($sites);
?>
<html>

<head>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #FFF;
            margin: 0;
            padding: 0;
            background: rgb(249, 185, 42);
            background: linear-gradient(144deg, rgba(249, 185, 42, 1) 0%, rgba(224, 0, 88, 1) 100%);
        }

        .logo {
            display: block;
            margin: 30px auto;
            width: 200px;
        }

        .cards {
            margin: 30px auto;
            /* background: rgba(255, 255, 255, 0.5); */
        }

        td {
            padding: 5px 15px;
        }

        a.status {
            border-radius: 4px;
            padding: 3px 8px;
            text-decoration: none;
            background: #FFF;
            color: #000;
        }

        a.status.locked {
            background: #000;
            color: #FFF;
        }

        a.status:hover,
        a.status.open:hover,
        a.status.locked:hover {
            color: rgba(224, 0, 88, 1);
        }

        .option {
            width: 15px;
            float: left;
            margin: 0 5px;
            padding: 3px 8px;
            border-radius: 4px;
            background: #FFF;
        }

    </style>
</head>

<body>
    <img src="woody_logo_white.svg" class="logo" alt="Woody">

    <table class="cards">
        <?php foreach ($sites as $site) : ?>
            <tr class="card">
                <td class="status">
                    <a href="<?php print $site['url']; ?>" target="_blank" class="status <?php print ($site['locked']) ? 'locked' : 'open'; ?>">
                        <?php print ($site['locked']) ? 'fermé' : 'ouvert'; ?>
                    </a>
                </td>
                <td class="site_key"><?php print $site['site_key']; ?></td>
                <td class="options">
                    <?php foreach ($site['options'] as $option) : ?>
                        <?php if (file_exists(__DIR__ . '/app/plugins/woody-plugin/dist/Plugin/Resources/Assets/img/logo_' . $option . '.png')) : ?>
                            <img src="/app/plugins/woody-plugin/dist/Plugin/Resources/Assets/img/logo_<?php print $option; ?>.png" class="option" title="<?php print $option; ?>" alt="<?php print $option; ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>

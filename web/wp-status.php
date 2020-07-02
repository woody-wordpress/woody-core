<?php

require_once __DIR__ . '../../vendor/autoload.php';

function array_env($env)
{
    $env = str_replace(array('[', ']', '"', ' '), '', $env);
    $env = (!empty($env)) ? explode(',', $env) : [];
    sort($env);
    return array_unique($env);
}

function dotenv($file)
{
    $env = [];
    $file = file_get_contents($file);
    $file = explode("\n", $file);
    foreach ($file as $line) {
        if (!empty($line)) {
            $line = explode('=', $line);
            $key = $line[0];
            $val = substr(substr($line[1], 1), 0, -1);

            if (substr($val, 0, 1) == '[' && substr($val, -1) == ']') {
                $val = array_env($val);
            } elseif (strpos($val, 'false') !== false) {
                $val = false;
            } elseif (strpos($val, 'true') !== false) {
                $val = true;
            }

            $env[$key] = $val;
        }
    }
    return $env;
}

function __($str)
{
    switch ($str) {
        case 'empty':
            return 'absent';
            break;
        case 'locked':
            return 'fermé';
            break;
        case 'opened':
            return 'ouvert';
            break;
    }

    return $str;
}

use Symfony\Component\Finder\Finder;

Env::init();
$finder = new Finder();
$finder->files()->followLinks()->ignoreDotFiles(false)->in(__DIR__ . '/../config/sites')->name('.env');

// check if there are any search results
if ($finder->hasResults()) {
    foreach ($finder as $file) {
        $env = dotenv($file);

        $pathinfo = pathinfo($file->getRealPath());
        $site_key = explode('/', $pathinfo['dirname']);
        $site_key = end($site_key);

        $locked = (!empty($env['WOODY_ACCESS_LOCKED'])) ? $env['WOODY_ACCESS_LOCKED'] : false;
        $staging = (!empty($env['WOODY_ACCESS_STAGING'])) ? $env['WOODY_ACCESS_STAGING'] : false;

        if (!file_exists(__DIR__ . '/app/themes/' . $site_key . '/style.css')) {
            $status = 'empty';
        } elseif ($staging) {
            $status = 'staging';
        } elseif ($locked) {
            $status = 'locked';
        } else {
            $status = 'opened';
        }

        $sites[$site_key] = [
            'site_key' => $site_key,
            'url' => (!empty($env['WOODY_HOME'])) ? $env['WOODY_HOME'] : null,
            'status' => $status,
            'locked' => $locked,
            'staging' => $staging,
            'options' => (!empty($env['WOODY_OPTIONS'])) ? $env['WOODY_OPTIONS'] : [],
        ];
    }

    ksort($sites);
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

        .status a {
            border-radius: 4px;
            padding: 3px 8px;
            text-decoration: none;
            background: #FFF;
            color: #000;
        }

        .locked .status a {
            background: #000;
            color: #FFF;
        }

        .empty .status a,
        .staging .status a {
            background: transparent;
            color: #FFF;
            border: 1px dotted #FFF;
        }

        .empty {
            opacity: .3;
        }

        .status a:hover {
            color: rgba(224, 0, 88, 1);
        }

        .empty .status a:hover,
        .staging .status a:hover {
            color: rgba(224, 0, 88, 1);
            background: #FFF;
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
            <tr class="card <?php print $site['status']; ?>">
                <td class="status">
                    <a href="<?php print $site['url']; ?>" target="_blank">
                        <?php print __($site['status']); ?>
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

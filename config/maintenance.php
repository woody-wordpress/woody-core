<?php if (!defined('WP_CLI') || WP_CLI != true) : ?>
<?php if (WOODY_MAINTENANCE || (substr($_SERVER['REQUEST_URI'], 0, 3) == '/wp' && WOODY_MAINTENANCE_ADMIN)) : ?>
<?php
header($_SERVER["SERVER_PROTOCOL"] . " 503 Service Temporarily Unavailable", true, 503);
header('Retry-After: 15');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Maintenance [<?php print strtoupper(WP_ENV); ?>]</title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: "Trebuchet MS", Helvetica, sans-serif;
            font-size: 16px;
            text-align: center;
            padding: 50px;
            color: #333;
            height: 100vh;
        }

        h1 {
            font-family: "Amaranth", "Trebuchet MS", Helvetica, sans-serif;
            text-align: center;
            font-size: 50px;
            color: #37AAAE;
        }

        p.footer {
            font-weight: bold;
        }

        #article {
            display: block;
            width: 530px;
            margin: 0 auto;
        }

        img.lock {
            display: block;
            margin: 15px auto;
        }
    </style>
</head>
<body>
    <div id="article">
        <h1>Maintenance en cours !</h1>
        <?php
        $gifs = [
            'https://media.giphy.com/media/pFZTlrO0MV6LoWSDXd/giphy.gif',
            'https://media.giphy.com/media/ZXKZWB13D6gFO/giphy.gif',
            'https://media.giphy.com/media/tXL4FHPSnVJ0A/giphy.gif',
            'https://media.giphy.com/media/5wWf7H0qoWaNnkZBucU/giphy.gif',
            'https://media.giphy.com/media/hCiQVo1dzVwPu/giphy.gif',
            'https://media.giphy.com/media/PWfHC8ogZpWcE/giphy.gif',
            'https://media.giphy.com/media/3o6ZsUxHFSRNpTIXmg/giphy.gif',
        ];
        ?>
        <img src="<?php print $gifs[array_rand($gifs, 1)] ?>">
        <p>Nous nous excusons pour la g&ecirc;ne occasionn&eacute;e.<br/>Dans le but d'am&eacute;liorer ses performances, notre site est actuellement en cours de maintenance. Nous serons de retour en ligne sous peu !</p>
        <hr />
        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. We&rsquo;ll be back online shortly!</p>
        <p class="footer">Made with ♥ by Raccourci Agency</p>
    </div>
</body>
</html>
<?php exit(); ?>
<?php endif; ?>
<?php endif; ?>

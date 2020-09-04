<?php if (WOODY_ACCESS_LOCKED) : ?>
<!DOCTYPE html>
<html>
<head>
    <title>Accès fermé [<?php print strtoupper(WP_ENV); ?>]</title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: "Trebuchet MS", Helvetica, sans-serif;
            font-size: 20px;
            text-align: center;
            padding: 50px;
            color: #333;
            height: 100vh;
        }

        h1 {
            font-family: "Amaranth", "Trebuchet MS", Helvetica, sans-serif;
            text-align: center;
            font-size: 50px;
            color: #F84960;
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
        <h1>Accès fermé !</h1>
        <?php
        $gifs = [
            'https://media.giphy.com/media/ewnsEE7mLKHfO/giphy.gif',
            'https://media.giphy.com/media/rZvkoiQYuPkVq/source.gif',
            'https://media.giphy.com/media/pNfBjk1rpiwzC/source.gif',
        ];
        ?>
        <img src="<?php print $gifs[array_rand($gifs, 1)] ?>">
        <p>Vous êtes sûr un site de "pré-production" fermé.<br>Si vous souhaitez accéder à ce site, contactez-nous.</p>
        <p class="footer">Made with ♥ by Raccourci Agency</p>
    </div>
</body>
</html>
<?php exit(); ?>
<?php endif; ?>

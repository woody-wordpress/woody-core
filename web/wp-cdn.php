<?php
// Retourne le pays de l'utilisateur en fonction de Cloudflare
if(!empty($_GET['ip']) && !empty($_SERVER['HTTP_CF_IPCOUNTRY'])) {
    header('Content-Type: application/json; charset=utf-8');
    print json_encode(['cf_country' => $_SERVER['HTTP_CF_IPCOUNTRY']]);
    exit();
}
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
            position: fixed;
            top: 50%;
            left: 50%;
            margin: -50px 0 0 -100px;
        }
    </style>
</head>
<body>
    <img src="woody_logo_white.svg" class="logo" alt="Woody">
</body>
</html>

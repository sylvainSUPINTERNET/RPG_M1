<?php
require_once '../../autoload.php';
session_start();

 if($_SESSION["character"]->getHereo() === "asmongod"){ ?>
<!doctype html>
<html lang="en" style="background-image: url('../assets/dead/asmongod.jpeg')">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEAD</title>
</head>
<body>

</body>
</html>

<?php } ?>


<?php
    if($_SESSION["character"]->getHereo() === "leeroy"){ ?>
    <!doctype html>
    <html lang="en" style="background-image: url('../assets/dead/leeroy.jpeg') ">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>DEAD</title>
    </head>
    <body>

    </body>
    </html>

<?php } ?>


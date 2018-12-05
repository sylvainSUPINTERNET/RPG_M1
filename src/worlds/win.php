<?php
require_once '../../autoload.php';
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RPG | JOLY SYLVAIN</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"
            integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>

<body class="container">
<h2 class="text-center mt-4">GG, new item collected !</h2>

<div class="card">
    <ul>
        <li style="list-style-type: none">
            <h3><?php echo $_SESSION["ITEM_DROP"]->getName() ?></h3>
        </li>
        <li style="list-style-type: none" class="row">
            <div class="col-md-2">
                <img src="<?php echo $_SESSION["ITEM_DROP"]->getItemIconName() ?>">
            </div>
            <div class="col-md-5">
                <ul>
                    <li style="list-style-type: none">
                        <i class="fa fa-heart"
                           style="color:darkred"></i> <?php echo $_SESSION["ITEM_DROP"]->getStatAtk() ?>
                    </li>
                    <li style="list-style-type: none">
                        <i class="fa fa-fist-raised"
                           style="color:dimgrey"></i> <?php echo $_SESSION["ITEM_DROP"]->getStatHealth() ?>
                    </li>

                    <li style="list-style-type: none">
                        Bonus :
                        <strong><?php echo $_SESSION["ITEM_DROP"]->getStatSpecial() ?></strong>
                        <br>
                        <img src="<?php echo $_SESSION["ITEM_DROP"]->getStatSpecialIcon() ?>">
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>


todo -> set 1 new item to user /
todo -> set item + stat + special to user session
-> redirect to home (with new items)
-> spell ( add spell linked to his new item ) and add button (use my spell (cost mana))
</body>
</html>
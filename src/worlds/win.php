<?php
require_once '../../autoload.php';
session_start();

var_dump($_SESSION["character"]);
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

<h2 class="text-center mt-4">GG, <?php echo $_SESSION["boss"]->getHereo() . " has been defeated."?></h2>
<div class="row">
    <div class="col-md-6">
        <?php
        if($_SESSION["ITEM_DROP"]->getQuality() === "green"){ ?>
            <h3 style="color: limegreen;" class="mb-2 mt-2">[ <?php echo $_SESSION["ITEM_DROP"]->getName() ?>]</h3>
            <?php
        }?>

        <?php
        if($_SESSION["ITEM_DROP"]->getQuality() === "blue"){ ?>
            <h3 style="color: royalblue;" class="mb-2 mt-2">[ <?php echo $_SESSION["ITEM_DROP"]->getName() ?>]</h3>
            <?php
        }?>

        <?php
        if($_SESSION["ITEM_DROP"]->getQuality() === "purple"){ ?>
            <h3 style="color: rebeccapurple;" class="mb-2 mt-2">[ <?php echo $_SESSION["ITEM_DROP"]->getName() ?>]</h3>
            <?php
        }?>

        <?php
        if($_SESSION["ITEM_DROP"]->getQuality() === "orange"){ ?>
            <h3 style="color: orange;" class="mb-2 mt-2">[ <?php echo $_SESSION["ITEM_DROP"]->getName() ?>]</h3>
            <?php
        }?>
        <div class="row">
            <div class="col-md-12">
                <img src="<?php echo $_SESSION["ITEM_DROP"]->getItemIconName() ?>">
                <i class="fa fa-heart"
                   style="color:darkred"></i> <?php echo $_SESSION["ITEM_DROP"]->getStatAtk() ?>
                <i class="fa fa-fist-raised"
                   style="color:dimgrey"></i> <?php echo $_SESSION["ITEM_DROP"]->getStatHealth() ?>
                <i class="fa fa-gem"
                   style="color:dodgerblue"></i>
                <?php echo $_SESSION["ITEM_DROP"]->getStatMana() ?>
                Bonus :
                <img src="<?php echo $_SESSION["ITEM_DROP"]->getStatSpecialIcon() ?>">
                <strong><?php echo $_SESSION["ITEM_DROP"]->getStatSpecial() ?></strong>
            </div>
    </div>

        <br>
        <div class="mt-5">
            <a href="../start.php" class="btn btn-primary btn-lg"> Go back to wolrd selection</a>
            <a href="reset.php" class="btn btn-danger btn-lg"> Reset the game</a>
        </div>
</div>

    <?php
        $inventory = new Inventory();
        $inventory->addItem($_SESSION["ITEM_DROP"]);

        //reset buff activated to update stats for next fight
        $_SESSION["character"]->setBuffActivated(false);
        ?>

</body>
</html>
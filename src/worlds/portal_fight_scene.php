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

<body class="container" style="background: whitesmoke">
<?php


//$current_boss = CharacterChar::unseralizeSession($_SESSION["current_boss"]);
//$current_character = CharacterChar::unseralizeSession($_SESSION["current_character"]);

$current_boss = $_SESSION["boss"];
$current_character = $_SESSION["character"];


//init turn system
$turnManager = new TurnManager(); //default played is false;
$_SESSION["attacked"] = $turnManager->isPlayed(); //default false

//init turn
if (isset($_POST["attack"])) {

    //apply char damage to boss
    $current_character->attack($current_character, $current_boss);

    //update turn of characater
    $turnManager->charAttacked();

}

if (isset($_POST["pass_turn"])) {
    //apply damage + make the boss play and dialog + reset turn to false

    //apply boss damage to char
    $current_boss->attack($current_boss, $current_character);

    //reset turn
    $turnManager->bossAttacked();


    //character dead
    if($current_character->getHp() <= 0){
        header('Location: dead.php');
    }

    //boss dead
    if($current_boss->getHp() <= 0){
        //set drop item
        $loots = $_SESSION["raid"]->getTableItems();
        $_SESSION["ITEM_DROP"] = $_SESSION["raid"]->getTableItems()[Utils::getRandom(0, sizeof($loots) -1)];
        $_SESSION["raid"]->getTableItems()[Utils::getRandom(0, sizeof($loots) -1)];
        header('Location: win.php');
    }

}

?>
<section class="mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="width: 22rem;">
                <img class="card-img-top" src="<?php echo '../' . $current_character->getHereoPic() ?>"
                     alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title text-center"><?php echo $current_character->getNickname() ?></h3>
                    <div class="card-text">
                        <h5 class=""><i class="fa fa-malex"></i> Statistiques</h5>
                        <ul class="mt-3">
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fa fa-heart"
                                   style="color:darkred"></i> <?php echo $current_character->getHp() ?>
                            </li>
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fa fa-fist-raised"
                                   style="color:dimgrey"></i> <?php echo $current_character->getAtk() ?>
                            </li>
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fa fa-gem"
                                   style="color:dodgerblue"></i> <?php echo $current_character->getMana() ?>
                            </li>
                        </ul>

                        <h5 class=""><i class="fa fa-shopping-bag"></i> Inventaire</h5>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <img src="../assets/other/vs-logo.jpg">
            <br>
            <br>
            <p class="alert alert-danger">
                <?php
                //character attacked
                if ($_SESSION["attacked"] == true) {
                    echo $current_character->getHereo() . " : ".  $current_character->getQuotes()[$current_character->getHereo()][Utils::getRandom(0,2)];
                } else {
                    echo $current_boss->getHereo() . " : ". $current_boss->getQuotes()[$current_boss->getHereo()][Utils::getRandom(0,2)];
                    //boss attacked
                } ?>
            </p>

            <br>
            <br>

            <?php
            if ($_SESSION["attacked"] == true) { ?>
                <form method="post" action="portal_fight_scene.php">
                    <input type="hidden" name="pass_turn" value="<?php echo $current_character->getAtk() ?>">
                    <input type="submit" class="mt-5 mb-5 btn btn-danger btn-lg" value="Pass turn">
                </form>

                <form method="post" action="portal_fight_scene.php">
                    <input type="hidden" name="attack" value="<?php echo $current_character->getAtk() ?>">
                    <input type="submit" class="mt-5 mb-5 btn btn-danger btn-lg" value="Attack" disabled>
                </form>
                <?php
            } else { ?>
                <form method="post" action="portal_fight_scene.php">
                    <input type="hidden" name="pass_turn" value="<?php echo $current_character->getAtk() ?>">
                    <input type="submit" class="mt-5 mb-5 btn btn-danger btn-lg" value="Pass turn" disabled>
                </form>
                <form method="post" action="portal_fight_scene.php">
                    <input type="hidden" name="attack" value="<?php echo $current_character->getAtk() ?>">
                    <input type="submit" class="mt-5 mb-5 btn btn-danger btn-lg" value="Attack">
                </form>
                <?php
            }
            ?>

        </div>
        <div class="col-md-4">
            <div class="card" style="width: 22rem;">
                <img class="card-img-top" src="<?php echo $current_boss->getPicPath() ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-center"><?php echo $current_boss->getHereo() ?></h5>
                    <div class="card-text">
                        <h5 class="text-right"><i class="fa fa-malex"></i> Statistiques</h5>
                        <ul class="mt-3 text-right">
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fa fa-heart" style="color:darkred"></i> <?php echo $current_boss->getHp() ?>
                            </li>
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fa fa-fist-raised"
                                   style="color:dimgrey"></i> <?php echo $current_boss->getAtk() ?>
                            </li>
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fa fa-gem"
                                   style="color:dodgerblue"></i> <?php echo $current_boss->getMana() ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>
</html>
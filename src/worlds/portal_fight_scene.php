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
$current_skill = $_SESSION["skills"];


//set stats with items in inventory if he has items
if (!$_SESSION["character"]->isBuffActivated()) {
    $_SESSION["character"]->setBuffFromItems();
}


//init turn system
$turnManager = new TurnManager(); //default played is false;
//$_SESSION["attacked"] = $turnManager->isPlayed(); //default false


//when is character turn, check quantity of mana to enable skills
$skills = Skill::checkManaAmount($current_character, $current_skill);



//turn from skill
if(isset($_POST["attack_skill"]) && isset($_POST["attack_skill_mana_cost"]) && $_SESSION["attacked"] === false){
    $current_character->skillAttack($current_character, $current_boss, $_POST["attack_skill"], $_POST["attack_skill_mana_cost"]);
    $turnManager->charAttacked(); //update user turn

    //set dialog
    Skill::dialog($_POST["attack_skill_mana_cost"], $current_skill);
}


//init turn
if (isset($_POST["attack"]) && $_SESSION["attacked"] === false) {
    //apply char damage to boss
    $current_character->attack($current_character, $current_boss, "character");


    //TODO can be removed ?
    Spell::charSpell($current_character, $current_boss); //items

    //update turn of characater
    $turnManager->charAttacked();
    Spell::clearDialog("SPELL_BOSS_CAST");

}


if (isset($_POST["pass_turn"])) {
    //apply damage + make the boss play and dialog + reset turn to false

    //character dead
    if ($current_character->getHp() <= 0) {
        Spell::clearDialog("ITEMS_PROC_DIALOG");
        Skill::clearDialog();
        header('Location: dead.php');
    } else if //boss dead
    ($current_boss->getHp() <= 0) {
        //set drop item
        $loots = $_SESSION["raid"]->getTableItems();
        $_SESSION["ITEM_DROP"] = $_SESSION["raid"]->getTableItems()[Utils::getRandom(0, sizeof($loots) - 1)];
        $_SESSION["raid"]->getTableItems()[Utils::getRandom(0, sizeof($loots) - 1)];
        Spell::clearDialog("ITEMS_PROC_DIALOG");
        Skill::clearDialog();
        header('Location: win.php');
    } else {

        //apply boss damage to char
        $current_boss->attack($current_boss, $current_character, "boss");
        Spell::bossSpell($current_boss, $current_character);

        //reset turn
        $turnManager->bossAttacked();
        Spell::clearDialog("ITEMS_PROC_DIALOG");
        Skill::clearDialog();

    }



}

?>
<section class="mt-5">
    <div class="row">
        <div class="col-md-4">
            <?php
            //character attacked
            if (isset($_SESSION["ITEMS_PROC_DIALOG"]) && $_SESSION["ITEMS_PROC_DIALOG"] != "") { ?>
                <p class="mt-2 alert alert-primary">
                    <?php echo $_SESSION['ITEMS_PROC_DIALOG'] ?>
                </p>
            <?php } ?>
            <div class="card" style="width: 22rem;">
                <img class="card-img-top" src="<?php echo '../' . $current_character->getHereoPic() ?>"
                     alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title text-center"><?php echo $current_character->getNickname() ?></h3>
                    <div class="card-text">
                        <h5 class=""><i class="fa fa-malex"></i> Skills</h5>

                        <?php

                            if($turnManager->isPlayed()){
                                //already played -> skill disable
                                    ?>
                                <ul class="mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form method="post" action="portal_fight_scene.php">
                                                <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][0]->getEffect() ?>">
                                                <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][0]->getManaCost() ?>">
                                                <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][0]->getIcon() ?>">
                                                <br>
                                                <input class="btn btn-success mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][0]->getName() ?>" disabled>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <p>cost : <?php echo $_SESSION["skills"][0]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                            <p><?php echo $_SESSION["skills"][0]->getDescription() ?></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <form method="post" action="portal_fight_scene.php">
                                                <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][1]->getEffect() ?>">
                                                <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][1]->getManaCost() ?>">
                                                <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][1]->getIcon() ?>">
                                                <br>
                                                <input class="btn btn-danger mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][1]->getName() ?>" disabled>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <p>cost : <?php echo $_SESSION["skills"][1]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                            <p><?php echo $_SESSION["skills"][1]->getDescription() ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form method="post" action="portal_fight_scene.php">
                                                <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][2]->getEffect() ?>">
                                                <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][2]->getManaCost() ?>">
                                                <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][2]->getIcon() ?>">
                                                <br>
                                                <input class="btn btn-primary mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][2]->getName() ?>" disabled>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <p>cost : <?php echo $_SESSION["skills"][2]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                            <p><?php echo $_SESSION["skills"][2]->getDescription() ?></p>
                                        </div>
                                    </div>
                                </ul>
                            <?php } else {
                                // skill 1 / 2 /3 enable by mana cost check method
                                switch(sizeof($skills)){
                                    case 1:
                                        ?>
                                        <ul class="mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][0]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][0]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][0]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-success mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][0]->getName() ?>">
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][0]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][0]->getDescription() ?></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][1]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][1]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][1]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-danger mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][1]->getName() ?>" disabled>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][1]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][1]->getDescription() ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][2]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][2]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][2]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-primary mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][2]->getName() ?>" disabled>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][2]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][2]->getDescription() ?></p>
                                                </div>
                                            </div>
                                        </ul>
                                        <?php
                                        break;
                                    case 2:
                                        ?>
                                        <ul class="mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][0]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][0]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][0]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-success mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][0]->getName() ?>">
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][0]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][0]->getDescription() ?></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][1]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][1]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][1]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-danger mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][1]->getName() ?>">
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][1]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][1]->getDescription() ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][2]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][2]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][2]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-primary mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][2]->getName() ?>" disabled>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][2]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][2]->getDescription() ?></p>
                                                </div>
                                            </div>
                                        </ul>
                                        <?php
                                        break;

                                    case 3:
                                        ?>
                                        <ul class="mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][0]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][0]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][0]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-success mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][0]->getName() ?>">
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][0]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][0]->getDescription() ?></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][1]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][1]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][1]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-danger mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][1]->getName() ?>">
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][1]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][1]->getDescription() ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][2]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][2]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][2]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-primary mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][2]->getName() ?>">
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][2]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][2]->getDescription() ?></p>
                                                </div>
                                            </div>
                                        </ul>
                                        <?php
                                        break;
                                    default:
                                        //all disable (array empty)
                                        ?>
                                        <ul class="mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][0]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][0]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][0]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-success mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][0]->getName() ?>" disabled>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][0]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][0]->getDescription() ?></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][1]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][1]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][1]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-danger mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][1]->getName() ?>" disabled>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][1]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][1]->getDescription() ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form method="post" action="portal_fight_scene.php">
                                                        <input type="hidden" name="attack_skill" value="<?php echo $_SESSION["skills"][2]->getEffect() ?>">
                                                        <input type="hidden" name="attack_skill_mana_cost" value="<?php echo $_SESSION["skills"][2]->getManaCost() ?>">
                                                        <img class="rounded" src="../assets/skill/<?php echo $_SESSION["skills"][2]->getIcon() ?>">
                                                        <br>
                                                        <input class="btn btn-primary mt-1 mb-3" type="submit" value="<?php echo $_SESSION["skills"][2]->getName() ?>" disabled>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>cost : <?php echo $_SESSION["skills"][2]->getManaCost()?> <i class="fa fa-gem" style="color:dodgerblue"></i></p>
                                                    <p><?php echo $_SESSION["skills"][2]->getDescription() ?></p>
                                                </div>
                                            </div>
                                        </ul>
                                        <?php
                                        break;
                                }
                            }
                        ?>
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
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fas fa-apple-alt" style="color: indianred;"></i> <?php echo $current_character->getRegenManaRatio().' mana pts / turn' ?>
                            </li>
                        </ul>
                        <div>
                            <h5 class=""><i class="fa fa-shopping-bag"></i> Inventaire</h5>
                            <?php if (isset($_SESSION["inventory"]) && sizeof($_SESSION["inventory"]) > 0) { ?>
                                <?php foreach ($_SESSION["inventory"] as $item) { ?>
                                    <ul>
                                        <?php
                                        if ($item->getQuality() === "green") { ?>
                                            <p style="color: limegreen;" class="mb-2 mt-2">
                                                [
                                                <?php echo $item->getName(); ?>
                                                ]
                                            </p>
                                            <?php
                                        } ?>

                                        <?php
                                        if ($item->getQuality() === "blue") { ?>
                                            <p style="color: royalblue;" class="mb-2 mt-2">
                                                [
                                                <?php echo $item->getName(); ?>
                                                ]
                                            </p>
                                            <?php
                                        } ?>

                                        <?php
                                        if ($item->getQuality() === "purple") { ?>
                                            <p style="color: rebeccapurple;" class="mb-2 mt-2">
                                                [
                                                <?php echo $item->getName(); ?>
                                                ]
                                            </p>
                                            <?php
                                        } ?>

                                        <?php
                                        if ($item->getQuality() === "orange") { ?>
                                            <p style="color: orange;" class="mb-2 mt-2">
                                                [
                                                <?php echo $item->getName(); ?>
                                                ]
                                            </p>
                                            <?php
                                        } ?>
                                        <img class="rounded" src="<?php echo $item->getItemIconName(); ?>">

                                        <i class="fa fa-fist-raised"
                                           style="color:dimgrey"></i>
                                        <?php echo $item->getStatAtk() ?>
                                        <i class="fa fa-heart"
                                           style="color:darkred"></i>
                                        <?php echo $item->getStatHealth() ?>
                                        <i class="fa fa-gem"
                                           style="color:dodgerblue"></i>
                                        <?php echo $item->getStatMana() ?>
                                        <br>
                                        <div class="mt-3">
                                            <h6>Buff</h6>
                                            <p><?php echo $item->getStatSpecial() ?></p>
                                            <img class="rounded" src="<?php echo $item->getStatSpecialIcon() ?>">
                                        </div>

                                    </ul>
                                    <hr>
                                <?php } ?>
                            <?php } else { ?>
                                <p class="text-center">You are naked.</p>
                            <?php } ?>

                        </div>


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
                    echo $current_character->getHereo() . " : " . $current_character->getQuotes()[$current_character->getHereo()][Utils::getRandom(0, 2)];
                } else {
                    echo $current_boss->getHereo() . " : " . $current_boss->getQuotes()[$current_boss->getHereo()][Utils::getRandom(0, 2)];
                    //boss attacked
                } ?>
            </p>

            <br>


            <!-- display spell casted -->
            <?php
            if(isset($_SESSION['SKILL_DIALOG']) && $_SESSION['SKILL_DIALOG'] !== ""){
                echo $_SESSION['SKILL_DIALOG'];
            } ?>

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
            <?php
            //character attacked
            if ((isset($_SESSION["SPELL_BOSS_CAST"])) && $_SESSION["SPELL_BOSS_CAST"] !== "") { ?>
                <p class="mt-2 alert alert-primary">
                    <?php echo $current_boss->getHereo() . " cast [". $_SESSION["SPELL_BOSS_CAST"]["name"]."]" ?>
                    <br>
                     <img class="rounded" src="<?php echo $_SESSION["SPELL_BOSS_CAST"]["icon"] ?>"/>
                    <?php echo " for " . $_SESSION["SPELL_BOSS_CAST"]["mana_cost"] . " <i class=\"fa fa-gem\"
                                   style=\"color:dodgerblue\"></i> and deal ".$_SESSION["SPELL_BOSS_CAST"]["dmg"]."
                                    <i class=\"fa fa-fist-raised\"
                                   style=\"color:dimgrey\"></i>" ?>
                    <br>
                </p>
            <?php } ?>


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
                            <li style="list-style-type:none" class="mt-1">
                                <i class="fas fa-apple-alt" style="color: indianred;"></i> <?php echo $current_character->getRegenManaRatio().' mana pts / turn' ?>
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
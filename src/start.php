<?php
require_once '../autoload.php';

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
<?php

//clear dialog at init of game (if reset etc ...)
Skill::clearDialog();


//User join new game
if (isset($_SESSION) && $_POST) {

    $_SESSION["attacked"] = false; //init turn false for fight scene

    $nickname = $_POST["nickname"];
    $hereo = $_POST["character_choice"];



    $character = new CharacterChar($nickname, $hereo, 30, 2900, 700, 400);
    $character->setNewGameSession($character);
    $character->getQuotes();

    //init SKILLS
    if ($hereo === "asmongod") {
        $_SESSION["skills"] = [
            new Skill("damage increase", 150, "BONUS_ATK", "asmongold_atk.jpg", "Increase your damage by 10"),
            new Skill("heal", 200, "QUICK_HEAL", "asmongold_heal.jpg", "Heal 150 HP"),
            new Skill("ultimate", 500, "ULTIMATE", "asmongold_ultimate.jpg", "Ultimate, deals 400 damage, increase your damage by 250 and heal 250"),
        ];
    } elseif ($hereo === "leeroy") {
        $_SESSION["skills"] = [
            new Skill("damage increase", 150, "BONUS_ATK", "leeroy_atk.jpg", "Increase your damage by 10"),
            new Skill("heal", 200, "QUICK_HEAL", "leeroy_heal.jpg", "Heal 150 HP"),
            new Skill("ultimate", 500, "ULTIMATE", "leeroy_ultimate.jpg", "Ultimate, deals 400 damage, increase your damage by 250 and heal 250"),
        ];
    }


} else {

    $_SESSION["character"]->setHp($_SESSION["character"]->getBaseHp());
}


$raid = new Raid("Portal");

$item_1 = new Item("Portal Sword", 2, 1, "Critical strike", "portal_sword.jpg", "critical_strike.jpg", 0, "green", 'CRIT damage * 2  <i class=\\"fa fa-bolt\\"
                                   style=\\"color:yellow\\"></i>', 150);
$item_2 = new Item("Portal Armor", 3, 1, "Heal", "portal_armor.jpg","heal.jpg", 0, "green", " +50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 200);
$item_3 = new Item("Portal Gantlet", 1, 5, "Heal", "portal_gantlet.jpg","health.jpg", 0,"blue","+50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 100);
$item_4 = new Item("Cool Mount", 5, 5, "Cool Boi", "portal_mount.jpg","cool_boy.jpg", 0,"purple", "CoOl boI +50 <i class=\"fa fa-fist-raised\"
                                   style=\"color:dimgrey\"></i>", 300);
$item_5 = new Item("Portal Cool Sword", 25, 2, "Critical strike", "portal_cool_sword.jpg","increase_damage.jpg", 0, "purple", "CRIT damage * 2  <i class=\\\"fa fa-bolt\\\"
                                   style=\\\"color:yellow\\\"></i>", 450);
$item_6 = new Item("Portal helmet", 1, 10, "Heal", "portal_helmet.jpg","tanky.jpg", 0, "blue","+50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 250);
$item_7 = new Item("Portal Legging", 3, 4, "Heal", "portal_legging.jpg","tanky.jpg", 0, "blue","+50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 280);
$item_8 = new Item("Portal Necklace", 3, 3, "Heal", "portal_necklace.jpg","heal.jpg", 0, "green","+50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 190);
$item_9 = new Item("Portal Ring", 5, 1, "Heal", "portal_ring.jpg","health.jpg", 0, "purple", "+50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 90);
$item_10 = new Item("Portal Boots", 2, 7, "Heal", "portal_boots.jpg","health.jpg", 0, "green", "+50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 100);
$item_11 = new Item("Portal Trinket", 1, 1, "Critical strike", "portal_trinket.jpg","critical_strike.jpg", 0, "blue", "CRIT damage * 2  <i class=\\\"fa fa-bolt\\\"
                                   style=\\\"color:yellow\\\"></i>", 70);
$item_12 = new Item("Portal Cloack", 3, 5, "Heal", "portal_cloack.jpg","extra_mana.jpg", 100, "purple", "+50 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>", 110);
$item_13 = new Item("Portal Hammer", 35, 2, "Fire damage", "portal_hammer.jpg","firing.jpg", 100,"orange", "Ragnaros * BY FIRE BE PURGED! <i class=\"fa fa-fire\"
                                   style=\"color:orangered\"></i>", 450);
$item_14 = new Item("WoW was better before",  100, 150, "Kungen > all", "kungen.jpg","pet_attack.jpg", 300, "purple","* Kungen * Actually, WoW is casu af", 10);
$item_15 = new Item("Portal Best Sword WORLD",  200, 200, "1/2 God", "portal_very_cool_sword.jpg","thunder.jpg", 200, "orange", "Thunder strikes <i class=\"fa fa-wind\"
                                   style=\"color:lightblue\"></i>", 890);
$item_16 = new Item("Portal God's mount",  10000, 10000, "Godlike", "portal_mount2.jpg","GODLIKE.jpg", 1000,"orange", " G O D  <i class=\"fa fa-praying-hands\"
                                   style=\"color:deeppink\"></i>", 10000);
$item_17 = new Item("Sco The Pet",  400, 400, "Sco > Kungen", "sco.jpg","pet_attack.jpg", 300, "purple", " 1st world G'huun", 15);


$raid->setTableItems([
    $item_1,
    $item_2,
    $item_3,
    $item_4,
    $item_5,
    $item_6,
    $item_7,
    $item_8,
    $item_9,
    $item_10,
    $item_11,
    $item_12,
    $item_13,
    $item_14,
    $item_15,
    $item_16,
    $item_17,
]);

$_SESSION['raid'] = $raid;

?>

<section class="text-center">
    <div>
        <h2>Hey, <?php echo $_SESSION["character"]->getNickname() ?> you playing
            as <?php echo $_SESSION["character"]->getHereo() ?></h2>

        <div class="row mt-5">
            <div class="col-md-6">
                <img class="rounded" src="<?php echo $_SESSION["character"]->getHereoPic() ?>" class="img-fluid mt-3" alt="Responsive image">
                <blockquote class="mt-3">
                    <?php echo '" ' . $_SESSION["character"]->getQuotes()[$_SESSION["character"]->getHereo()][0] . ' "' ?>
                    <br>
                    <?php echo $_SESSION["character"]->getGold()?> <i class="fa fa-coins" style="color:darkorange"></i>
                </blockquote>
            </div>
            <div class="col-md-6">
                <h4>Your items</h4>
                <?php
                    if(isset($_SESSION['inventory']) && sizeof($_SESSION['inventory']) >0){
                        echo '<ul>';
                        foreach($_SESSION['inventory'] as $item){
                            if($item->getQuality() === "green"){
                                echo '<li style="list-style-type: none;"><span style="color:limegreen"> ['.$item->getName().']</span></li>';
                            }
                            if($item->getQuality() === "blue"){
                                echo '<li style="list-style-type: none;"><span style="color:royalblue"> ['.$item->getName().']</span></li>';
                            }
                            if($item->getQuality() === "purple"){
                                echo '<li style="list-style-type: none;"><span style="color:rebeccapurple"> ['.$item->getName().']</span></li>';
                            }
                            if($item->getQuality() === "orange"){
                                echo '<li style="list-style-type: none;"><span style="color:orange"> ['.$item->getName().']</span></li>';
                            }
                        }
                        echo '</ul>';
                    } else {
                        echo "you are naked.";
                    }
                ?>
            </div>
        </div>

    </div>
</section>

<section class="row mt-4">
    <div class="col-md-4">
        <p class="text-center">WoW > All</p>
        <a href="./worlds/portal.php">
            <img src="./assets/doors/portal.jpg" class="img-fluid mt-3 rounded" alt="Responsive image">
        </a>
    </div>
    <div class="col-md-4">
        <p class="text-center">Fortnite > WoW</p>
        <a href="./worlds/fortnut.php">
            <img src="./assets/doors/fortnite.jpg" class="img-fluid mt-3 rounded" alt="Responsive image">
        </a>
    </div>

    <div class="col-md-4">
        <p class="text-center">Auctioner House</p>
        <a href="./worlds/market.php">
            <img src="./assets/doors/auction_house.jpg" class="img-fluid mt-3 rounded" alt="Responsive image">
        </a>
    </div>
</section>
<a href="./worlds/hate_wow.php" class="mt-5 mb-5 btn btn-danger btn-lg"> <i class="fa fa-door-open"></i> I hate WoW ...</a>

</body>
</html>
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

<?php


$raid = new Raid("Portal");

$item_1 = new Item("Portal Sword", 2, 1, "Critical strike", "portal_sword.jpg", "critical_strike.jpg", 0, "green", "Critical strike ! ");
$item_2 = new Item("Portal Armor", 3, 1, "Heal", "portal_armor.jpg","heal.jpg", 0, "green", "Get heal !");
$item_3 = new Item("Portal Gantlet", 1, 5, "Health bonus", "portal_gantlet.jpg","health.jpg", 0,"blue","");
$item_4 = new Item("Cool Mount", 5, 5, "Cool Boi", "portal_mount.jpg","cool_boy.jpg", 0,"purple", "You are too cool !");
$item_5 = new Item("Portal Cool Sword", 25, 2, "Damage increase", "portal_cool_sword.jpg","increase_damage.jpg", 0, "purple", "");
$item_6 = new Item("Portal helmet", 1, 10, "Tanky", "portal_helmet.jpg","tanky.jpg", 0, "blue","");
$item_7 = new Item("Portal Legging", 3, 4, "Tanky", "portal_legging.jpg","tanky.jpg", 0, "blue","");
$item_8 = new Item("Portal Necklace", 3, 3, "Heal", "portal_necklace.jpg","heal.jpg", 0, "green","Get heal !");
$item_9 = new Item("Portal Ring", 5, 1, "Health bonus", "portal_ring.jpg","health.jpg", 0, "purple", "");
$item_10 = new Item("Portal Boots", 2, 7, "Health bonus", "portal_boots.jpg","health.jpg", 0, "green", "");
$item_11 = new Item("Portal Trinket", 1, 1, "Critical strike", "portal_trinket.jpg","critical_strike.jpg", 0, "blue", "Critical strike !");
$item_12 = new Item("Portal Cloack", 3, 5, "Extra mana", "portal_cloack.jpg","extra_mana.jpg", 100, "purple", "");
$item_13 = new Item("Portal Hammer", 35, 2, "Fire damage", "portal_hammer.jpg","firing.jpg", 100,"orange", "Ragnaros : BY FIRE BE PURGED!");
$item_14 = new Item("WoW was better before",  100, 150, "Kungen > all", "portal_kungen.jpg","pet_attack.jpg", 300, "purple","WoW = casu");
$item_15 = new Item("Portal Best Sword WORLD",  200, 200, "1/2 God", "portal_very_cool_sword.jpg","thunder.jpg", 200, "orange", "Thunder strike !");
$item_16 = new Item("Portal God's mount",  10000, 10000, "Godlike", "portal_mount2.jpg","GODLIKE.jpg", 1000,"orange", "G O D");
$item_17 = new Item("Sco The Pet",  400, 400, "Sco > Kungen", "portal_sco.jpg","pet_attack.jpg", 300, "purple", "1st world G'huun.");


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


//PREPARE boss
$boss_tables  = [
    $boss1 =  new Boss("KT", "Kel'Thuzad",100, 2000,"kelthuzad.jpg", 500),
    $boss2 =  new Boss("Illidan", "Illidan",90, 1500,"illidan.jpg", 0),
    $boss3 =  new Boss("Arthas", "Arthas",250, 3000,"arthas.jpg", 0)
];

$rand = Utils::getRandom(0, sizeof($boss_tables) - 1);

// Prepare session
$_SESSION["boss"] = $boss_tables[$rand]; //init boss

//$_SESSION["current_boss"] = CharacterChar::serializeSession($_SESSION["boss"]);
//$_SESSION["current_character"] = CharacterChar::serializeSession($_SESSION["character"]);

?>

<body class="container">

<h1 class="text-center">
    Welcom in <?php echo $raid->getName(); ?> raid
</h1>


<br>

<h3 class="mt-4 mb-4">Items table - Portal Raid</h3>

<div class="row">
    <?php
    foreach ($raid->getTableItems() as $item) {
    ?>
    <div class="col-md-4">
        <div class="text-center">
            <?php
                if($item->getQuality() === "green"){ ?>
                <p style="color: limegreen;" class="mb-2 mt-2">
                    [
                        <?php echo $item->getName();?>
                    ]
                </p>
                <?php
                }?>

            <?php
            if($item->getQuality() === "blue"){ ?>
                <p style="color: royalblue;" class="mb-2 mt-2">
                    [
                    <?php echo $item->getName();?>
                    ]
                </p>
                <?php
            }?>

            <?php
            if($item->getQuality() === "purple"){ ?>
                <p style="color: rebeccapurple;" class="mb-2 mt-2">
                    [
                    <?php echo $item->getName();?>
                    ]
                </p>
                <?php
            }?>

            <?php
            if($item->getQuality() === "orange"){ ?>
                <p style="color: orange;" class="mb-2 mt-2">
                    [
                    <?php echo $item->getName();?>
                    ]
                </p>
                <?php
            }?>
            <br>
            <img class="rounded" src="<?php echo $item->getItemIconName(); ?>">
        </div>
        <div class="text-center row">
            <div class="col-md-4">
                <p>
                    <i class="fa fa-fist-raised"
                       style="color:dimgrey"></i>
                    <?php echo $item->getStatAtk() ?>
                </p>

            </div>
            <div class="col-md-4">
                <p>
                    <i class="fa fa-heart"
                       style="color:darkred"></i>
                    <?php echo $item->getStatHealth() ?>
                </p>
            </div>

            <div class="col-md-4">
                <p>
                    <i class="fa fa-gem"
                       style="color:dodgerblue"></i>
                    <?php echo $item->getStatMana() ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5 class="text-center">Buff</h5>
                <p><?php echo $item->getStatSpecial() ?></p>
                <img class="rounded" src="<?php echo $item->getStatSpecialIcon() ?>">
            </div>
        </div>
        <hr class="mt-5 mb-5">
    </div>
        <?php
    }
    ?>
</div>



<div class="mb-4">
    <a href="../start.php" class="btn btn-large">Go back</a>
    <a href="./portal_fight_scene.php" class="btn btn-success btn-lg">Start new game</a>
</div>

</body>

</html>


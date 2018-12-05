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

$item_1 = new Item("Portal Sword", 2, 1, "critical strike", "portal_sword.jpg", "critical_strike.jpg");
$item_2 = new Item("Portal Armor", 3, 1, "heal", "portal_armor.jpg","heal.jpg");
$item_3 = new Item("Portal Gantlet", 1, 5, "health bonus", "portal_gantlet.jpg","health.jpg");
$item_4 = new Item("Cool Mount", 5, 5, "Cool Boi", "portal_mount.jpg","cool_boy.jpg");
$item_5 = new Item("Portal Cool Sword", 25, 2, "Damage increase", "portal_cool_sword.jpg","increase_damage.jpg");
$item_6 = new Item("Portal helmet", 1, 10, "Tanky", "portal_helmet.jpg","tanky.jpg");
$item_7 = new Item("Portal Legging", 3, 4, "Tanky", "portal_legging.jpg","tanky.jpg");
$item_8 = new Item("Portal Necklace", 3, 3, "heal", "portal_necklace.jpg","heal.jpg");
$item_9 = new Item("Portal Ring", 5, 1, "health bonus", "portal_ring.jpg","health.jpg");
$item_10 = new Item("Portal Boots", 2, 7, "health bonus", "portal_boots.jpg","health.jpg");


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
]);

$_SESSION['raid'] = $raid;


//PREPARE boss
$boss_tables  = [
    $boss1 =  new Boss("KT", "Kel'Thuzad",100, 2,"kelthuzad.jpg", 1000),
    $boss2 =  new Boss("Illidan", "Illidan",90, 2,"illidan.jpg", 400),
    $boss3 =  new Boss("Arthas", "Arthas",250, 2,"arthas.jpg", 100)
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


<a href="./portal_fight_scene.php" class="btn btn-primary">Play</a>

<br>

<h3>Loot table - Portal Raid</h3>

<ul class="list-group">
    <?php
    foreach ($raid->getTableItems() as $item) {
        ?>
        <li class="list-group-item">
            <div class="text-center">
                <strong><?php echo $item->getName() ?></strong>
                <br>
                <img src="<?php echo $item->getItemIconName() ?>">
            </div>
            <div class="row mt-5">
                <div class="col-md-4 text-center">
                    <h6>Atk</h6>
                    <p><?php echo $item->getStatAtk() ?></p>
                </div>
                <div class="col-md-4 text-center">
                    <h6>Health</h6>
                    <?php echo $item->getStatHealth() ?>
                </div>
                <div class="col-md-4 text-center">
                        <h6>Special Bonus</h6>
                        <p><?php echo $item->getStatSpecial() ?></p>
                        <img src="<?php echo $item->getStatSpecialIcon() ?>">
                </div>
            </div>
        </li>
        <?php
    }
    ?>
</ul>

<a href="../start.php" class="btn btn-large">Go back</a>
</body>

</html>


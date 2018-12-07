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
$raid = $_SESSION['raid'];

//PREPARE boss
$boss_tables  = [
    $boss1 =  new Boss("KT", "Kel'Thuzad",100, 2500,"kelthuzad.jpg", 500, 150),
    $boss2 =  new Boss("Illidan", "Illidan",90, 2000,"illidan.jpg", 50, 90),
    $boss3 =  new Boss("Arthas", "Arthas",250, 3000,"arthas.jpg", 100, 300)
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
    <div class="col-md-2">
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
        <p class="text-center"><?php echo $item->getGold();?>g <i class="fa fa-coins" style="color:darkorange"></i></p>
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
    <a href="../start.php" class="btn btn-lg btn-primary">Go back</a>
    <a href="./portal_fight_scene.php" class="btn btn-success btn-lg">Start new game</a>
</div>

</body>

</html>


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

    var_dump($_SESSION);

    $_SESSION["attacked"] = false; //init turn false for fight scene

    $nickname = $_POST["nickname"];
    $hereo = $_POST["character_choice"];


    $character = new CharacterChar($nickname, $hereo, 5, 90000, 500);
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
    //Go back from fight scene / dead / win -> reset user hp

    // reset USER hp;
    $_SESSION["character"]->setHp($_SESSION["character"]->getBaseHp());
    //var_dump($_SESSION);
}


?>

<section class="text-center">
    <div>
        <h2>Hey, <?php echo $_SESSION["character"]->getNickname() ?> you playing
            as <?php echo $_SESSION["character"]->getHereo() ?></h2>

        <img src="<?php echo $_SESSION["character"]->getHereoPic() ?>" class="img-fluid mt-3" alt="Responsive image">
        <blockquote class="mt-3">
            <?php echo '" ' . $_SESSION["character"]->getQuotes()[$_SESSION["character"]->getHereo()][0] . ' "' ?>
        </blockquote>
    </div>
</section>

<section class="row mt-4">
    <div class="col-md-6">
        <p class="text-center">WoW > All</p>
        <a href="./worlds/portal.php">
            <img src="./assets/doors/portal.jpg" class="img-fluid mt-3" alt="Responsive image">
        </a>
    </div>
    <div class="col-md-6">
        <p class="text-center">Fortnite > WoW</p>
        <a href="./worlds/fortnut.php">
            <img src="./assets/doors/fortnite.jpg" class="img-fluid mt-3" alt="Responsive image">
        </a>
    </div>
</section>
<a href="./worlds/reset.php" class="mt-5 mb-5 btn btn-danger btn-lg"> <i class="fa fa-door-open"></i> Too weak ?</a>

</body>
</html>
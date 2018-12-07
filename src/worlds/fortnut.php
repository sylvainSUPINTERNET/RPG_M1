<?php

require_once '../../autoload.php';

session_start();

?>
<!doctype html>
<html lang="en" style="background-image: url('../assets/fortnite/kids.gif')">
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

$item_1 = new Item("PickAxe", 20, 20, "Let's BUILD", "fortnite_pickaxe.jpg", "cool_boy.jpg", 10, "purple", "+40 <i class=\"fa fa-heart\"
                                   style=\"color:darkred\"></i>");

if(isset($_POST["pickaxe"])){
    $inventory = new Inventory();
    $inventory->addItem($item_1);
    header('Location: ../start.php');
}


?>

<div class="row">
    <div class="col-md-4">
        <img src="../assets/fortnite/tenor.gif">
    </div>
    <div class="col-md-4">
        <img src="../assets/fortnite/tenor2.gif">
    </div>
    <div class="col-md-4">
        <img src="../assets/fortnite/tenor3.gif">
    </div>
</div>
<div class="row">
    <div class="col-md-4 offset-5">
        <form method="post" action="fortnut.php">
            <input type="hidden" name="pickaxe" value="getit">
            <input type="submit" value="Get epic pickaxe" class="btn btn-primary btn-lg text-center mt-3 mb-3">
        </form>
    </div>
</div>
</body>
</html>


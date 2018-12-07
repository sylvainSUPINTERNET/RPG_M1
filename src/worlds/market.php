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
    <h1 class="text-center mt-5">Auction house</h1>

    <?php if(isset($_POST['item'])){
        $itemObject = ""; // will contain object item

        foreach($_SESSION['raid']->getTableItems() as $r_item){
            if($r_item->getName() === $_POST['item']){
                $itemObject = $r_item;
                break;
            }
        }

        $_SESSION['character']->pay($itemObject, $_SESSION['inventory']);

    }?>

    <p>Your money : <?php echo $_SESSION['character']->getGold()?>g <i class="fa fa-coins" style="color:darkorange"></i></p>
        <!-- All -->
        <form method="post" action="market.php">
            <select name="item">
                <?php
                foreach($_SESSION['raid']->getTableItems() as $item):
                    if($item->getQuality() === "green"){
                        echo '<option value="'
                            .$item->getName().'">'.$item->getName(). ' - <span>' .$item->getGold() .'g - epic quality</option>'; //close your tags!!
                    } elseif($item->getQuality() === "blue"){
                        echo '<option value="'
                            .$item->getName().'">'.$item->getName(). ' - <span>' .$item->getGold().'g - rare quality</option>'; //close your tags!!
                    } elseif($item->getQuality() === "purple"){
                        echo '<option value="'
                            .$item->getName().'">'.$item->getName(). ' - <span>' .$item->getGold() .'g - epic quality</option>'; //close your tags!!
                    }elseif($item->getQuality() === "orange"){
                        echo '<option value="'
                            .$item->getName().'">'.$item->getName(). ' - <span>' .$item->getGold().'g - lengandary quality</option>'; //close your tags!!
                    }
                endforeach;
                ?>
            </select>
            <input type="submit" value="Acheter">
        </form>


<?php
    if(isset($_SESSION['inventory']) && sizeof($_SESSION['inventory']) >0){
        echo '<h4 class="mt-5">Your items</h4>';
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
    }
?>

<a href="/RPG/src/start.php" class="btn btn-primary btn-md">Go back</a>


</body>





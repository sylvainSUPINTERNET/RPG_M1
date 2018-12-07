<?php
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
</head>
<body class="container">
    <h1 class="text-center mt-3">RPG made by Joly Sylvain </h1>
    <section class="mt-4">
        <h3> List of characters</h3>

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img class="d-block w-100" src="src/assets/character/image/mdr.jpeg" alt="asmo">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Asmongod</h5>
                    </div>
                </div>

                <div class="carousel-item ">
                    <img class="d-block w-100" src="src/assets/character/image/leeroy-jenkins.jpg" alt="leeroy">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>LEEEROY</h5>
                    </div>
                </div>


            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <form method="post" class="mt-3 mb-3" action="./src/start.php">
            <div class="form-group">
                <label for="nickname">Nickname</label>
                <input type="text" class="form-control" id="nickname" placeholder="Your nickname" name="nickname" required>
            </div>

            <label for="char_select">Choose your hereo</label>

            <select id="char_select" name="character_choice">
                <option value="asmongod">AsmonGOD</option>
                <option value="leeroy">Leeroy Jenkis</option>
            </select>

            <div class="pull-right">
                <button type="submit" class="btn btn-danger btn-lg">Play</button>
            </div>
        </form>
    </section>
</body>
</html>

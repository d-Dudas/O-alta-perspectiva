<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O altă perspectivă</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Josefin+Sans:wght@500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

    <nav class="navbar">
        <a href="./index.php" class="logo">O altă perspectivă</a>
        <input type="checkbox" id="toggler">
        <label for="toggler"><i class="ri-menu-line"></i></label>
        <div id="menu">
            <ul class="list">
                <li><a href="http://localhost/O%20alta%20perspectiva/index.php">Articole</a></li>
                <?php
                    if (isset($_SESSION["useruid"])) {
                        if($_SESSION["ifadmin"] == 0) {
                            //echo "<li><a href=\"#\">Trimite articole</a></li>";
                            
                        }
                        else if ($_SESSION["ifadmin"] == 1){
                            echo "<li><a href=\"http://localhost/O%20alta%20perspectiva/adaugareArticole.php\">Creare articole</a></li>";
                            echo "<li><a href=\"http://localhost/O%20alta%20perspectiva/controlPanel.php\">Administrare</a></li>";
                        }
                        echo "<li><a href=\"./includes/logout.inc.php\">Deconectare</a></li>";
                    }
                    else {
                        echo "<li><a href=\"login.php\">Autentificare</a></li>";
                        echo "<li><a href=\"signup.php\">Înregistrare</a></li>";
                    }
                ?>
            </ul>
        </div>
        <div id="burger">
            <input type="checkbox" id="menu-toggle" value = 0 onclick=show_menu()>
            <label for="menu-toggle" class="hamburger">
                <span class="bun bun-top">
                    <span class="bun-crust bun-crust-top"></span>
                </span>
                <span class="bun bun-bottom">
                    <span class="bun-crust bun-crust-bottom"></span>
                </span>
            </label>
        </div>
    </nav>
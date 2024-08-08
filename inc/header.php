<?php

session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Sen:wght@400..800&display=swap" rel="stylesheet">
    <title>SQL TP</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <div>
                    <a href="index.php">
                        <li>Accueil</li>
                    </a>
                    <?php if (isset($_SESSION['username'])) {
                        echo "<a href='index.php?pg=dashboard'>
<li>Tableau de bord</li>
</a>";
                    }; ?>
                </div>
                <div><?php

                        if (!isset($_SESSION['username'])) {
                            echo   "<a href='index.php?pg=register'>
                <li>Inscription</li>
            </a>";
                        };

                        if (!isset($_SESSION['username'])) {
                            echo   "<a href='index.php?pg=login'>
                <li>Connexion</li>
            </a>";
                        };
                        if (isset($_SESSION['username'])) {

                            echo "<a href='index.php?pg=logout'>
                <li>Deconnexion</li>
            </a>";
                        } ?></div>
            </ul>
        </nav>
    </header>
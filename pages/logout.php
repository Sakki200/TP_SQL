<?php
session_start();

$_SESSION['logout'] = "Déconnexion réussie !";

//Redirection vers la page d'accueil
header("Location: /index.php");

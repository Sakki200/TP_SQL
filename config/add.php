<?php
session_start();
require_once './config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['user']);
    $password = htmlspecialchars($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);


    try {

        //Connexion à MySQL
        $connexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Requête SQL d'insertion
        $sql = 'INSERT INTO ' . DB_TABLE_USERS . ' (username, password) VALUES (?, ?)';

        // Préparation de la requête
        $stmt = $connexion->prepare($sql);

        // Liaison des paramètres
        $stmt->bind_param('ss', $username, $password);

        // Exécution de la requête
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;

            // Fermeture du statement et de la connexion
            $stmt->close();
            mysqli_close($connexion);

            header('Location: /index.php?pg=dashboard');
            exit();
        } else {
            echo "Erreur survenue lors l'insertion de données : " . $stmt->errno;
        }
        // Fermeture de la requête préparer et de la connexion
        $stmt->close();
        $connection = null;
    } catch (Exception $e) {
        echo  'Une erreur est survenue dans le fichier ' . $e->getFile();
        echo  ' à la ligne ' . $e->getLine() . "<br>";
        echo  'Message correspondant à votre erreur ' . $e->getMessage();
    }
}

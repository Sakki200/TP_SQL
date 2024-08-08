<?php
session_start();
require_once './config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_SESSION['username']);
    $content = htmlspecialchars($_POST['content']);

    try {
        //Connexion à MySQL
        $connexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $sql = 'SELECT * FROM ' . DB_TABLE_USERS . ' WHERE username = ?';

        $stmt = $connexion->prepare($sql);
        $stmt->bind_param('s', $username);

        // Exécution de la requête
        $stmt->execute();
        $resultat = $stmt->get_result();

        // Vérification des résultats
        if ($resultat->num_rows > 0) {
            // Comme un seul résultat possible, on récupère la ligne entière du résultat de $username
            $row = $resultat->fetch_assoc();

            $userID = $row['id'];
        } else {
            echo "Aucun utilisateur trouvé";
        }

        // Fermeture de la requête préparer et de la connexion
        $stmt->close();
        $connection = null;
    } catch (Exception $e) {
        echo  'Une erreur est survenue dans le fichier ' . $e->getFile();
        echo  ' à la ligne ' . $e->getLine() . "<br>";
        echo  'Message correspondant à votre erreur ' . $e->getMessage();
    }

    try {
        //Connexion à MySQL
        $connexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Requête SQL d'insertion
        $sql = 'INSERT INTO ' . DB_TABLE_POSTS . ' (content, user_id) VALUES (?, ?)';

        // Préparation de la requête
        $stmt = $connexion->prepare($sql);

        // Liaison des paramètres
        $stmt->bind_param('ss', $content, $userID);

        // Exécution de la requête
        if ($stmt->execute()) {
            $_SESSION['post'] = "Article bien envoyé !";

            // Fermeture du statement et de la connexion
            $stmt->close();
            mysqli_close($connexion);

            header('Location: /index.php?pg=dashboard');
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

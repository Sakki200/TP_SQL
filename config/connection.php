<?php
session_start();
require_once('./config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['user']);
    $password = htmlspecialchars($_POST['password']);


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

            // On vérifie le mot de passe POST ainsi que celui de la ligne de $username
            if (password_verify($password, $row['password'])) {
                // Initialiser les variables de session si le mot de passe est correct
                $_SESSION['username'] = $row['username'];

                // Fermeture du statement et de la connexion
                $stmt->close();
                mysqli_close($connexion);

                header('Location: /index.php?pg=dashboard');
                exit();
            } else {
                echo "Mot de passe incorrect";
            }
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
}

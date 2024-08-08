<h1>ACCUEIL</h1>
<?php
require_once './config/config.php';
if (isset($_SESSION['logout'])) {

    $logout_message = $_SESSION['logout'];

    // Detruire les variables de sessions (session toujours existante)
    session_unset();

    // Destruction de la session
    session_destroy();

    // REFRESH
    header("Refresh:0");
};

// Afficher le message de déconnexion s'il existe
$logout_message = $logout_message ??= "";
echo "<p>" . $logout_message . "<p>";

?>

<main>

    <section class="homePosts">

        <?php

        try {
            //Connexion à MySQL
            $connexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // Requête SQL d'insertion
            $sql = 'SELECT * FROM ' . DB_TABLE_POSTS . ' ORDER BY created_at desc LIMIT 6  ';

            // Préparation de la requête
            $stmt = $connexion->prepare($sql);

            // Exécution de la requête
            $stmt->execute();
            $resultat = $stmt->get_result();

            // Vérification des résultats
            if ($resultat->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($resultat)) {

                    try {
                        //Connexion à MySQL
                        $connexion2 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                        $sql2 = 'SELECT * FROM ' . DB_TABLE_USERS . ' WHERE id = ?';

                        $stmt2 = $connexion2->prepare($sql2);
                        $stmt2->bind_param('i', $row['user_id']);

                        // Exécution de la requête
                        $stmt2->execute();
                        $resultat2 = $stmt2->get_result();

                        // Vérification des résultats
                        if ($resultat2->num_rows > 0) {
                            // Comme un seul résultat possible, on récupère la ligne entière du résultat de $username
                            $rowID = $resultat2->fetch_assoc();

                            $username = $rowID['username'];
                        } else {
                            echo "Aucun utilisateur trouvé";
                        }

                        // Fermeture de la requête préparer et de la connexion
                        $stmt2->close();
                        $connection2 = null;
                    } catch (Exception $e) {
                        echo  'Une erreur est survenue dans le fichier ' . $e->getFile();
                        echo  ' à la ligne ' . $e->getLine() . "<br>";
                        echo  'Message correspondant à votre erreur ' . $e->getMessage();
                    };

                    echo "<article><h3>Author : " . ucfirst($username) . "</h3><h4>Content :</h4><p>" . $row["content"] . "</p><h5>Created at : " . $row["created_at"] . "</h5></article>";
                }
            }
            // Fermeture de la requête préparer et de la connexion
            $stmt->close();
            $connection = null;
        } catch (Exception $e) {
            echo  'Une erreur est survenue dans le fichier ' . $e->getFile();
            echo  ' à la ligne ' . $e->getLine() . "<br>";
            echo  'Message correspondant à votre erreur ' . $e->getMessage();
        } ?>

    </section>



</main>
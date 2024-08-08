<?php
require_once './config/config.php';
if (isset($_SESSION['post'])) {
    $message = $_SESSION['post'];
};
?>

<h1>TABLEAU DE BORD</h1>
<main>
    <?php echo "<h2>Bienvenue " . ucfirst($_SESSION['username']) . "</h2>" ?>

    <?php if (isset($message)) {
        echo "<p class='postMessage'>" . $message . "</p>";
    } ?>

    <div class="dashboard">
        <section class="addPost">
            <h3>POSTEZ VOTRE ARTICLE</h3>
            <form action="./config/create_post.php" method="POST">
                <p>
                    <label for="content">Contenu :</label></br>
                    <textarea id="content" name="content"></textarea>
                </p>
                <button type="submit">ENVOYER</button>
            </form>
        </section>
        <section class="showPosts">
            <h3>TOUS NOS ARTICLES</h3>
            <div>

                <?php

                try {
                    //Connexion à MySQL
                    $connexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                    // Requête SQL d'insertion
                    $sql = 'SELECT * FROM ' . DB_TABLE_POSTS . ' ORDER BY created_at desc LIMIT 50';

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

                                $sql2 = 'SELECT * FROM ' . DB_TABLE_USERS . ' WHERE id = ? ';

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

                            echo "<article><h3>Author : " . $username . "</h3><h4>Content :</h4><p>" . $row["content"] . "</p><h5>Created at : " . $row["created_at"] . "</h5></article>";
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
            </div>
        </section>
    </div>
</main>
<h1>CONNEXION</h1>
<main>
    <form class="connexion" action="./config/connection.php" method="POST">
        <div>
            <p>
                <label for="user">Utilisateur :</label></br>
                <input type="text" id="user" name="user">
            </p>
            <p>
                <label for="password">Mot de passe :</label></br>
                <input type="password" id="password" name="password">
            </p>
            <input type="hidden" name='hidden' value="<?php echo date('d/m/Y H:i:s'); ?>">
            <button type="submit">ENVOYEZ</button>
            <p>
                Pas encore inscrit ? : <a href="index.php?pg=register"> Inscrivez-vous</a>
            </p>
        </div>
    </form>
</main>
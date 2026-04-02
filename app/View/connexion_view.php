<main class="content">
    <div class="flex">
        <!-- Formulaire de connexion -->
        <div class="box">
            <div class="form" action="login" method="post" >
                <h1>Connexion</h1>
                <div class="form-group">
                    <label for="email">Email : </label><br>
                    <input type="email" name="email" id="email"
                        value=<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                                if (!isset($Login->errors["email"])) {
                                    echo $_POST["email"] ?? '';
                                } else {
                                    echo '';
                                }; ?>>
                    <?php if (isset($Login->errors['email'])) echo ("<br><span class='error'>" . $Login->errors['email'] . "</span>"); ?>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe : </label><br>
                    <input type="password" name="password" id="password">
                    <?php if (isset($Login->errors["password"])) echo ("<br><span class='error'>" . $Login->errors["password"] . "</span>"); ?>
                </div>
                <a class="blue-link" href="?action=register">Vous n'avez pas de compte ?</a>
                <p><input type="submit" class="button" value="Enregister"></p>
            </div>
        </div>
        <!---->
    </div>
</main>
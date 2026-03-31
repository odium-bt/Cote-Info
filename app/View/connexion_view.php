<main class="content">
    <!-- Formulaire de connexion -->
    <div class="form-group" action="login" method="post">
        <p>
            <label for="email">Email : </label>
            <input type="text" name="email" id="email"
                value=<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                        if (!isset($Login->errors["email"])) {
                            echo $_POST["email"] ?? '';
                        } else {
                            echo '';
                        }; ?>>
            <?php if (isset($Login->errors['email'])) echo ("<br><span class='error'>" . $Login->errors['email'] . "</span>"); ?>
        </p>
        <p>
            <label for="price">Mot de passe : </label>
            <input type="password" name="password" id="password">
            <?php if (isset($Login->errors["password"])) echo ("<br><span class='error'>" . $Login->errors["password"] . "</span>"); ?>
        </p>
        <p><input type="submit" class="button" value="Enregister"></p>
</div>
</main>
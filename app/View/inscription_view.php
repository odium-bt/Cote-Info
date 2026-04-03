<main class="content">
    <div class="flex">
        <!-- Formulaire de connexion -->
        <div class="box">
            <form class="form" action="?action=register" method="post">
                <h1>Inscription</h1>

                <div class="form-group">
                    <label for="username">Nom d'utilisateur : </label><br>
                    <input type="text" name="username" id="username"
                        value="<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                                if (!isset($this->errors["username"])) {
                                    echo $_POST["username"] ?? '';
                                } else {
                                    echo '';
                                }; ?>" required>
                    <?php if (isset($this->errors['username'])) echo ("<br><span class='error'>" . $this->errors['username'] . "</span>"); ?>
                </div>

                <div class="form-group">
                    <label for="email">Email : </label><br>
                    <input type="text" name="email" id="email"
                        value="<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                                if (!isset($this->errors["email"])) {
                                    echo $_POST["email"] ?? '';
                                } else {
                                    echo '';
                                }; ?>" required>
                    <?php if (isset($this->errors['email'])) echo ("<br><span class='error'>" . $this->errors['email'] . "</span>"); ?>
                </div>

                <div class="form-group">
                    <label for="email-confirm">Confirmez votre email : </label><br>
                    <input type="text" name="email-confirm" id="email-confirm"
                        value="<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                                if (!isset($this->errors["email-confirm"])) {
                                    echo $_POST["email-confirm"] ?? '';
                                } else {
                                    echo '';
                                }; ?>" required>
                    <?php if (isset($this->errors['email-confirm'])) echo ("<br><span class='error'>" . $this->errors['email-confirm'] . "</span>"); ?>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe : </label><br>
                    <input type="password" name="password" id="password" required>
                    <?php if (isset($this->errors["password"])) echo ("<br><span class='error'>" . $this->errors["password"] . "</span>"); ?>
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirmez votre mot de passe : </label><br>
                    <input type="password" name="password-confirm" id="password-confirm" required>
                    <?php if (isset($this->errors["password-confirm"])) echo ("<br><span class='error'>" . $this->errors["password-confirm"] . "</span>"); ?>
                </div>

                <a class="blue-link" href="?action=login">Vous avez déjà un compte ?</a>

                <p>
                    <input type="submit" class="button" value="Valider">
                </p>
            </form>
        </div>
        <!---->
    </div>
</main>
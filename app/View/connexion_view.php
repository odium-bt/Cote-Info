<main class="content">
    <div class="flex">
        <!-- Formulaire de connexion -->
        <div class="box">
            <form class="form" action="?action=login" method="post">
                <h1>Connexion</h1>

                <p><?php if (isset($this->errors["failure"])) echo ("<span class='error'>" . $this->errors["failure"] . "</span>"); ?></p>

                <div class="form-group">
                    <label for="email">Email : </label><br>
                    <input type="email" name="email" id="email"
                        value="<?php echo $_POST["email"] ?? ''; ?>" required>
                    <?php if (isset($this->errors['email'])) echo ("<br><span class='error'>" . $this->errors['email'] . "</span>"); ?>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe : </label><br>
                    <input type="password" name="password" id="password" required>
                    <?php if (isset($this->errors["password"])) echo ("<br><span class='error'>" . $this->errors["password"] . "</span>"); ?>
                </div>
                <a class="blue-link" href="?action=register">Vous n'avez pas de compte ?</a>
                <p><input type="submit" class="button" value="Enregister"></p>
</form>
        </div>
        <!---->
    </div>
</main>
<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content">
    <div class="flex justify-center">
        <!-- Formulaire de contact -->
        <div class="box">
            <form id="contact" class="form" action="?action=contact" method="post">
                <h1>Contact</h1>

                <div class="form-group">
                    <label for="name">Nom : </label><br>
                    <input type="text" name="name" id="name"
                        value="<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                                if (!isset($this->errors["name"])) {
                                    echo $_POST["name"] ?? '';
                                } else {
                                    echo '';
                                }; ?>" required>
                    <?php if (isset($this->errors['name'])) echo ("<br><span class='error'>" . $this->errors['name'] . "</span>"); ?>
                </div>

                <div class="form-group">
                    <label for="email">Email : </label><br>
                    <input type="email" name="email" id="email"
                        value="<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                                if (!isset($this->errors["email"])) {
                                    echo $_POST["email"] ?? '';
                                } else {
                                    echo '';
                                }; ?>" required>
                    <?php if (isset($this->errors['email'])) echo ("<br><span class='error'>" . $this->errors['email'] . "</span>"); ?>
                </div>

                <div class="form-group">
                    <label for="object">Sujet : </label><br>
                    <input type="text" name="object" id="object"
                        value="<?php // Garde la valeur si pas d'erreurs, efface si il y en a
                                if (!isset($this->errors["object"])) {
                                    echo $_POST["object"] ?? '';
                                } else {
                                    echo '';
                                }; ?>" required>
                    <?php if (isset($this->errors['object'])) echo ("<br><span class='error'>" . $this->errors['object'] . "</span>"); ?>
                </div>

                <div class="form-group">
                    <label for="message">Message : </label><br>
                    <textarea type="message" name="message" id="message" required></textarea>
                    <?php if (isset($this->errors["message"])) echo ("<br><span class='error'>" . $this->errors["message"] . "</span>"); ?>
                </div>

                <div class="form-group form__checkbox">
                    <input type="checkbox" name="rgpd" id="rgpd" required><label for="rgpd"> J'accepte la <a class="blue-link" href="?action=policy">Politique de Confidentialité</a>.</label>
                    <?php if (isset($this->errors["rgpd"])) echo ("<br><span class='error'>" . $this->errors["rgpd"] . "</span>"); ?>
                </div>

                <div class="submit">
                    <input type="submit" class="button" value="Enregistrer">
                </div>
            </form>
        </div>
        <!---->
    </div>
</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>
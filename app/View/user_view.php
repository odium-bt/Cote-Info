<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content flex">
    <aside class="box">
        <nav>
            <ul>
                <li><a href="?action=user&tab=user">Profil</a></li>
                <li><a href="?action=user&tab=account">Compte</a></li>
                <li><a href="?action=user&tab=comments">Mes&nbsp;commentaires</a></li>
                <li><a href="?action=user&tab=notes">Mes&nbsp;notes</a></li>
                <li><a href="?action=user&tab=settings ">Préférences</a></li>
                <?php if ($this->isAdmin === true) {
                ?>
                    <li><a href="?action=user&tab=articles">Mes&nbsp;articles</a></li>
                    <li><a href="?action=user&tab=reports">Commentaires&nbsp;signalés</a></li>
                <?php
                } ?>
            </ul>
        </nav>
    </aside>

    <div class="box padding-50">
        <h2 class="titre">Mon profil</h2>
        <div class="profil">
            <img src="<?= ROOT . "/public/images/avatars/" . $this->user['avatar'] ?>" alt="Ton avatar"><br>
            <form action="?action=user">
                <label for="new-avatar">Modification de votre photo de profil : </label><input name="new-avatar" type="file">
                <input class="button" type="submit">
            </form>
            <h3><?= $this->user['username'] ?></h3>
        </div>

        <p>Date de création du compte : <?= $this->user['date_'] ?></p>
        <a href="?action=logout">
            <div class="button red">Déconnexion</div>
        </a>
        <div class="button red">Suppression du compte</div>
    </div>


</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>
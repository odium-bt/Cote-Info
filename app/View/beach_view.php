<main class="content">
    <!-- == Article == -->
    <article>
        <!-- h1 -->
        <h1><?= $this->beach['label'] ?></h1>
        <!-- div -->
        <div>
            <!-- météo -->
            // api météo
            <!-- slider photos -->
            <div>
                // slider photos

                <div id="slider">
                    <button class="left"><-< /button>
                            <div class="slide active" data-index="0"></div>
                            <div class="slide hidden" data-index="1"></div>
                            <div class="slide hidden" data-index="2"></div>

                            <?php
                            var_dump($medias);
                            // foreach ($this->$medias as $key => $value)
                            ?>



                            <button class="right">-></button>
                </div>



            </div>
            <!-- description -->
            <p><?= $this->beach['description'] ?></p>
        </div>
    </article>
    <!-- == Side bar == -->
    <!-- aside -->
    <aside>
        foreach
        <!-- div -->
        <!-- thumbnail -->
        <!-- h3 -->
    </aside>


    <!-- == Commentaires == -->
    <div class="box">
        <!-- +++ If logged in : -->
        <form id="newcomment" action="?action=beach&id=<?= $this->id ?>" method="post">
            <h6>Envoyez un commentaire</h6>
            <input type="textarea">
            <input type="submit" class="button" value="Envoyer">
        </form>
        <!-- +++ -->
        <?php
        if (empty($this->comments)) {
        ?>
            <p>Il n'y a aucun commentaire ici pour l'instant...</p>
            <?php } else {
            foreach ($this->comments as $key => $value) {
            ?>
                <!-- section -->
                <div>
                    <!-- avatar, nom, date, contenu, note -->
                    <div class=" comment_author">
                        <img class="avatar" src="<?= $value['author']['avatar'] ?>">
                        <p><?= $value['author']['username'] ?></p>
                        <p><?= $value['date_'] ?></p>
                    </div>
                    <div class="comment_content"><?= $value['content'] ?></div>
                </div>
        <?php }
        }; ?>
    </div>
</main>
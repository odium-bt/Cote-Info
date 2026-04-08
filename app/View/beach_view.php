<main class="content">
    <div class="flex between">
        <div class="beach_article">
            <!-- == Article == -->
            <article class="info box">


                <!-- Titre -->
                <h1 class="titre"><?= $this->beach['label'] ?></h1>

                <!-- météo -->
                // api météo

                <!-- slider photos -->
                <div id="slider">
                    <button class="left">
                        < </button>
                            <?php
                            $index = 0;
                            $class = "active";
                            foreach ($this->medias as $key => $media) {
                            ?>
                                <div class="slide <?= $class ?>" data-index="<?= $index ?>">
                                    <img src="./public/images/beach/<?= $media['path'] ?>" alt="<?= $media['alt'] ?>">
                                    <p class="legend"><?= $media['legend'] ?></p>
                                </div>
                            <?php
                                $index += 1;
                                $class = "hidden";
                            };
                            ?>
                            <button class="right">>
                            </button>
                </div>
                <!--  -->


                <!-- description -->
                <section class="description">
                    <p><?= $this->beach['description'] ?></p>
                </section>


            </article>

            <!-- == Commentaires == -->
            <div class="comments box">
                <!-- +++ If logged in : -->
                <form id="comment_write" action="?action=beach&id=<?= $this->id ?>" method="post">
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
                            <div class="comment_author">
                                <img class="avatar" src="<?= $value['author']['avatar'] ?>">
                                <p><?= $value['author']['username'] ?></p>
                                <p><?= $value['date_'] ?></p>
                            </div>
                            <div class="comment_content"><?= $value['content'] ?></div>
                        </div>
                <?php }
                }; ?>
            </div>
        </div>
        <!-- == Side bar == -->
        <!-- aside -->
        <aside class="side_bar">
            <?php
            foreach ($this->articles as $article) {
            ?>
                <div class="news_article box">
                    <img src="./public/images/beach/<?= $article['thumbnail']['path'] ?>" alt="<?= $article['thumbnail']['alt'] ?>">
                    <h6><?= $article['title'] ?></h6>
                </div>
            <?php
            }
            ?>
            <!-- div -->
            <!-- thumbnail -->
            <!-- h3 -->
        </aside>
    </div>

</main>
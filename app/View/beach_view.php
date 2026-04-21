<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content">
    <div id="station" class="flex">
        <div class="beach_article">
            <!-- == Article == -->
            <article class="info box padding-30 margin-bottom-30">


                <div class="beach_header margin-bottom-30">
                    <!-- Titre -->
                    <h1><?= $this->beach['label'] ?></h1>
                    <!-- Note -->
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <a href="?action=login">
                            <div class="rating" id="rating">
                                <button type="submit" name="note" value="1"><i class="fa-regular fa-star" data-value="1"></i></button>
                                <button type="submit" name="note" value="2"><i class="fa-regular fa-star" data-value="2"></i></button>
                                <button type="submit" name="note" value="3"><i class="fa-regular fa-star" data-value="3"></i></button>
                                <button type="submit" name="note" value="4"><i class="fa-regular fa-star" data-value="4"></i></button>
                                <button type="submit" name="note" value="5"><i class="fa-regular fa-star" data-value="5"></i></button>
                            </div>
                        </a>
                    <?php } else { ?>
                        <div class="rating" id="rating">
                            <form action="?action=station&id=<?= $this->id ?>" method="post">
                                <button type="submit" name="note" value="1"><i class="fa-regular fa-star" data-value="1"></i></button>
                                <button type="submit" name="note" value="2"><i class="fa-regular fa-star" data-value="2"></i></button>
                                <button type="submit" name="note" value="3"><i class="fa-regular fa-star" data-value="3"></i></button>
                                <button type="submit" name="note" value="4"><i class="fa-regular fa-star" data-value="4"></i></button>
                                <button type="submit" name="note" value="5"><i class="fa-regular fa-star" data-value="5"></i></button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <!-- météo -->
                <div class="weather">
                    <div class="weather-card box padding-30">
                        <div class="weather_card__main">
                            <div id="temp"></div>
                            <div id="temp_graph"></div>
                            <div class="stats">
                                <div class="stat">☀️ UV <strong><span id="uv"></span></strong></div>
                                <div class="stat">💨 Vent <strong><span id="wind"></span></strong></div>
                                <div class="stat">🌧️ Risque de pluie <strong><span id="rain"></span></strong></div>
                                <div class="stat">☁️ Nuages <strong><span id="cloud"></span></strong></div>
                            </div>
                        </div>
                    </div>
                    <p id="error-msg"></p>
                    <p class="credit"><a class="blue-link" href="https://open-meteo.com/">Open-Meteo</a> est licensée sous <a class="blue-link" href="https://creativecommons.org/licenses/by/4.0/">CC&nbsp;BY&nbsp;4.0</a>.</p>
                </div>

                <!-- slider photos -->
                <?php if (!empty($this->medias)) { ?>
                    <div id="slider">
                        <button class="left">
                            < </button>
                                <?php
                                $index = 0;
                                $class = "active";
                                foreach ($this->medias as $key => $media) {
                                ?>
                                    <div class="slide <?= $class ?>" data-index="<?= $index ?>">

                                        <?php
                                        if (str_starts_with($media['MIME_type'], 'image/')) {
                                        ?>

                                            <img src="./public/images/beach/<?= $media['path'] ?>" loading="lazy" alt="<?= $media['alt'] ?>">
                                            <p class="legend"><?= $media['legend'] ?></p>
                                        <?php
                                        } elseif (str_starts_with($media['MIME_type'], 'video/')) {
                                        ?>
                                            <video loading="lazy" controls>
                                                <source src="./public/images/beach/<?= $media['path'] ?>.webm" type="video/webm">
                                                <source src="./public/images/beach/<?= $media['path'] ?>.mp4" type="video/mp4">
                                                Votre navigateur ne supporte pas les vidéos.
                                            </video>
                                        <?php
                                        };
                                        ?>

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
                <?php }; ?>

                <!-- description -->
                <section class="description">
                    <p><?= $this->beach['description'] ?></p>
                </section>


            </article>

            <!-- == Section commentaires == -->
            <section class="comments box padding-30 margin-bottom-30">
                <h3 class="margin-bottom-30">Commentaires</h3>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <form class="comment_write margin-bottom-30 padding-30 box" action="?action=station&id=<?= $this->id ?>" method="post">
                        <h6>Envoyer un commentaire :</h6>
                        <textarea id="comment_content" name="comment_content" class="margin-bottom-30"></textarea>
                        <input type="submit" class="button" value="Envoyer">
                    </form>
                <?php } else {
                ?>
                    <p class="comments__login"><a class="blue-link" href="?action=login">Connectez-vous</a> pour envoyer des commentaires.</p>
                <?php
                } ?>
                <!--  -->
                <?php
                if (empty($this->comments)) {
                ?>
                    <p>Il n'y a aucun commentaire ici pour l'instant...</p>
                    <?php } else {
                    foreach ($this->comments as $comment) {
                    ?>
                        <!-- section -->
                        <div class="comment box padding-10">
                            <!-- avatar, nom, date, contenu, note -->
                            <div class="comment__info">
                                <div class="comment__info__author">
                                    <img class="avatar padding-10" src="./public/images/avatars/<?= $comment['author']['avatar'] ?>" onerror="this.onerror=null; this.src='./public/images/avatars/default.png';">
                                    <p class="padding-10"><?= $comment['author']['username'] ?></p>
                                </div>
                                <div class="comment__info__note">
                                    <?php
                                    // Si l'utilisateur a mis une note, affiche des étoiles remplies ou non selon sa note
                                    if ($comment['note'] !== null) {
                                        for ($i = 1; $i <= 5; $i++):
                                    ?>
                                            <i class="<?= ($i <= $comment['note']) ? 'fa-solid' : 'fa-regular' ?> fa-star"></i>
                                    <?php
                                        endfor;
                                    };
                                    ?>
                                </div>
                                <p class="padding-10"><?= $comment['date_'] ?></p>
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <div>
                                        <?php if ($_SESSION['is_admin'] === false && intval($comment['id_user']) !== $_SESSION['user_id']) { ?>
                                            <a href="?action=station&id=<?= $this->id ?>&report=<?= $comment['id_comment'] ?>"><i class="fa-solid fa-flag"></i></a>
                                        <?php }; ?>
                                        <?php
                                        if (intval($comment['id_user']) === $_SESSION['user_id'] || $_SESSION['is_admin'] === true) { ?>
                                            <a href="?action=station&id=<?= $this->id ?>&delete=<?= $comment['id_comment'] ?>"><button id="delete"><i class="fa-solid fa-trash"></i></button></a>
                                        <?php }; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="comment__content padding-10">
                                <p><?= $comment['content'] ?></p>
                            </div>
                        </div>
                <?php }
                }; ?>
            </section>
        </div>
        <!-- == Side bar == -->
        <!-- aside -->
        <aside class="side_bar">
            <?php
            foreach ($this->articles as $article) {
            ?>
                <a href="?action=news&id=<?= $article['id_news'] ?>">
                    <div class="news_article beach_preview box">
                        <img src="./public/images/beach/<?= $article['thumbnail']['path'] ?>" loading="lazy" alt="<?= $article['thumbnail']['alt'] ?>">
                        <div class="news_article__title">
                            <h6><?= $article['title'] ?></h6>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
            <!-- div -->
            <!-- thumbnail -->
            <!-- h3 -->
        </aside>
    </div>

</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>
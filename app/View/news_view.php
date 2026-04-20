<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content">
    <div class="flex justify-center">

        <article class="padding-50 box">
            <h1>Actualités</h1>
            <?php if (isset($_SESSION['user_id']) && $this->isAdmin() === true) { ?>
                <a href="?action=write">
                    <div class="button">Nouveau</div>
                </a>
            <?php     } ?>
            <div class="news_list">
                <?php
                foreach ($this->articles as $article) {
                ?>
                    <a href="?action=news&id=<?= $article['id_news'] ?>">
                        <div class="news_article box">
                            <img src="./public/images/beach/<?= $article['thumbnail']['path'] ?>" alt="<?= $article['thumbnail']['alt'] ?>">
                            <div class="news_article__title">
                                <h6 title="<?= $article['title'] ?>">
                                    <?php
                                    if (strlen($article['title']) > 40) {
                                        echo substr($article['title'], 0, 40) . "...";
                                    } else {
                                        echo $article['title'];
                                    } ?></h6>
                            </div>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>
        </article>

    </div>
</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>
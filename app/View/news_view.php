<main class="content">
    <div class="flex center">

        <article class="padding-50 box">
            <h1 class="titre">Actualités</h1>
            <div class="news_list">
                <?php
                foreach ($this->articles as $article) {
                ?>
                    <a href="?action=news&id=<?= $article['id_news'] ?>">
                        <div class="news_article box">
                            <img src="./public/images/beach/<?= $article['thumbnail']['path'] ?>" alt="<?= $article['thumbnail']['alt'] ?>">
                            <div class="news_article__title">
                                <h6><?= $article['title'] ?></h6>
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
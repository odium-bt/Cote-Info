<main class="content">
    <div class="flex center">

        <article id="news_list" class="box">
            <h1 class="titre">Actualités</h1>

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
        </article>

    </div>
</main>
<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content">
    <div class="flex justify-center">

        <article class="article_news padding-50 box">

            <h1 class="titre"><?= $this->article['title'] ?></h1>
            <?= $this->article['content'] ?>
        </article>

    </div>
</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>
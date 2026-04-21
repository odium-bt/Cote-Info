<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content">
    <div class="flex justify-center">

        <article class="article_news padding-50 box">
            <h1><?= $this->currentArticle['title'] ?></h1>
            <?= $this->currentArticle['content'] ?>

            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) { ?>
                <a class="bottom-left" href="?action=news&delete=<?= $_GET['id'] ?>" title="Supprimer l'article"><i class="fa-solid fa-trash"></i></a>
            <?php } ?>
        </article>

    </div>
</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>
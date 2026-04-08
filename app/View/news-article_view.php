<main class="content">
    <div class="flex center">

        <article id="news_list" class="box">
            <h1 class="titre"><?= 'placeholder' ?></h1>
            <section>
                <?php
                for ($i = 0; $i < sizeof($article['content']); $i++) {
                ?>
                    <p><?= $this->article['content'][$i] ?></p>
                <?php
                } ?>
            </section>
        </article>

    </div>
</main>
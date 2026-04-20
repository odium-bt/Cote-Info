 <h2 class="margin-bottom-30">Mes articles</h2>

 <?php
    $articles = $this->getArticles();
    if (empty($articles)) {
    ?> <p class="padding-30">Vous n'avez pas encore rédigé d'article. Les articles que vous rédigez apparaîtront ici.</p>
 <?php }
    ?>

 <div class="news_list">
     <?php
        foreach ($articles as $article) {
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
<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\NewsModel;
/*
 * Classe NewsArticle
 * Gère les pages des articles
 */

class NewsArticle
{
    protected int $id;
    protected array $article = [];

    public function __construct()
    {
        $this->id = $_GET["id"];
        $newsModel = new NewsModel;
        $this->article = $newsModel->getById($this->id) ?? [];

        require ROOT . "/app/View/news-article_view.php";
        require ROOT . "/app/View/footer_view.php";
    }
}

<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\NewsModel;
/*
 * Classe News
 * Gère la page des actualités
 * Requête à la base de données :
 *  - liste des articles
 *  - rangés par ordre chronologique
 *  - 50 sont affichés à la fois
 *  - option pour afficher les 50 prochains
 *  - filtre par région
 */

class News
{
    protected array $articles = [];

    public function __construct()
    {
        $newsModel = new NewsModel;
        $this->articles = $newsModel->getAll() ?? [];

        var_dump($this->articles);
        require ROOT . "/app/View/news_view.php";
    }
}

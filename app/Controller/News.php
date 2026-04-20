<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\NewsModel;
use CoteInfo\Model\UserModel;
/*
 * Classe News
 * Gère la page des actualités
 * Requête à la base de données une liste des articles
 */

class News
{
    protected array $articles = [];

    public function __construct()
    {
        $newsModel = new NewsModel;
        $this->articles = $newsModel->getAll() ?? [];
        $this->articles = $newsModel->getThumbnails($this->articles) ?? [];

        // Range les articles par ordre décroissant chronologique
        usort($this->articles, function ($a, $b) {
            return strtotime($b['date_']) - strtotime($a['date_']);
        });

        require ROOT . "/app/View/news_view.php";
    }


    /*
     * Fonction isAdmin
     * paramètre : /
     * résultat : check le statut admin de l'utilisateur
     */
    protected function isAdmin()
    {
        $userMdl = new UserModel;
        $isAdmin = $userMdl->isAdmin($_SESSION['user_id']);
        if ($isAdmin === true) {
            $_SESSION['is_admin'] = true;
        } else {
            $_SESSION['is_admin'] = false;
        }
        return $isAdmin;
    }
}

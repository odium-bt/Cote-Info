<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\NewsModel;
use CoteInfo\Model\MediaModel;
use CoteInfo\Model\UserModel;
/*
 * Classe News
 * Gère la page des actualités
 * Requête à la base de données une liste des articles
 */

class News
{
    protected array $errors = [];

    protected array $articles = [];


    protected array $currentArticle = [];


    public function __construct()
    {
        $newsModel = new NewsModel;
        $mediaModel = new MediaModel;
        if (isset($_GET['delete'])) {
            if ($_SESSION['is_admin'] === true) {
                $newsModel->delete($_GET['delete']);
            } else {
                $this->errors['admin'] = "Vous n'êtes pas autorisé à supprimer un article.";
            }
        }

        $this->articles = $newsModel->getAll() ?? [];
        $this->articles = $mediaModel->getThumbnails($this->articles) ?? [];

        // Range les articles par ordre décroissant chronologique
        usort($this->articles, function ($a, $b) {
            return strtotime($b['date_']) - strtotime($a['date_']);
        });




        $view = ROOT . "/app/View/news_view.php";

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $newsModel = new NewsModel;
            $this->currentArticle = $newsModel->getById($id) ?? [];
            if (!empty($this->currentArticle)) {
                $view = ROOT . "/app/View/news-article_view.php";
            }
        }

        require $view;
    }


    /*
     * Fonction isAdmin
     * paramètre : /
     * résultat : check le statut admin de l'utilisateur
     */
    protected function isAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $userMdl = new UserModel;
        return $userMdl->isCurrentAdmin();
    }
}

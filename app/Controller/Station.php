<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\StationsModel;
use CoteInfo\Model\CommentsModel;
/*
 * Classe Station
 * Gère les articles des stations balnéaires
 * Eléments : infos station, médias, articles, commentaires
 */

class Station
{
    protected $id;
    protected array $beach;

    protected array $medias;


    protected array $comments;
    protected int $note;

    protected array $articles;

    protected string $newComment;

    public function __construct()
    {
        $this->id = $_GET['id'];
        $stationsMdl = new StationsModel($this->id);

        // Récupère de ma base les données à afficher dans l'article Station
        $this->beach = $stationsMdl->getBeach();
        $this->medias =  $stationsMdl->getMedia();
        $this->comments = $stationsMdl->getCommentsWithAuthors();
        $this->articles = $stationsMdl->getArticlePreviews();

        // Gestion d'envois de commentaires
        if (!empty($_POST) && isset($_SESSION['user_id'])) {

            $this->newComment = htmlspecialchars(trim($_POST['comment_content'])) ?? null;

            if (!null === $this->newComment) {
                $commentsModel = new CommentsModel;
                $commentsModel->saveComment($this->newComment, $this->id, $_SESSION['user_id']);
            }
        }

        require ROOT . "/app/View/beach_view.php";
    }
}

<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\StationsModel;
use CoteInfo\Model\MediaModel;
use CoteInfo\Model\CommentsModel;
use CoteInfo\Model\NotesModel;
use CoteInfo\Model\ReportsModel;
/*
 * Classe Station
 * Gère les articles des stations balnéaires
 * Eléments : infos station, médias, articles, commentaires
 */

class Station
{
    protected array $errors = [];

    protected $id;
    protected array $beach;

    protected array $medias;


    protected array $comments;
    // $comments = {0=>["id_comment"]=>int, ["content"]=>string, ["date_"]=>string,["is_deleted"]=>bool, 
    // ["id_note"]=>int,["id_station"]=>int, ["id_user"]=> int, ["author"]=>array{["id_user"],["username"],["avatar"]}}

    protected int $note = 0;

    protected array $articles;

    protected string $newComment;

    public function __construct()
    {
        $this->id = $_GET['id']; // ID station
        $stationsMdl = new StationsModel($this->id);

        $this->beach = $stationsMdl->getBeach(); // Données station
        $this->medias =  $stationsMdl->getMedia($this->id); // Médias station

        $articles = $stationsMdl->getArticlePreviews($this->id); // Articles
        $mediaModel = new MediaModel;
        $this->articles = $mediaModel->getThumbnails($articles);


        // Range les articles par ordre décroissant chronologique
        usort($this->articles, function ($a, $b) {
            return strtotime($b['date_']) - strtotime($a['date_']);
        });

        // Note
        if (isset($_POST['note'])) {
            if (filter_var($_POST['note'], FILTER_VALIDATE_INT) !== false && $_POST['note'] >= 1 && $_POST['note'] <= 5) {
                $this->note =  $_POST['note'];
            } else {
                $this->errors['note'] = "Note sélectionnée invalide.";
            }
        }

        // Gestion d'envois de notes
        if ($this->note !== 0 && isset($_SESSION['user_id'])) {
            if (!isset($notesModel)) {
                $notesModel = new NotesModel;
            }
            $notesModel->saveNote($this->note, $this->id, $_SESSION['user_id']);
        }

        // Gestion d'envois de commentaires
        if (!empty($_POST['comment_content'])) {
            if (!isset($_SESSION['user_id'])) {
                $this->errors['comment'] = "Vous n'êtes pas connecté.";
            } else {

                $this->newComment = htmlspecialchars(trim($_POST['comment_content'])); // Nouveau commentaire

                if ($this->newComment === null) {
                    $this->errors['comment'] = "Le commentaire ne doit pas être vide.";
                } else if (strlen($this->newComment) < 3) {
                    $this->errors['comment'] = "Le commentaire doit avoir plus de 3 caractères.";
                } else if (strlen($this->newComment) > 600) {
                    $this->errors['comment'] = "Le commentaire doit faire moins de 600 caractères.";
                } else {
                    if (!isset($commentsModel)) {
                        $commentsModel = new CommentsModel;
                    }
                    $commentID = $commentsModel->saveComment($this->newComment, $this->id, $_SESSION['user_id']);
                }
            }
        }

        // Gestion de suppression de commentaires
        if (isset($_GET['delete']) && isset($_SESSION['user_id'])) {
            if (!isset($commentsModel)) {
                $commentsModel = new CommentsModel;
            }
            // Si l'utilisateur a la permission, défini "set_deleted" à true pour le commentaire sélectionné
            $commentsModel->setDeleted($_GET["delete"], $_SESSION['user_id']);
        }

        // Gestion de reports de commentaires
        if (isset($_GET['report']) && isset($_SESSION['user_id']) && $_SESSION['is_admin'] !== true) {
            if ($_GET['report'] === $_SESSION['user_id']) {
                $this->errors['comment'] = "Vous ne pouvez pas signaler votre propre commentaire.";
            }

            $reportsModel = new ReportsModel;
            $reportsModel->newReport($_GET['report'], $_SESSION['user_id']);
        }

        $this->comments = $stationsMdl->getCommentsWithAuthorsAndNotes(); // Commentaires
        // Range les commentaires par ordre décroissant chronologique
        usort($this->comments, function ($a, $b) {
            return strtotime($b['date_']) - strtotime($a['date_']);
        });


        require ROOT . "/app/View/beach_view.php";
    }
}

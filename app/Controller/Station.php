<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\StationsModel;
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
    protected array $articles;


    public function __construct()
    {
        $this->id = $_GET['id'];
        $stationsMdl = new StationsModel($this->id);

        // Récupère de ma base les données à afficher dans l'article Station
        $this->beach = $stationsMdl->getBeach();
        $this->medias =  $stationsMdl->getMedia();
        $this->comments = $stationsMdl->getCommentsWithAuthors();
        $this->articles = $stationsMdl->getArticlePreviews();

        require ROOT . "/app/View/beach_view.php";
    }
}

<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\StationModel;
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
        $stationMdl = new StationModel($this->id);

        // Récupère de ma base les données à afficher dans l'article Station
        $this->beach = $stationMdl->getBeach();
        $this->medias =  $stationMdl->getMedia();
        $this->comments = $stationMdl->getCommentsWithAuthors();
        $this->articles = $stationMdl->getArticlePreviews();

        require ROOT . "/app/View/beach_view.php";
        require ROOT . "/app/View/footer_view.php";
    }
}

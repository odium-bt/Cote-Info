<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\NewsModel;
use CoteInfo\Model\StationsModel;
use CoteInfo\Model\MediaModel;

use finfo; // filetype info
/*
 * Classe NewsWrite
 * Gère la page d'écriture d'un nouvel article
 */

class NewsWrite
{
    protected array $errors = []; // Messages d'erreur

    protected array $stations = []; // Stations enregistrées


    // Contenu d'un nouvel article
    protected string $title;
    protected string $content;

    // Nouveau média (thumbnail de l'article)
    protected array $thumbnail = [];

    // Région et stations associées
    protected int $selectedRegion;
    protected array $selectedStations = [];

    private array $regions = [1, 2, 3, 4, 5, 6, 7]; // IDs des régions valides
    public function __construct()
    {
        $stationsModel = new StationsModel;
        $this->stations = $stationsModel->getAll();

        if (!empty($_POST)) {

            foreach ($_POST as $key => $post_element) {
                switch ($key) {
                    case 'title':
                        $this->title = htmlspecialchars(trim($_POST['title'])) ?? null;
                        break;
                    case 'content':
                        $this->content = (trim($_POST['content'])) ?? null;
                        break;
                    case 'region':
                        $this->selectedRegion = intval(htmlspecialchars(trim($_POST['region']))) ?? null;
                        break;
                    case 'stations':
                        $stations_input = $_POST['stations'] ?? [];
                        $this->selectedStations = array_map(function ($value) {
                            return htmlspecialchars(trim($value));
                        }, $stations_input);
                        break;
                }
            }

            // Les données de fichier arrivent dans $_FILES
            $this->thumbnail = $_FILES['thumbnail'] ?? [];

            // Titre
            if (!$this->title) {
                $this->errors['title'] = "Requis";
            } else  if (strlen($this->title) < 3) {
                $this->errors['title'] = "Au moins 3 caractères";
            } else if (strlen($this->title) > 255) {
                $this->errors['title'] = "Moins de 255 caractères";
            }

            // Content
            if (!$this->content) {
                $this->errors['content'] = "Requis";
            } else if (strlen(($this->content)) > 10000) {
                $this->errors['content'] = "Article trop long";
            }

            // Thumbnail
            if (empty($this->thumbnail)) {
                $this->errors['thumbnail'] = "Requis";
            } else if ($this->thumbnail['error'] !== UPLOAD_ERR_OK) {
                $this->errors['thumbnail'] = "L'envoi de l'image a échoué";
            } else if ($this->thumbnail['size'] > 2 * 1024 * 1024) {
                $this->errors['thumbnail'] = "Le fichier est trop lourd (2MB max)";
            } else {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($this->thumbnail['tmp_name']);
                $allowed = [
                    'image/webp' => 'webp',
                    'image/png'  => 'png',
                    'image/jpeg' => 'jpg'
                ];
                if (!isset($allowed[$mime])) {
                    $this->errors['thumbnail'] = "Type de fichier invalide (doit être webp, png ou jpg)";
                }
            }

            // Région
            if (!$this->selectedRegion) {
                $this->errors['selectedRegion'] = "Requis";
            } else if (!in_array($this->selectedRegion, $this->regions, true)) {
                $this->errors['selectedRegion'] = "Région invalide";
            }

            // Stations
            $validStationIds = array_column($this->stations, 'id_station');
            $allValid = true;
            foreach ($this->selectedStations as $value) {
                if (!in_array(intval($value), $validStationIds, true)) {
                    $allValid = false;
                    break;
                }
            }
            if ($allValid === false) {
                $this->errors['selectedStations'] = "Stations invalides";
            }
        }

        // ============ Sortie
        // Si $_POST est vide (début) ou qu'il y a des erreurs, affiche le formulaire
        if (empty($_POST) || !empty($this->errors)) {
            require ROOT . "/app/View/news-article-writing_view.php";
        }
        // Si $_POST est rempli sans erreurs
        else {

            // Déplace le fichier thumbnail vers le serveur
            $extension = $allowed[$mime];
            $filename = uniqid() . '.' . $extension;
            $destination = ROOT . '/public/images/beach/' . $filename;
            move_uploaded_file($this->thumbnail['tmp_name'], $destination);

            // Enregistre le thumbnail dans la table médias et retourne son ID
            $mediaModel = new MediaModel;
            $thumbnailID = $mediaModel->save(['path', 'MIME_type', 'id_region'], [$filename, $this->thumbnail['type'], $this->selectedRegion]);


            // Enregistre l'article dans la base
            $newsModel = new NewsModel;
            $newsID = $newsModel->newArticle($this->title, $this->content, $_SESSION['user_id'], $thumbnailID);

            // Enregistre les connexions entre l'article et les stations si applicable
            if (!empty($this->selectedStations)) {
                $newsModel->connect($this->selectedStations, $newsID);
            }

            require ROOT . "/app/View/news-article-writing-success_view.php";
        }
    }
}

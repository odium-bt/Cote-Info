<?php

namespace CoteInfo\Model;
/*
 * Classe StationModel
 * Gère les requêtes BDD pour les articles stations balnéaires
 */

class StationModel extends Model
{
    public function __construct()
    {
        $this->tableName = "BEACHES";
        parent::__construct();
    }

    // public function getStationMediaById($id)
    // {
    //     $db = Database::getInstance();
    //     $mediaIDs = $db->query("SELECT id_media FROM station_images WHERE id_station = '$id'");
    //     var_dump($mediaIDs);
    //     // foreach ($mediaIDs as $key => $value) {
    //     //     # code...
    //     // }
    // }
}

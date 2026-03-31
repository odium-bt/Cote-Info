<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\dbStation;
/*
 * Classe Station
 * Gère les articles des stations balnéaires
 */

class Station
{
    protected $stationID;

    public function __construct()
    {
        $this->stationID = $_GET["stationID"];
        $dbStation = new dbStation;
        $dbStation->getStationMediaById($this->stationID);
        require ROOT . "/app/View/beach_view.php";
    }
}

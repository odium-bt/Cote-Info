<?php

namespace CoteInfo\Controller;
/*
 * Classe Route
 * Gère le routage par la méthode $_GET["action"]
*/

class Route
{
    public $action;

    public function __construct()
    {
        // Récupère $_GET, sinon "accueil" quand vide
        $this->action = $_GET["action"] ?? "home";
    }

    public function redirigeVers()
    {
        require ROOT . "/app/View/header.php";
        switch ($this->action) {
            case "home":
                new Home;
                break;
            case "news":
                new News;
                break;
            case "about":
                new About;
                break;
            case "login":
                new Login;
                break;
            case "station":
                // Si un station ID est trouvé, continue à page station
                if (isset($_GET["stationID"])) {
                    new Station;
                } else {
                    new PageNotFound;
                }
                break;
            default:
                // Si $_GET["action"] = action non reconnue
                new PageNotFound;
                break;
        }
        require ROOT . "/app/View/footer.php";
    }
}

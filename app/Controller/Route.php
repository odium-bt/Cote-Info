<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\StationsModel;
/*
 * Classe Route
 * Gère le routage par la méthode $_GET["action"]
*/

class Route
{
    public string $action;

    public function __construct()
    {
        // Récupère $_GET, sinon "accueil" quand vide
        $this->action = $_GET["action"] ?? "home";
        $this->redirigeVers();
    }

    public function redirigeVers()
    {
        // Ferme la session de l'utilisateur si cela fait trop longtemps depuis la dernière activité
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
            session_unset();
            session_destroy();
        }
        $_SESSION['last_activity'] = time();

        switch ($this->action) {
            case "home":
                new Home;
                break;
            case "news":
                if (isset($_GET["id"])) {
                    new NewsArticle;
                } else {
                    new News;
                }
                break;
            case "about":
                new About;
                break;
            case "login":
                new Login;
                break;
            case "register":
                new Register;
                break;
            case "user":
                if (isset($_SESSION["user_id"])) {
                    new Profile;
                } else {
                    new Login;
                }
                break;
            case "logout":
                session_unset();
                session_destroy();
                new Home;
                break;
            case "deletion":
                new Deletion;
                break;
            case "station":
                // Si aucun ID station est trouvé, affiche la page 404
                if (isset($_GET["id"])) {
                    new Station;
                } else {
                    new PageNotFound;
                }
                break;
            case "policy":
                new Policy;
                break;
            case "write":
                if (!isset($_SESSION["user_id"]) || ($_SESSION["is_admin"] ?? false) !== true) {
                    new PermissionDenied;
                    return;
                }
                new NewsWrite;
                break;
            case "getStationsByRegion":
                // Dis au site que la réponse va être en json et pas HTML
                header('Content-Type: application/json');
                $regionId = intval($_GET['id_region'] ?? 0);
                $stationsModel = new StationsModel();
                $stations = $stationsModel->getStationsByRegion($regionId);
                // Retourne les données au script JS
                echo json_encode($stations);
                exit;
                break;
            default:
                // Si $_GET["action"] = action non reconnue
                new PageNotFound;
                break;
        }
    }
}

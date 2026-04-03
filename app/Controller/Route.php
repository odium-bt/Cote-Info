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
        // Ferme la session de l'utilisateur si cela fait trop longtemps depuis la dernière activité
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
            session_destroy();
        }
        $_SESSION['last_activity'] = time();


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
                new LoginForm;
                break;
            case "register":
                new RegisterForm;
                break;
            case "station":
                // Si aucun ID station est trouvé, affiche la page 404
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

<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\UserModel;
/*
 * Classe Profile
 * Gère la page du profil utilisateur
 * Requête à la base de données :
 */

class Profile
{
    protected int $userID;
    protected bool $isAdmin;
    public function __construct()
    {
        $this->userID = $_SESSION['user_id'] ?? null;
        $this->isAdmin = $_SESSION['is_admin'] ?? false;

        $userModel = new UserModel;

        if ($this->isAdmin === false) {
            require ROOT . "/app/View/user_view.php";
        } else if ($this->isAdmin === true) {
            require ROOT . "/app/View/admin_view.php";
        }
        require ROOT . "/app/View/footer_view.php";
    }
}

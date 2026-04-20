<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\UserModel;
/*
 * Classe Deletion
 * Gère la page de confirmation de suppression du compte
 */

class Deletion extends LoginForm
{
    public function __construct()
    {
        parent::__construct();

        $user = new UserModel;

        if (!isset($this->errors['email'])) {
            $currentEmail = $user->getEmailByID($_SESSION['user_id']);

            if ($this->email !== $currentEmail) {
                $this->errors['email'] = "Email erroné.";
            }
        }
        // Si $_POST est vide (début) ou qu'il y a des erreurs, affiche le formulaire
        if (empty($_POST) || !empty($this->errors)) {
            require ROOT . "/app/View/deletion_view.php"; // Affichage du formulaire
        }
        // Sinon $_POST est rempli sans erreurs, affiche la page succès et supprime le compte de l'utilisateur
        else {
            $user->deleteAccount($_SESSION['user_id']);
            session_unset();
            session_destroy();
            require ROOT . '/app/View/deletion-success_view.php'; // Affiche page succès
        }
    }
}

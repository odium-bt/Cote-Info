<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\UserModel;
/*
 * Classe Contact
 * Gère la page du formulaire de contact
 */

class Contact
{
    protected array $errors = [];

    // Inputs du formulaire
    protected string $name;
    protected string $email;
    protected string $object;
    protected string $message;
    protected string $policyAgreement;

    public function __construct()
    {
        // Contrôle de qualité (trouve les erreurs et ajoute les messages dans le tableau $errors)
        if (!empty($_POST)) {
            foreach ($_POST as $key => $post_element) {
                switch ($key) {
                    case 'name':
                        $this->name = htmlspecialchars(trim($_POST['name'])) ?? null;
                        break;
                    case 'email':
                        $this->email = strtolower(htmlspecialchars(trim($_POST['email']))) ?? null;
                        break;
                    case 'object':
                        $this->object = htmlspecialchars(trim($_POST['object'])) ?? null;
                        break;
                    case 'message':
                        $this->message = htmlspecialchars(trim($_POST['message'])) ?? null;
                        break;
                    case 'rgpd':
                        $this->policyAgreement = htmlspecialchars($_POST['rgpd']) ?? null;
                        break;
                    default:
                        break;
                }
            }
            // Nom d'utilisateur
            if (!$this->name) {
                $this->errors['name'] = "Requis";
            } else  if (strlen($this->name) < 3) {
                $this->errors['name'] = "Au moins 3 caractères";
            } else if (strlen($this->name) > 100) {
                $this->errors['name'] = "Moins de 100 caractères";
            }

            // Email
            if (!$this->email) {
                $this->errors['email'] = "Requis";
            } else if (strlen(($this->email)) > 254) {
                $this->errors['email'] = "L'adresse entrée est trop longue";
            } else if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
                $this->errors['email'] = "Veuillez entrer une adresse email valide";
            }

            // Sujet
            if (!$this->object) {
                $this->errors['object'] = "Requis";
            } else  if (strlen($this->object) < 3) {
                $this->errors['object'] = "Au moins 3 caractères";
            } else if (strlen($this->object) > 100) {
                $this->errors['object'] = "Moins de 100 caractères";
            }

            // Message
            if (!$this->message) {
                $this->errors['message'] = "Requis";
            } else  if (strlen($this->message) < 3) {
                $this->errors['message'] = "Au moins 3 caractères";
            } else if (strlen($this->message) >= 10000) {
                $this->errors['message'] = "Message trop long";
            }

            // Privacy Policy Agreement
            if ($this->policyAgreement !== "on") {
                $this->errors['rgpd'] = "Merci de cocher cette case.";
            }
        }

        // ============ Sortie
        // Si $_POST est vide (début) ou qu'il y a des erreurs, affiche le formulaire
        if (empty($_POST) || !empty($this->errors)) {
            require ROOT . "/app/View/contact_view.php";
        }
        // Sinon $_POST est rempli sans erreurs, enregistre le message et affiche la page succès
        else {

            require ROOT . '/app/View/contact-success_view.php';
        }
    }
    // ============
}

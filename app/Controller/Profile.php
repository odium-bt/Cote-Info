<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\UserModel;
use CoteInfo\Model\CommentsModel;
use CoteInfo\Model\NotesModel;
use CoteInfo\Model\NewsModel;
/*
 * Classe Profile
 * Gère la page du profil utilisateur
 * Requête à la base de données :
 */

class Profile
{
    protected array $errors = [];

    protected int $userID;
    protected bool $isAdmin;

    protected array $user;

    public function __construct()
    {
        $userModel = new UserModel;
        $this->userID = $_SESSION['user_id'];
        $this->isAdmin = $userModel->isAdmin($this->userID) ?? false;

        $this->user = $userModel->getById($this->userID);

        // Changement d'avatar
        if (isset($_FILES['new-avatar'])) {
            $newAvatar = $this->replaceAvatar($_FILES['new-avatar']);
        }

        require ROOT . "/app/View/user_view.php";
    }

    /*
     * Fonction getComments
     * paramètre : /
     * résultat : commentaires de l'utilisateur
     */
    protected function getComments()
    {
        if (!isset($commentsModel)) {
            $commentsModel = new CommentsModel;
        }

        $comments = $commentsModel->getCommentsByUser($this->userID) ?? [];

        // Ajoute les notes associées aux commentaires
        if (!isset($notesModel)) {
            $notesModel = new NotesModel();
        }
        $notes = $notesModel->getNoteForComments($comments);
        $comments = $notesModel->linkNotes($comments, $notes);

        return $comments;
    }

    /*
     * Fonction getArticles
     * paramètre : /
     * résultat : commentaires de l'utilisateur
     */
    protected function getArticles()
    {
        $newsModel = new NewsModel;
        $articleIDs = $newsModel->getArticleIDsByUser($this->userID) ?? [];
        if (!empty($articleIDs)) {
            var_dump($articleIDs);
            return $newsModel->getPreviews($articleIDs);
        } else {
            return [];
        }
    }


    /*
     * Fonction replaceAvatar
     * paramètre : fichier envoyé par l'utilisateur
     * résultat : sauvegarde le nouvel avatar ou renvoie une erreur
     *            si sauvegardé = true, sinon = false
     */
    private function replaceAvatar($avatar)
    {
        $fileTmp = $avatar['tmp_name'];

        // Vérifie que c'est bien une image
        $imageInfo = getimagesize($fileTmp);
        if ($imageInfo === false) {
            $this->errors['avatar'] = "Ce fichier n'est pas une image.";
            return false;
        }

        $mime = $imageInfo['mime'];

        // Types autorisés
        $allowed = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg',
            'image/webp' => 'webp'
        ];

        if (!isset($allowed[$mime])) {
            $this->errors['avatar'] = "L'image doit être en format png, jpg ou webp.";
            return false;
        }

        // Création image source
        switch ($mime) {
            case 'image/png':
                $src = imagecreatefrompng($fileTmp);
                break;
            case 'image/jpeg':
                $src = imagecreatefromjpeg($fileTmp);
                break;
            case 'image/webp':
                $src = imagecreatefromwebp($fileTmp);
                break;
            default:
                $this->errors['avatar'] = "L'image doit être en format png, jpg ou webp.";
                return false;
        }

        // Redimensionne 
        $newWidth = 100;
        $newHeight = 100;

        $destination = imagecreatetruecolor($newWidth, $newHeight);

        // Contrôle transparence
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
        }

        // Copie et redimensionne l'image source vers la destination
        imagecopyresampled($destination, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imageInfo[0], $imageInfo[1]);

        // Crée le dossier s'il n'existe pas
        $uploadDir = ROOT . "/public/images/avatars/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Nom sécurisé
        $fileName = uniqid("avatar_", true) . "." . $allowed[$mime];
        $path = $uploadDir . $fileName;

        // Sauvegarde
        $saved = false;
        switch ($mime) {
            case 'image/png':
                $saved = imagepng($destination, $path);
                break;
            case 'image/jpeg':
                $saved = imagejpeg($destination, $path, 90);
                break;
            case 'image/webp':
                $saved = imagewebp($destination, $path);
                break;
        }

        // Nettoyage des ressources
        unlink($fileTmp);

        if (!$saved) {
            $this->errors['avatar'] = "Erreur lors de la sauvegarde de l'avatar.";
            return false;
        }

        // Mise à jour de la base de données
        $userModel = new UserModel();
        if (!$userModel->updateAvatar($this->userID, $fileName)) {
            // Supprime le fichier si la mise à jour échoue
            unlink($path);
            $this->errors['avatar'] = "Erreur lors de la mise à jour du profil.";
            return false;
        }

        return true;
    }
}

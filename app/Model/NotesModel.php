<?php

namespace CoteInfo\Model;
/*
 * Classe NotesModel
 * Gère les requêtes BDD pour les notes
 */

class NotesModel extends Model
{
    public function __construct()
    {
        $this->tableName = "notes";
        $this->idName = 'id_note';
        parent::__construct();
    }

    /*
     * Fonction saveNote
     * paramètre : note, ID station, ID user
     * résultat : sauvegarde la note et retourne son ID
     */
    public function saveNote(int $note, int $stationID, int $userID)
    {
        $noteID = $this->getNoteByUserAndStation($userID, $stationID);

        if ($noteID === null) {
            // Sauvegarde une nouvelle entrée de note
            $fields = ['value_', 'id_station', 'id_user'];
            $values = [$note, $stationID, $userID];

            return $this->save($fields, $values); // Renvoie l'ID de la note enregistrée
        } else {
            // Met à jour une note existante
            $this->dbRequest(
                "UPDATE `notes` SET `value_` = ? WHERE `id_note` = ?",
                [$note, $noteID]
            );
            return $noteID;
        }
    }

    /*
     * Fonction getNoteByUserAndStation
     * paramètre : ID station et ID user
     * résultat : retourne l'ID de la note de l'utilisateur (null si vide)
     */
    public function getNoteByUserAndStation(int $userID, int $idStation)
    {
        $result = $this->dbRequest(
            "SELECT `id_note` FROM `" . $this->tableName . "` WHERE `id_user` = ? AND `id_station` = ?",
            [$userID, $idStation]
        );

        return $result ? $result['id_note'] : null;
    }

    /*
     * Fonction getNote
     * paramètre : ID note
     * résultat : retourne la note de l'utilisateur (null si vide)
     */
    public function getNote(int $noteID)
    {
        return $this->dbRequest(
            "SELECT `value_` FROM `" . $this->tableName . "` WHERE `id_note` = ?",
            [$noteID]
        ) ?? null;
    }
}

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
     * Fonction getNotesForComments
     * paramètre : commentaires
     * résultat : retourne la note associée (null si vide)
     */
    public function getNoteForComments(array $comments)
    {
        if (empty($comments)) {
            return [];
        }

        $pairs = [];

        foreach ($comments as $comment) {
            $pairs[] = "(" . intval($comment['id_user']) . ", " . intval($comment['id_station']) . ")";
        }

        $values = implode(',', $pairs);

        return $this->dbRequestAll(
            "SELECT * FROM `" . $this->tableName . "` WHERE (id_user, id_station) IN ($values)"
        ) ?? [];
    }

    /*
     * Fonction linkNotes
     * paramètre : commentaires
     * résultat : les commentaires avec une nouvelle propriété "note" contenant la valeur de la note
     */
    public function linkNotes(array $comments, array $notes)
    {
        // Associe les notes à leurs commentaires
        // Créée une carte pour trouver une note par id_user et id_station
        $notesByKey = [];
        foreach ($notes as $note) {
            $key = $note['id_user'] . '_' . $note['id_station'];
            $notesByKey[$key] = $note;
        }
        foreach ($comments as &$comment) {
            $key = $comment['id_user'] . '_' . $comment['id_station']; // créé une clé par id_user et id_station

            $comment['note'] = $notesByKey[$key]['value_'] ?? null; // récupère sa note, ou null
        }
        unset($comment);

        return $comments;
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

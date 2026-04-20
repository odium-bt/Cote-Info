<?php

namespace CoteInfo\Model;
/*
 * Classe ReportsModel
 * Gère les requêtes BDD pour les signalements
 */

class ReportsModel extends Model
{
    public function __construct()
    {
        $this->tableName = "reports";
        $this->idName = 'id_report';
        parent::__construct();
    }

    /*
     * Fonction newReport
     * paramètre : ID commentaire et ID utilisateur
     * résultat : Enregistre un signalement dans la table reports
     */
    public function newReport(int $IDcomment, int $IDuser)
    {
        $fields = ['id_comment', 'id_user'];
        $values = [$IDcomment, $IDuser];

        $this->save($fields, $values);
    }
}

<?php

namespace CoteInfo\Model;

use PDO;
use PDOException;

/*
 * Classe Model
 * Parente les autres classes Model
 */

abstract class Model
{
    protected string $tableName;
    protected Database $db;
    protected PDO $dbConnector;

    protected function __construct()
    {
        $this->db = Database::getInstance();
        $this->dbConnector = $this->db->getConnection();
    }

    /*
     * Fonction dbRequest
     * paramètres : - requête sql  
     *              - array de paramètres (optionnel)
     * résultat : Exécute le statement PDO et retourne le résultat sous forme de tableau associatif
     */
    protected function dbRequest(string $sql, array $params = [])
    {
        try {
            $stmt = $this->dbConnector->prepare($sql);
            $stmt->execute($params ?? null);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            die($e->getMessage() . "<br>Erreur de connexion PDO");
        }
    }

    /*
     * Fonction getAll
     * paramètres : /
     * résultat : Retourne tous les éléments de la table
     */
    public function getAll()
    {
        $this->dbRequest("SELECT * FROM " . $this->tableName);
    }

    /*
     * Fonction getById
     * paramètres : valeur, nom de colonne
     * résultat : Retourne les éléments de la table selon la colonne donnée
     */
    public function getById(string $id, string $colname)
    {
        $id = $id ?? "?";
        return $this->dbRequest(
            "SELECT * FROM `" . $this->tableName . "` WHERE $colname = '$id'",
        );
    }

    /*
     * Fonction save
     * paramètres : champs à remplir, valeurs à remplir
     * résultat : Sauvegarde les éléments dans la base de données
     */
    public function save(array $fields, array $values)
    {
        try {
            $fields = "(" . implode(", ", $fields) . ")";
            $values = "('" . implode("', '", $values) . "')";

            $this->dbRequest(
                "INSERT INTO `" . $this->tableName . "` $fields VALUES $values"
            );
        } catch (PDOException $e) {
            die($e->getMessage() . "<br>Erreur de connexion PDO");
        }
    }
}

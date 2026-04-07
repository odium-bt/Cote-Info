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
    protected string $idName;
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

            return empty($result) ? null : $result;
        } catch (PDOException $e) {
            die($e->getMessage() . "<br>Erreur de connexion PDO");
        }
    }

    /*
     * Fonction dbRequestAll
     * paramètres : - requête sql  
     *              - array de paramètres (optionnel)
     * résultat : Exécute le statement PDO et retourne tous les résultats sous forme de tableau associatif
     */
    protected function dbRequestAll(string $sql, array $params = [])
    {
        try {
            $stmt = $this->dbConnector->prepare($sql);
            $stmt->execute($params ?? null);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return empty($result) ? null : $result;
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
        $this->dbRequestAll("SELECT * FROM " . $this->tableName);
    }

    /*
     * Fonction getById
     * paramètres : id
     * résultat : Retourne l'élément avec l'id donné
     */
    public function getById($id)
    {
        return $this->dbRequest(
            "SELECT * FROM `" . $this->tableName . "` WHERE `$this->idName` = ?",
            [$id]
        );
    }

    /*
     * Fonction save
     * paramètres : champs à remplir, valeurs à remplir
     * résultat : Sauvegarde les éléments dans la base de données
     */
    public function save(array $fields, array $values)
    {
        $fields = "(" . implode(", ", $fields) . ")";
        $placeholders = str_repeat('?, ', count($values) - 1) . '?';

        // Insère les valeurs dans les champs correspondants dans une nouvelle entrée en base
        $this->dbRequest(
            "INSERT INTO `" . $this->tableName . "` $fields VALUES ($placeholders)",
            $values
        );
    }
}

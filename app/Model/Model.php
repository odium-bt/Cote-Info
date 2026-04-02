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

    // Template pour mes requêtes BDD
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

    // Retourne tous les éléments de la table
    public function getAll()
    {
        $this->dbRequest("SELECT * FROM `" . $this->tableName . "`");
    }

    // Retourne les éléments de la table selon l'ID donné
    public function getById(string $id, string $idName)
    {
        $id = $id ?? "?";
        return $this->dbRequest(
            "SELECT * FROM `" . $this->tableName . "` WHERE $idName = '$id'",
        );
        
    }

    // Sauvegarde un élément dans la table selon les champs et les valeurs
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

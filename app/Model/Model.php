<?php

namespace CoteInfo\Model;

use Database;
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
    protected function dbRequest(string $str)
    {
        try {
            $exec = $this->dbConnector->prepare($str);
            $exec->execute();
            $result = $exec->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            die($e->getMessage() . "Erreur de connexion PDO");
        }
    }

    // Retourne tous les éléments de la table
    public function getAll()
    {
        $this->dbRequest("SELECT * FROM $this->tableName");
    }

    // Retourne les éléments de la table selon l'ID donné
    public function getById(string $id, string $idName)
    {
        $this->dbRequest("SELECT * FROM $this->tableName WHERE `$this->tableName`.$idName = $id");
    }

    // Sauvegarde un élément dans la table selon les champs et les valeurs
    public function save(array $fields, array $values)
    {
        try {
            $save = $this->dbConnector->prepare("INSERT INTO `$this->tableName` ($fields) VALUES ($values)");
            $save->execute();
        } catch (PDOException $e) {
            die($e->getMessage() . "Erreur de connexion PDO");
        }
    }
}

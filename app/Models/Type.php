<?php

namespace Pokedex\Models;

use Pokedex\Utils\Database;
use PDO;

class Type extends CoreModel
{

    /** 
     * Propriétés stockant les informations du type
     */
    private $color;

    /**
     * Création de getters  (pas besoin de setters pour notre utilisation !
     * afin de récupérer les valeurs des propriétés
     */

    public function getColor()
    {
        return $this->color;
    }

    /** 
     * Méthode permettant de récupérer la liste des types
     */
    public function findAll()
    {
        $sql = "SELECT *
                FROM `type` 
                ORDER BY `name`";

        // On récupère la connexion à la BDD
        $pdo = Database::getPDO();

        // On exécute la requête
        $pdoStatement = $pdo->query($sql);

        // On récupère tous les résultats avec "fetchAll" et on met transmet les données récupérées à une instance du model courant (Pokemon)
        $types = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $types;
    }
}

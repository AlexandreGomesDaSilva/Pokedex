<?php

namespace Pokedex\Models;

use Pokedex\Utils\Database;
use PDO;
use Pokedex\Models\Type;

class Pokemon extends CoreModel
{
    /** 
     * Propriétés stockant les informations du pokémon
     */
    private $hp;
    private $attack;
    private $defense;
    private $spe_attack;
    private $spe_defense;
    private $speed;
    private $number;

    /**
     * Création de getters  (pas besoin de setters pour notre utilisation !
     * afin de récupérer les valeurs des propriétés
     */

    public function getHp()
    {
        return $this->hp;
    }

    public function getAttack()
    {
        return $this->attack;
    }

    public function getDefense()
    {
        return $this->defense;
    }

    public function getSpeAttack()
    {
        return $this->spe_attack;
    }

    public function getSpeDefense()
    {
        return $this->spe_defense;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function getNumber()
    {
        return $this->number;
    }

    /** 
     * Méthode permettant de récupérer la liste des pokémon classés par numéros
     */
    public function findAll()
    {
        $sql = "SELECT *
                FROM `pokemon` 
                ORDER BY `number`";

        // On récupère la connexion à la BDD
        $pdo = Database::getPDO();

        // On exécute la requête
        $request = $pdo->query($sql);

        // On récupère tous les résultats avec "fetchAll" et on met transmet les données récupérées à une instance du model courant (Pokemon)
        $pokemons = $request->fetchAll(PDO::FETCH_CLASS, self::class);

        return $pokemons;
    }

    /** 
     * Méthode permettant de récupérer les informations d'un pokémon
     */
    public function find($number)
    {
        $sql = "SELECT *
                FROM `pokemon` 
                WHERE `number` = {$number}
                LIMIT 1";

        // On récupère la connexion à la BDD
        $pdo = Database::getPDO();

        // On exécute la requête avec query car on souhaite pouvoir accéder
        // aux données retournées par la requête
        $pdoStatement = $pdo->query($sql);

        // On récupère le résultat et on instancie la classe courante avec les infos récupérées
        $pokemon = $pdoStatement->fetchObject(self::class);

        return $pokemon;
    }

    /** 
     * Méthode permettant de récupérer une liste de pokémons par type
     */
    public function findByType($typeId)
    {
        // On joint la table de pivot "pokemon_type" afin de pouvoir filtrer sur les ID de type
        $sql = "SELECT *
                FROM `pokemon` 
                INNER JOIN `pokemon_type` ON `pokemon_type`.`pokemon_number` = `pokemon`.`number`
                WHERE `pokemon_type`.`type_id` = {$typeId}
                ORDER BY `pokemon`.`number`";

        // On récupère la connexion à la BDD
        $pdo = Database::getPDO();

        // On exécute la requête avec query car on souhaite pouvoir accéder
        // aux données retournées par la requête
        $pdoStatement = $pdo->query($sql);

        // On récupère tous les résultats avec "fetchAll" et on met transmet les données récupérées à une instance du model courant (Pokemon)
        $pokemons = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $pokemons;
    }

    /**
     * Méthode permettant de récupérer les types du Pokémon courant
     */
    public function getTypes()
    {
        // On cherche dans la table de pivot "pokemon_type" les entrées qui correspondent au numéro fourni
        // puis on joint cette table à la table "type" dont on récupère les champs
        $sql = "SELECT `type`.*
                FROM `pokemon_type`
                INNER JOIN `type` ON `type`.`id` = `pokemon_type`.`type_id`
                WHERE `pokemon_type`.`pokemon_number` = {$this->getNumber()}";

        // On récupère la connexion à la BDD
        $pdo = Database::getPDO();

        // On exécute la requête avec query car on souhaite pouvoir accéder
        // aux données retournées par la requête
        $pdoStatement = $pdo->query($sql);

        // On récupère le résultat  et on instancie la classe Type avec les infos récupérées
        $types = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Type::class);

        return $types;
    }
}

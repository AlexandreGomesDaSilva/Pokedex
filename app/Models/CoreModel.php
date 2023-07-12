<?php

namespace Pokedex\Models;

class CoreModel
{
    /** 
     * Tous nos models ont les propriétés id et name en commun. On peut donc les extraire dans le model parent.
     */
    protected $id;
    protected $name;
    

    /**
     * De même pour les getters (pas besoin de setters dans ce projet)
     */

    /**
     * Get the value of the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

}

<?php

namespace App\Service;

use App\Entity\Character;


interface CharacterServiceInterface{
    /**
     * Create the character
     */
    public function create();

    public function getAll();

    public function modify(Character $character);
}
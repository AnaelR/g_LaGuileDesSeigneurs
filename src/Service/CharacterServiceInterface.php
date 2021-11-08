<?php

namespace App\Service;

interface CharacterServiceInterface{
    /**
     * Create the character
     */
    public function create();

    public function getAll();
}
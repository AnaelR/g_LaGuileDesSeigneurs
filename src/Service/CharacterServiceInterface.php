<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Create the character
     */
    public function create(string $data);

    public function isEntityFilled(Character $character);

    public function submit(Character $character, $formName, $date);

    public function getAll();

    public function modify(Character $character, string $data);

    public function delete(Character $character);

    public function getImages(int $number, ?string $kind = null);

    public function serializeJson($data);
}

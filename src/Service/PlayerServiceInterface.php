<?php

namespace App\Service;

use App\Entity\Player;

interface PlayerServiceInterface
{
    public function create(string $data);

    public function submit(Player $player, $formName, $date);

    public function getAll();

    public function modify(Player $player, string $data);

    public function delete(Player $player);

    public function serializeJson($data);
}

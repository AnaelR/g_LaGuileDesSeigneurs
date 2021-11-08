<?php

namespace App\Service;

use App\Entity\Player;

interface PlayerServiceInterface{

    public function create();

    public function getAll();

    public function modify(Player $player);

    public function delete(Player $player);
}
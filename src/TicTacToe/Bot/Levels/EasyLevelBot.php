<?php

namespace GameBot\TicTacToe\Bot\Levels;

use GameBot\TicTacToe\Bot\BotService;
use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;

class EasyLevelBot implements BotService {

    public function getNextMovement(DefaultMap $map): MapPosition
    {
        $empty_spots = $map->getEmptySpots();
        if (empty($empty_spots)) {
            throw new \LogicException('There is no more possible movements');
        }
        $index = array_rand($empty_spots);
        return $empty_spots[$index];
    }
}

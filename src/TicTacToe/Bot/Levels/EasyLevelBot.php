<?php

namespace GameBot\TicTacToe\Bot\Levels;

use GameBot\TicTacToe\Bot\BaseTicTacToeBot;
use GameBot\TicTacToe\Map\MapPosition;

class EasyLevelBot extends BaseTicTacToeBot {

    public function getNextMovement(): MapPosition {
        $map = $this->getMap();
        $empty_spots = $map->getEmptySpots();
        if (empty($empty_spots)) {
            throw new \LogicException('There is no more possible movements');
        }
        $index = array_rand($empty_spots);
        return $empty_spots[$index];
    }
}

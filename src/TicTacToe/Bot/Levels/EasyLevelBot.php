<?php

namespace GameBot\TicTacToe\Bot\Levels;

use GameBot\TicTacToe\Bot\AbstractBot;
use GameBot\TicTacToe\Exceptions\NoMorePossibleMovementsException;
use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;

class EasyLevelBot extends AbstractBot {

    public function getNextMovement(DefaultMap $map): MapPosition
    {
        $empty_spots = $map->getEmptySpots();
        if (empty($empty_spots)) {
            throw new NoMorePossibleMovementsException();
        }
        $index = array_rand($empty_spots);
        return $empty_spots[$index];
    }
}

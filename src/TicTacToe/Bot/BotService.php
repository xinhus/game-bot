<?php

namespace GameBot\TicTacToe\Bot;

use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;

interface BotService {

    public function getNextMovement(DefaultMap $map): MapPosition;

}

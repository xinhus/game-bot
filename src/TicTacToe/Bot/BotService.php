<?php

namespace GameBot\TicTacToe\Bot;

use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;

interface BotService {

    public function __construct(DefaultMap $map);

    public function getNextMovement(): MapPosition;

}

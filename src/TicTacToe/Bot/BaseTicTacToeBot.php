<?php

namespace GameBot\TicTacToe\Bot;

use GameBot\TicTacToe\Map\DefaultMap;

abstract class BaseTicTacToeBot implements BotService {

    private $map;

    final public function __construct(DefaultMap $map)
    {
        $this->map = $map;
    }

    protected function getMap(): DefaultMap
    {
        return $this->map;
    }
}

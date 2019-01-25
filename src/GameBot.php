<?php

namespace GameBot;

class GameBot {

    private $gameBot;

    public function __construct(string $gameBot)
    {
        $this->gameBot = $gameBot;
    }

    public function getGameBot(): string {
        return $this->gameBot;
    }

}

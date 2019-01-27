<?php

namespace Test\GameBot\TicTacToe\Service;

use GameBot\TicTacToe\Bot\BotService;
use GameBot\TicTacToe\Service\MoveService;

class MoveServiceForTest extends MoveService
{

    public function getBot(): BotService
    {
        return $this->bot;
    }
}

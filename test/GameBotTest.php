<?php

namespace Test\GameBot;

use GameBot\GameBot;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class GameBotTest extends TestCase {

    public function testGameBot(): void
    {
        $instance = new GameBot('Tic Tac Toe bot');
        Assert::assertEquals('Tic Tac Toe bot', $instance->getGameBot());
    }

}

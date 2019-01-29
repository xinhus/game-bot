<?php

namespace Test\GameBot\TicTacToe\Service;

use GameBot\TicTacToe\Bot\Levels\EasyLevelBot;
use GameBot\TicTacToe\Bot\Levels\HardLevelBot;
use GameBot\TicTacToe\Service\MoveInterface;
use GameBot\TicTacToe\Service\MoveService;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class MoveServiceTest extends TestCase
{

    public function testInvalidLevel_shouldThrownException()
    {
        $level = 'invalid level';
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Bot not found! Level: ' . $level);
        MoveService::getMoveService($level);
    }

    public function getLevelsToTest() {
        return [
            ['level' => 'easy', 'bot' => EasyLevelBot::class],
            ['level' => 'hard', 'bot' => HardLevelBot::class],
        ];
    }

    /**
     * @dataProvider getLevelsToTest
     * @param string $level
     * @param string $expectedBot
     */
    public function testLoadLevelBot(string $level, string $expectedBot)
    {
        /** @var MoveServiceForTest $service */
        $service = MoveServiceForTest::getMoveService($level);
        Assert::assertInstanceOf(MoveInterface::class, $service);
        Assert::assertInstanceOf($expectedBot, $service->getBot());
    }

    public function testMakeMOve()
    {
        $boardState = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];
        $expectedPlayerUnit = 'X';
        $level = 'easy';
        $service = MoveService::getMoveService($level);
        [$posX, $posY, $playerUnit] = $service->makeMove($boardState, $expectedPlayerUnit);

        Assert::assertGreaterThanOrEqual(0, $posX);
        Assert::assertLessThan(3, $posX);
        Assert::assertGreaterThanOrEqual(0, $posY);
        Assert::assertLessThan(3, $posY);
        Assert::assertEquals($expectedPlayerUnit, $playerUnit);
    }
}

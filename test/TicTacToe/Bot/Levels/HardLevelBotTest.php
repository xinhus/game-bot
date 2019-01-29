<?php

namespace Test\GameBot\TicTacToe\Bot\Levels;

use GameBot\TicTacToe\Bot\Levels\HardLevelBot;
use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class HardLevelBotTest extends TestCase
{

    public function getCases(): array
    {
        return [
            [
                'map' => [
                    ['', 'O', ''],
                    ['X', 'X', ''],
                    ['O', 'O', ''],

                ],
                'expectedPosition' => new MapPosition(2,1)
            ],
            [
                'map' => [
                    ['', 'O', 'X'],
                    ['', 'X', ''],
                    ['O', 'O', ''],

                ],
                'expectedPosition' => new MapPosition(2,2)
            ],
            [
                'map' => [
                    ['', '', ''],
                    ['', '', ''],
                    ['O', '', ''],

                ],
                'expectedPosition' => new MapPosition(1,1)
            ],
        ];
    }

    /**
     * @dataProvider getCases
     * @param array $map
     * @param MapPosition $expectedPosition
     */
    public function test(array $map, MapPosition $expectedPosition)
    {
        $defaultMap = new DefaultMap($map);
        $bot = new HardLevelBot();
        $movement = $bot->setBotPlayerUnit('X')->getNextMovement($defaultMap);
        Assert::assertEquals($expectedPosition->getX(), $movement->getX(), 'Incorrect X Axis');
        Assert::assertEquals($expectedPosition->getY(), $movement->getY(), 'Incorrect Y Axis');
    }

    public function testBotAgainstBot()
    {
        $mapAsArray = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];
        $map = new DefaultMap($mapAsArray);
        $firstBot = (new HardLevelBot())->setBotPlayerUnit('X');
        $secondBot = (new HardLevelBot())->setBotPlayerUnit('O');

        $botService = null;
        while (!$map->isTie()) {
            $botService = ($botService == $firstBot) ? $secondBot : $firstBot;
            $movement = $botService->getNextMovement($map);
            $map = $map->simulateMapWithNextMove($movement, $botService->getBotPlayerUnit());
            Assert::assertFalse($map->hasWinner());
        }
    }

}

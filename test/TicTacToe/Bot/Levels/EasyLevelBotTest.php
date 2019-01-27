<?php

namespace Test\GameBot\TicTacToe\Bot\Levels;

use GameBot\TicTacToe\Bot\Levels\EasyLevelBot;
use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class EasyLevelBotTest extends TestCase {

    public function getMapsToTestAllowedMovement(): array
    {
        return [
            [
                'map' => [
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                    ['O', 'X', ''],
                ],
                'allowedMovement' => [new MapPosition(2, 2)]
            ],
            [
                'map' => [
                    ['', '', ''],
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                ],
                'allowedMovement' => [new MapPosition(0,0), new MapPosition(1, 0), new MapPosition(2, 0)]
            ],
            [
                'map' => [
                    ['X', 'O', 'X'],
                    ['', '', ''],
                    ['O', 'X', 'O'],
                ],
                'allowedMovement' => [new MapPosition(0,1), new MapPosition(1, 1), new MapPosition(2, 1)]
            ],
            [
                'map' => [
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                    ['', '', ''],
                ],
                'allowedMovement' => [new MapPosition(0,2), new MapPosition(1, 2), new MapPosition(2, 2)]
            ],
            [
                'map' => [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ],
                'allowedMovement' => [
                    new MapPosition(0,0), new MapPosition(0, 1), new MapPosition(0, 2),
                    new MapPosition(1,0), new MapPosition(1, 1), new MapPosition(1, 2),
                    new MapPosition(2,0), new MapPosition(2, 1), new MapPosition(2, 2),
                ]
            ],
        ];
    }

    /**
     * @dataProvider getMapsToTestAllowedMovement
     * @param array $mapAsArray
     * @param MapPosition[] $allowedMovements
     */
    public function testGetNextMove(array $mapAsArray, array $allowedMovements) {
        $map = new DefaultMap($mapAsArray);
        $bot = new EasyLevelBot();
        $movement = $bot->getNextMovement($map);
        self::assertIsAnAllowedMovement($allowedMovements, $movement);
    }

    private static function assertIsAnAllowedMovement(array $allowedMovements, MapPosition $movement): void {
        $isAnAllowedMovement = false;
        foreach ($allowedMovements as $possibleMovement) {
            if ($possibleMovement->getX() != $movement->getX()) {
                continue;
            }
            if ($possibleMovement->getY() != $movement->getY()) {
                continue;
            }
            $isAnAllowedMovement = true;
        }
        Assert::assertTrue($isAnAllowedMovement, "The movement X:{$movement->getX()} Y:{$movement->getY()} is not allowed!");
    }
}

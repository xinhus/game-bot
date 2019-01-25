<?php

namespace Test\GameBot\TicTacToe\Map;

use GameBot\TicTacToe\Map\MapPosition;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MapPositionTest extends TestCase {

    public function getCasesToFail() {
        return [
            ['x' => 1, 'y' => 3],
            ['x' => 3, 'y' => 3],
            ['x' => 3, 'y' => 1],
            ['x' => -1, 'y' => -1],
        ];
    }

    /**
     * @dataProvider getCasesToFail
     * @param int $x
     * @param int $y
     */
    public function testInvalidMapPosition(int $x, int $y): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid map position');
        new MapPosition($x, $y);
    }
}

<?php

namespace GameBot\TicTacToe\Map;

class MapPosition {

    private $x;
    private $y;

    public function __construct(int $x, int $y)
    {
        if ($x >= 3 || $x < 0 || $y >= 3 || $y < 0) {
            throw new \InvalidArgumentException('Invalid map position');
        }
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }
}

<?php

namespace GameBot\TicTacToe\Service;

use GameBot\TicTacToe\Bot\BotService;
use GameBot\TicTacToe\Bot\Levels\EasyLevelBot;
use GameBot\TicTacToe\Map\DefaultMap;

class MoveService implements MoveInterface
{

    protected $bot;

    private function __construct(BotService $bot)
    {
        $this->bot = $bot;
    }

    public static function getMoveService(string $level): self
    {
        if ($level == 'easy') {
            return new static(new EasyLevelBot());
        }

        throw new \InvalidArgumentException('Bot not found! Level: ' . $level);
    }

    public function makeMove($boardState, $playerUnit = 'X'): array
    {
        $map = new DefaultMap($boardState);
        $movement = $this->bot->getNextMovement($map);
        return [
            $movement->getX(),
            $movement->getY(),
            $playerUnit
        ];
    }
}

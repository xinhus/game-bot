<?php

namespace GameBot\TicTacToe\Service;

use GameBot\TicTacToe\Bot\BotService;
use GameBot\TicTacToe\Bot\Levels\EasyLevelBot;
use GameBot\TicTacToe\Bot\Levels\HardLevelBot;
use GameBot\TicTacToe\Exceptions\NoMorePossibleMovementsException;
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
        if ($level == 'hard') {
            return new static(new HardLevelBot());
        }

        throw new \InvalidArgumentException('Bot not found! Level: ' . $level);
    }

    public function makeMove($boardState, $playerUnit = 'X'): array
    {
        $map = new DefaultMap($boardState);
        if ($map->hasWinner()) {
            throw new NoMorePossibleMovementsException("The player \"{$map->getWinnerPlayer()}\" already won the game.");
        }
        $movement = $this->bot
            ->setBotPlayerUnit($playerUnit)
            ->getNextMovement($map);
        return [
            $movement->getX(),
            $movement->getY(),
            $this->bot->getBotPlayerUnit()
        ];
    }
}

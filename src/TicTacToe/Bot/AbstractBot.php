<?php

namespace GameBot\TicTacToe\Bot;


abstract class AbstractBot implements BotService
{

    private $botPlayerUnit;
    private $opponentPlayerUnit;

    public function setBotPlayerUnit(string $playerUnit): BotService
    {
        $this->botPlayerUnit = $playerUnit == 'X' ? 'X' : 'O';
        $this->opponentPlayerUnit = $playerUnit == 'X' ? 'O' : 'X';
        return $this;
    }

    public function getBotPlayerUnit(): string
    {
        return $this->botPlayerUnit;
    }

    protected function getOpponentPlayerUnit(): string
    {
        return $this->opponentPlayerUnit;
    }


}

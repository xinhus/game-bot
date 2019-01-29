<?php

namespace GameBot\TicTacToe\Bot\Levels;

use GameBot\TicTacToe\Bot\AbstractBot;
use GameBot\TicTacToe\Exceptions\NoMorePossibleMovementsException;
use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;

class HardLevelBot extends AbstractBot
{

    public function getNextMovement(DefaultMap $map): MapPosition
    {
        $possibleMovements = $map->getEmptySpots();
        if (empty($possibleMovements)) {
            throw new NoMorePossibleMovementsException();
        }
        $bestMovement = null;
        $bestScore = PHP_INT_MIN;

        foreach ($possibleMovements as $i => $nextMove) {
            $simulatedMovement = $map->simulateMapWithNextMove($nextMove, $this->getBotPlayerUnit());
            $score = $this->calculateMovementScore($simulatedMovement, $this->getBotPlayerUnit(), 0);
            if ($score > $bestScore) {
                $bestMovement = $nextMove;
                $bestScore = $score;
            }
        }

        return $bestMovement;
    }

    private function calculateMovementScore(DefaultMap $map, string $playerUnit, int $currentScore)
    {
        if ($map->hasWinner() || $map->isTie() ) {
            if ($map->getWinnerPlayer() == $this->getOpponentPlayerUnit()) {
                return ($currentScore - 10) ;
            }

            if ($map->getWinnerPlayer() == $this->getBotPlayerUnit()) {
                return (10 - $currentScore);
            }

            return 0;
        }

        $allPossibleNextMove = $map->getEmptySpots();

        $playerUnitToSimulateNextMovement = $playerUnit == $this->getBotPlayerUnit()
            ? $this->getOpponentPlayerUnit()
            : $this->getBotPlayerUnit();

        $bestScoreToComputerWin = PHP_INT_MIN;
        $bestScoreToPlayerLose = PHP_INT_MAX;

        foreach ($allPossibleNextMove as $i => $nextMove) {
            $tempBoard = $map->simulateMapWithNextMove($nextMove, $playerUnitToSimulateNextMovement);
            $movementScore = self::calculateMovementScore($tempBoard, $playerUnitToSimulateNextMovement, $currentScore + 1);

            if ($movementScore > $bestScoreToComputerWin) {
                $bestScoreToComputerWin = $movementScore;
            }
            if ($movementScore < $bestScoreToPlayerLose) {
                $bestScoreToPlayerLose = $movementScore;
            }

        }

        return $playerUnit == $this->getBotPlayerUnit()
            ? $bestScoreToPlayerLose
            : $bestScoreToComputerWin;
    }

}

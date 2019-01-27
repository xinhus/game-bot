<?php

namespace GameBot\TicTacToe\Exceptions;

use Throwable;

class NoMorePossibleMovementsException extends \InvalidArgumentException
{

    public function __construct($message = 'There is no more possible movements', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

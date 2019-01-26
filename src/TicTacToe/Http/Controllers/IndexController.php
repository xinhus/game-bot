<?php

namespace GameBot\TicTacToe\Http\Controllers;

use Laravel\Lumen\Routing\Controller;

class IndexController extends Controller
{

    public static function ticTacToeGame()
    {
        return view('index');
    }

}

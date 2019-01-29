<?php

namespace GameBot\TicTacToe\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class IndexController extends Controller
{

    public static function ticTacToeGame(Request $request)
    {
        $player = $request->get('player');
        $level = $request->get('level') == 'easy' ? 'easy' : 'hard';
        return view('tic-tac-toe', [
            'player' => $player,
            'level' => $level,
        ]);
    }

}

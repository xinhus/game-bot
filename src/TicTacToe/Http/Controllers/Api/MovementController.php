<?php

namespace GameBot\TicTacToe\Http\Controllers\Api;

use GameBot\TicTacToe\Exceptions\NoMorePossibleMovementsException;
use GameBot\TicTacToe\Service\MoveService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class MovementController extends Controller
{

    public function easyMove(Request $request): Response
    {
        $map = $request->json()->get('map');
        if (is_null($map)) {
            return self::createErrorResponse('Invalid json structure');
        }
        $playerUnit = $request->json()->get('playerUnit');
        if ($playerUnit != "X" && $playerUnit != "O") {
            return self::createErrorResponse('Invalid json structure');
        }

        $move = MoveService::getMoveService('easy');
        try {
            [$x, $y, $playerUnit1] = $move->makeMove($map, $playerUnit);
        } catch (NoMorePossibleMovementsException|\InvalidArgumentException $e) {
            return self::createErrorResponse($e->getMessage());
        }
        $response = [
            'x' => $x,
            'y' => $y,
            'playerUnit' => $playerUnit1,
        ];

        return response()
            ->json($response)
            ->setStatusCode(200);
    }

    private static function createErrorResponse(string $message): Response
    {
        return response()
            ->json([
                'error_message' => $message,
            ])
            ->setStatusCode(400);
    }

}

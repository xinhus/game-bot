<?php

namespace GameBot\TicTacToe\Http\Controllers\Api;

use GameBot\TicTacToe\Exceptions\NoMorePossibleMovementsException;
use GameBot\TicTacToe\Service\MoveService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class MovementController extends Controller
{

    public function easyLevelMovement(Request $request): Response
    {
        return self::processRequest($request, 'easy');
    }

    public function hardLevelMovement(Request $request): Response
    {
        return self::processRequest($request, 'hard');
    }

    private static function processRequest(Request $request, string $level): Response
    {
        $map = $request->json()->get('map');
        $playerUnit = $request->json()->get('playerUnit');
        if (!self::isValidRequest($playerUnit, $map)) {
            return self::createErrorResponse('Invalid json structure');
        }

        try {
            return self::getResponseToNextMovement($level, $map, $playerUnit);
        } catch (NoMorePossibleMovementsException|\InvalidArgumentException $e) {
            return self::createErrorResponse($e->getMessage());
        }

    }

    private static function isValidRequest(?string $playerUnit, ?array $map): bool
    {
        if ($playerUnit != "X" && $playerUnit != "O") {
            return false;
        }
        if (is_null($map)) {
            return false;
        }
        return true;
    }

    private static function getResponseToNextMovement($level, $map, $playerUnit): Response
    {
        $move = MoveService::getMoveService($level);
        [$x, $y, $playerUnit1] = $move->makeMove($map, $playerUnit);
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

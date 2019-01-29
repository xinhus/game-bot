<?php

namespace Test\GameBot\TicTacToe\Http\Controllers\Api;

use GameBot\TicTacToe\Http\Controllers\Api\MovementController;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class MovementControllerTest extends TestCase
{
    /** @var MovementController */
    private $controller;

    /**
     * @before
     */
    public function initialize()
    {
        $this->controller = new MovementController();
    }

    public function testValidRequest_shouldReturnSuccess()
    {
        $content = <<<JSON
{
	"map": [
		["", "", ""],
		["", "", ""],
		["", "", ""]
	],
	"playerUnit": "O"
}
JSON;
        $request = self::createRequest($content);

        $response = $this->controller->easyLevelMovement($request);
        $responseAsObject = json_decode($response->getContent());

        Assert::assertEquals(200, $response->getStatusCode());
        Assert::assertEquals('O', $responseAsObject->playerUnit);
        Assert::assertLessThan(3, $responseAsObject->x);
        Assert::assertLessThan(3, $responseAsObject->y);
        Assert::assertGreaterThanOrEqual(0, $responseAsObject->x);
        Assert::assertGreaterThanOrEqual(0, $responseAsObject->y);
    }

    public function getCasesToTestInvalidRequest() {

        $mapWithTieResult = <<<JSON
{
	"map": [
		["X", "O", "X"],
		["X", "X", "O"],
		["O", "X", "O"]
	],
	"playerUnit": "O"
}
JSON;

        $invalidRows = <<<JSON
{
	"map": [
		["X", "O", ""]
	],
	"playerUnit": "O"
}
JSON;

        $invalidColumns = <<<JSON
{
	"map": [
		["", ""],
		["", "", ""],
		["", "", ""]
	],
	"playerUnit": "O"
}
JSON;

        $invalidJson = <<<JSON
{
	"map": [
		["", ""],
		["", "", ""],
		["", "", ""],
	],
	"playerUnit": "O"
}
JSON;
        $invalidPlayerUnit = <<<JSON
{
	"map": [
		["", "", ""],
		["", "", ""],
		["", "", ""],
	],
	"playerUnit": "A"
}
JSON;
        $mapWithWinnerX = <<<JSON
{
	"map": [
		["", "O", "X"],
		["", "O", "X"],
		["", "", "X"]
	],
	"playerUnit": "O"
}
JSON;
        $mapWithWinnerO = <<<JSON
{
	"map": [
		["", "X", "O"],
		["", "X", "O"],
		["", "", "O"]
	],
	"playerUnit": "X"
}
JSON;
        $mapWithTieResult = <<<JSON
{
	"map": [
		["X", "O", "X"],
		["O", "O", "X"],
		["X", "X", "O"]
	],
	"playerUnit": "O"
}
JSON;

        return [
            [
                'json' => $mapWithTieResult,
                'expectedMessage' => 'There is no more possible movements',
            ],
            [
                'json' => $invalidRows,
                'expectedMessage' => 'Invalid map structure, the map should have 3 rows',
            ],
            [
                'json' => $invalidColumns,
                'expectedMessage' => 'Invalid map structure, the map should have 3 columns',
            ],
            [
                'json' => $invalidJson,
                'expectedMessage' => 'Invalid json structure',
            ],
            [
                'json' => $invalidPlayerUnit,
                'expectedMessage' => 'Invalid json structure',
            ],
            [
                'json' => $mapWithWinnerX,
                'expectedMessage' => 'The player "X" already won the game.',
            ],
            [
                'json' => $mapWithWinnerO,
                'expectedMessage' => 'The player "O" already won the game.',
            ],
            [
                'json' => $mapWithTieResult,
                'expectedMessage' => 'There is no more possible movements',
            ],
        ];
    }

    /**
     * @dataProvider getCasesToTestInvalidRequest
     * @param string $content
     * @param string $expectedMessage
     */
    public function testInvalidRequestWithEasyLevel_shouldReturnBadRequest(
        string $content,
        string $expectedMessage
    ): void {
        $request = self::createRequest($content);

        $response = $this->controller->easyLevelMovement($request);
        self::assertRequestIsAsExpected($expectedMessage, $response);
    }

    /**
     * @dataProvider getCasesToTestInvalidRequest
     * @param string $content
     * @param string $expectedMessage
     */
    public function testInvalidRequestWithHardLevel_shouldReturnBadRequest(
        string $content,
        string $expectedMessage
    ): void {
        $request = self::createRequest($content);

        $response = $this->controller->hardLevelMovement($request);
        self::assertRequestIsAsExpected($expectedMessage, $response);
    }

    private static function createRequest(string $content): Request
    {
        return $request = new Request([], [], [], [], [], [], $content);
    }

    private static function assertRequestIsAsExpected(string $expectedMessage, Response $response): void
    {
        $responseAsObject = json_decode($response->getContent());

        Assert::assertEquals(400, $response->getStatusCode());
        Assert::assertEquals($expectedMessage, $responseAsObject->error_message);
    }
}

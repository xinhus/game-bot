<?php

namespace Test\GameBot\TicTacToe\Http\Controllers\Api;

use GameBot\TicTacToe\Http\Controllers\Api\MovementController;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

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
        $request = new Request([], [], [], [], [], [], $content);

        $response = $this->controller->easyMove($request);
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

        return [
            ['json' => $mapWithTieResult, 'expectedMessage' => 'There is no more possible movements',],
            ['json' => $invalidRows, 'expectedMessage' => 'Invalid map structure, the map should have 3 rows',],
            ['json' => $invalidColumns, 'expectedMessage' => 'Invalid map structure, the map should have 3 columns',],
            ['json' => $invalidJson, 'expectedMessage' => 'Invalid json structure',],
            ['json' => $invalidPlayerUnit, 'expectedMessage' => 'Invalid json structure',],
        ];
    }

    /**
     * @dataProvider getCasesToTestInvalidRequest
     * @param string $content
     * @param string $expectedMessage
     */
    public function testInvalidRequest_shouldReturnBadRequest(string $content, string $expectedMessage)
    {
        $request = new Request([], [], [], [], [], [], $content);

        $response = $this->controller->easyMove($request);
        $responseAsObject = json_decode($response->getContent());

        Assert::assertEquals(400, $response->getStatusCode());
        Assert::assertEquals($expectedMessage, $responseAsObject->error_message);
    }
}

<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->get('/', 'IndexController@ticTacToeGame');

$router->post('/api/easy/nextMovement', 'Api\MovementController@easyLevelMovement');
$router->post('/api/hard/nextMovement', 'Api\MovementController@hardLevelMovement');

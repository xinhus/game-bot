<?php

/** @var Laravel\Lumen\Routing\Router $router */

$router->get('/', 'IndexController@ticTacToeGame');

$router->post('/api/easy/nextMovement', 'Api\MovementController@easyMove');

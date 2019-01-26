<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->router->group(
    ['namespace' => 'GameBot\TicTacToe\Http\Controllers'],
    function ($router) {
        require __DIR__ . '/../routes/web.php';
    }
);
return $app;

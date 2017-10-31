<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\AppController;

// Routes

/*$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->view->render($response, 'index.html', $args);
});*/

$app->get('/', AppController::class.':index');

$app->get('/main', AppController::class.':main');

$app->post('/login', AppController::class.':login');

$app->get('/logout', AppController::class.':logout');
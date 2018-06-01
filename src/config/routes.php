<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\AppController;

// Routes

$app->get('/', AppController::class.':index');

$app->get('/login', AppController::class.':showLoginPage');

$app->post('/login', AppController::class.':doLogin');

$app->get('/logout', AppController::class.':logout');

$app->get('/add', AppController::class.':showAddKnowledgePage');

$app->post('/add', AppController::class.':addKnowledge');

$app->get('/my-data', AppController::class.':myData');

$app->get('/ranking', AppController::class.':ranking');

$app->get('/page/{slug}', AppController::class.':showKnowledge');

$app->get('/edit/{knowledge_id}', AppController::class.':showEditKnowledgePage');

$app->post('/edit/{knowledge_id}', AppController::class.':updateKnowledge');

$app->post('/uploadImages', AppController::class.':uploadImages');
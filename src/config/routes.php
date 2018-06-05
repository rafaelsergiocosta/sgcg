<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\AppController;
use App\Controller\UserController;
use App\Controller\KnowledgeController;

// Routes

$app->get('/', AppController::class.':index');

$app->get('/login', AppController::class.':showLoginPage');

$app->post('/login', UserController::class.':doLogin');

$app->get('/logout', UserController::class.':logout');

$app->get('/add', KnowledgeController::class.':showAddKnowledgePage');

$app->post('/add', KnowledgeController::class.':addKnowledge');

$app->get('/my-data', UserController::class.':myData');

$app->get('/ranking', UserController::class.':ranking');

$app->get('/page/{slug}', KnowledgeController::class.':showKnowledge');

$app->get('/edit/{knowledge_id}', KnowledgeController::class.':showEditKnowledgePage');

$app->post('/edit/{knowledge_id}', KnowledgeController::class.':updateKnowledge');

$app->post('/uploadImages', KnowledgeController::class.':uploadImages');
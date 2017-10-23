<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AppController
{
    protected $db;
    private $logger;
    private $view;
    
    public function __construct($c)
    {
        $this->db = $c->db;
        $this->logger = $c->logger;
        $this->view = $c->view;
    }

    public function index(Request $request, Response $response, array $args)
    {
        $args['name'] = 'Teste';
        return $this->view->render($response, 'index.html', $args);
    }
}
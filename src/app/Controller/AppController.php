<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\Knowledge;
use App\Model\Category;
use App\Model\User;

class AppController
{
    protected $db;
    protected $logger;
    protected $view;
    protected $flash;
    
    public function __construct($c)
    {
        $this->db = $c->db;
        $this->logger = $c->logger;
        $this->view = $c->view;
        $this->flash = $c->flash;
    }

    public function index(Request $request, Response $response, array $args)
    {
        $args['messages'] = $this->flash->getMessages();
        $args['knowledge'] = Knowledge::with('Category', 'User')->get()->toArray();
        return $this->view->render($response, 'index.html', $args);
    }

    public function showLoginPage(Request $request, Response $response, array $args)
    {
        $args['messages'] = $this->flash->getMessages();
        return $this->view->render($response, 'login.html', $args);
    }
}
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

    public function home(Request $request, Response $response, array $args)
    {
        $user = $this->db->table('users')->where('id', '1')->first();
        $args['name'] = $user->name;
        return $this->view->render($response, 'home.html', $args);
    }

    public function index(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'index.html', $args);
    }

    public function login(Request $request, Response $response, array $args)
    {
        $args = $request->getParams();
        $user = $this->db->table('users')->where('login', $args['login'])->first();
        if (password_verify($args['password'], $user->password)) {
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['login'] = $user->login;
            return $this->view->render($response, 'home.html', $args);
        } else {
            return $this->view->render($response, 'index.html', $args);
        }
    }

    public function logout(Request $request, Response $response, array $args)
    {
        session_destroy();
        return $this->view->render($response, 'login.html', $args);
    }

    public function newPage(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'newPage.html', $args);
    }
}
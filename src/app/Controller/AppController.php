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

    public function showLoginPage(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'login.html', $args);
    }

    public function doLogin(Request $request, Response $response, array $args)
    {
        $args = $request->getParams();
        $user = $this->db->table('users')->where('login', $args['login'])->first();
        if (password_verify($args['password'], $user->password)) {
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['login'] = $user->login;
            return $response->withRedirect("/");
        } else {
            return $response->withRedirect("/login");
        }
    }

    public function logout(Request $request, Response $response, array $args)
    {
        session_destroy();
        return $response->withRedirect("/login");
    }

    public function addKnowledge(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'add.html', $args);
    }

    public function myData(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'my-data.html', $args);
    }

    public function ranking(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'ranking.html', $args);
    }
}
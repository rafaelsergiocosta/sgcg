<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\User;

class UserController extends AppController
{
    public function doLogin(Request $request, Response $response, array $args)
    {
        $args = $request->getParams();
        $user = User::where('login', $args['login'])->first();
        if (password_verify($args['password'], $user->password)) {
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['login'] = $user->login;
            return $response->withRedirect("/");
        } else {
            $this->flash->addMessage('error', "Usuário ou senha incorreta!");
            return $response->withRedirect("/login");
        }
    }

    public function logout(Request $request, Response $response, array $args)
    {
        session_destroy();
        return $response->withRedirect("/login");
    }

    public function myData(Request $request, Response $response, array $args)
    {
        $args['user'] = User::find($_SESSION['user']['id']);
        return $this->view->render($response, 'my-data.html', $args);
    }

    public function ranking(Request $request, Response $response, array $args)
    {
        $args['user'] = User::find($_SESSION['user']['id']);
        return $this->view->render($response, 'ranking.html', $args);
    }
}
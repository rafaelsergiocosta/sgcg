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
        $args['knowledge'] = $this->getKnowledge();
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

    public function showAddKnowledgePage(Request $request, Response $response, array $args)
    {
        $args['categories'] = $this->getCategories();
        return $this->view->render($response, 'add.html', $args);
    }

    public function addKnowledge(Request $request, Response $response, array $args)
    {
        $args = $request->getParams();

        if (!empty($args)) {
            $category = $this->db->table('categories')->where('id', $args['category'])->first();

            $user = $this->db->table('users')->where('id', $_SESSION['user']['id'])->first();

            $saved = $this->db->table('knowledge')->insert(
                [
                    'title' => $args['title'],
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'slug' => $args['slug'],
                    'keywords' => $args['keywords'],
                    'content' => $args['cognitio'],
                    'status' => '1'
                ]
            );

            if (!empty($saved)) {
                return $response->withRedirect("/");
            }
        }
        
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

    public function showKnowledge(Request $request, Response $response, array $args)
    {
        $args['knowledge'] = $this->getKnowledgeSlug($args['slug']);
        return $this->view->render($response, 'knowledge.html', $args);
    }

    private function getCategories()
    {
        $categories = $this->db->table('categories')->get();
        if(!empty($categories)) {
            return $categories->toArray();
        } else {
            return false;
        }
    }

    private function getKnowledge()
    {
        $knowledge = $this->db->table('knowledge')->where('status', '1')->get();
        if(!empty($knowledge)) {
            foreach($knowledge as &$cognitio) {
                $cognitio->category = $this->db->table('categories')->where('id', $cognitio->category_id)->value('name');
                $cognitio->author = $this->db->table('users')->where('id', $cognitio->user_id)->value('name');
            }
            return $knowledge->toArray();
        } else {
            return false;
        }
    }

    private function getKnowledgeSlug($slug)
    {
        $knowledge = $this->db->table('knowledge')->where('slug', $slug)->first();
        if(!empty($knowledge)) {
            return $knowledge;
        } else {
            return false;
        }
    }
}
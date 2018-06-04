<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\User;
use App\Model\Knowledge;
use App\Model\Category;

class KnowledgeController extends AppController
{
    public function showAddKnowledgePage(Request $request, Response $response, array $args)
    {
        $args['categories'] = Category::all();
        return $this->view->render($response, 'add.html', $args);
    }

    public function addKnowledge(Request $request, Response $response, array $args)
    {
        $args = $request->getParams();

        if (!empty($args)) {
            $category = Category::find($args['category']);

            $user = User::find($_SESSION['user']['id']);

            $knowledge = new Knowledge();
            $knowledge->title = $args['title'];
            $knowledge->user_id = $user->id;
            $knowledge->category_id = $category->id;
            $knowledge->slug = $args['slug'];
            $knowledge->keywords = $args['keywords'];
            $knowledge->content = $args['cognitio'];
            $knowledge->status = '1';

            if ($knowledge->save()) {
                $score = $this->setScore('add', $user);
                $args['score'] = $score;
                $args['knowledge'] = Knowledge::with('Category', 'User')->get()->toArray();
                return $this->view->render($response, 'index.html', $args);
            }
        }
        
        return $this->view->render($response, 'add.html', $args);
    }

    public function showKnowledge(Request $request, Response $response, array $args)
    {
        $args['knowledge'] = Knowledge::where('slug', $args['slug'])->first();
        return $this->view->render($response, 'knowledge.html', $args);
    }

    public function showEditKnowledgePage(Request $request, Response $response, array $args)
    {
        $args['knowledge'] = Knowledge::find($args['knowledge_id']);
        $args['categories'] = Category::all();
        return $this->view->render($response, 'edit.html', $args);
    }

    public function updateKnowledge(Request $request, Response $response, array $args)
    {
        $args = array_merge($args, $request->getParams());

        $knowledge = Knowledge::find($args['knowledge_id']);

        $category = Category::find($args['category']);

        if (!empty($knowledge)) {
            $knowledge->title = $args['title'];
            $knowledge->category_id = $category->id;
            $knowledge->slug = $args['slug'];
            $knowledge->keywords = $args['keywords'];
            $knowledge->content = $args['cognitio'];
            $knowledge->status = '1';

            if ($knowledge->save()) {
                return $response->withRedirect("/");
            }
        }
    }

    private function setScore($type, $user)
    {
        $gameScore = $this->db->table('gamification_scores')->where('gameType', $type)->first();
        if (!empty($gameScore->score)) {
            $userScore = $user->score + $gameScore->score;
            $this->db->table('users')->where('id', $user->id)->update(['score' => $userScore]);
            return $gameScore->score;
        } else {
            return false;
        }
    }
}
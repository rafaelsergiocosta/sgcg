<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Service\Gamification;
use App\Helper\FileHelper;
use App\Model\Knowledge;
use App\Model\Category;
use App\Model\User;

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
                $score = Gamification::setScore('add', $user);
                $this->flash->addMessage('success', "Você conquistou $score pontos!");
                return $response->withRedirect("/");
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

        $user = User::find($_SESSION['user']['id']);

        if (!empty($knowledge)) {
            $knowledge->title = $args['title'];
            $knowledge->category_id = $category->id;
            $knowledge->slug = $args['slug'];
            $knowledge->keywords = $args['keywords'];
            $knowledge->content = $args['cognitio'];
            $knowledge->status = '1';

            if ($knowledge->save()) {
                $score = Gamification::setScore('edit', $user);
                $this->flash->addMessage('success', "Você conquistou $score pontos!");
                return $response->withRedirect("/");
            }
        }
    }

    public function uploadImages(Request $request, Response $response, array $args)
    {
        $directory = realpath('./uploads');
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['file'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = FileHelper::moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
        }
        return $response->withJson(['location' => $filename]);
    }

    public function removeKnowledge(Request $request, Response $response, array $args)
    {
        $knowledge = Knowledge::find($args['knowledge_id']);
        if ($knowledge->delete()) {
            $this->flash->addMessage('success', "Removido com sucesso!");
        } else {
            $this->flash->addMessage('error', "Não foi possível remover!");
        }
        return $response->withRedirect("/");
    }
}
<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile;
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
                $score = GamificationController::setScore('add', $user);
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

    public function uploadImages(Request $request, Response $response, array $args)
    {
        $directory = realpath('./uploads');
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['file'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
        }
        return $response->withJson(array('location' => $filename));
    }

    private function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
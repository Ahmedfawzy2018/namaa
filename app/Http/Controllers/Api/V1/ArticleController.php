<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index(Request $request, ArticleService $articleService)
    {
        return $articleService->list($request);
    }


    public function store(CreateArticleRequest $request, ArticleService $articleService)
    {
        return $articleService->store($request);
    }


    public function show($id, ArticleService $articleService)
    {
        return $articleService->show($id);
    }


    public function update($id, UpdateArticleRequest $request, ArticleService $articleService)
    {
        return $articleService->update($id, $request);
    }


    public function destroy($id, ArticleService $articleService)
    {
        return $articleService->destroy($id);
    }

    public function comment($id, AddCommentRequest $request, ArticleService $articleService)
    {
        return $articleService->addComment($id, $request);
    }

    public function approve($id, ArticleService $articleService)
    {
        return $articleService->approveArticle($id);
    }
}

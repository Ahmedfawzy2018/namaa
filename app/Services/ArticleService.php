<?php

namespace App\Services;
use App\Events\NotifyAdminEvent;
use App\Http\Resources\ArticlesResource;
use App\Models\Article;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleService
{
    use ApiResponseTrait;

    public $user;
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function list($request)
    {
        try {
           $articles = Article::where('added_by', $this->user->id)
               ->filter($request)->paginate($request->limit ?? 20);
           return $this->respond([
              'records' => ArticlesResource::collection($articles),
               'total' => $articles->total(),
           ]);
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            Log::info("Received request to create article", ['data' => $data]);
            $data['added_by'] = $this->user->id;
            $article = Article::create($data);
            event(new NotifyAdminEvent($article));
            DB::commit();

            return $this->respondCreated();
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            if (!$article = Article::where('added_by', $this->user->id)
                ->whereId($id)
                ->first() ) {
                return $this->respondBadRequest('Article not found.');
            }

            return $this->respond(new ArticlesResource($article));
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }

    public function update($id, $request)
    {
        try {
            $data = $request->validated();
            Log::info("Received request to update article", ['data' => $data]);
            if (!$article = Article::where('added_by', $this->user->id)
                ->whereId($id)
                ->first() ) {
                return $this->respondBadRequest('Article not found.');
            }

            $article->update($data);

            return $this->respondCreated();
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Log::info("Received request to delete article id: {$id}", ['user' => $this->user]);
            if (!$article = Article::where('added_by', $this->user->id)
                ->whereId($id)
                ->first() ) {
                return $this->respondBadRequest('Article not found.');
            }

            DB::beginTransaction();
            $article->comments()->delete();
            $article->delete();
            DB::commit();

            return $this->respondDeleted();
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }

    public function addComment($id, $request) {
        try {
            Log::info("Received request to add comment on article id: {$id}", ['user' => $this->user]);
            if (!$article = Article::where('added_by', $this->user->id)
                ->whereId($id)
                ->first() ) {
                return $this->respondBadRequest('Article not found.');
            }

            $article->comments()->create([
                'added_by' => $this->user->id,
                'comment' => $request->get('comment')
            ]);

            return $this->respondCreated();
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }

    public function approveArticle($id) {
        try {
            Log::info("Received request to approve article id: {$id}", ['user' => $this->user]);
            if (!$article = Article::where('added_by', $this->user->id)
                ->where('status', Article::PENDING)
                ->whereId($id)
                ->first() ) {

                return $this->respondBadRequest('Article not found.');
            }

            $article->update([
                'status' => Article::APPROVED
            ]);

            return $this->respondCreated();
        } Catch(\Exception $e) {
            DB::rollBack();
            return $this->respondBadRequest($e->getMessage());
        }
    }
}

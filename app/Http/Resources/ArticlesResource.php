<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class ArticlesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return Cache::rememberForever("article_{$this->id}",
            function () {
                return [
                    'id' => $this->id,
                    'title' => $this->title,
                    'content' => $this->content,
                    'status' => Article::STATUS_MAPPING[$this->status],
                    'addedBy' => new UserResource($this->addedBy),
                    'comments' => CommentsResource::collection($this->comments),
                ];
            });
    }
}

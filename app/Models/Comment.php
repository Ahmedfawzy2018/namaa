<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';
    protected $fillable = [
        'article_id',
        'added_by',
        'comment',
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}

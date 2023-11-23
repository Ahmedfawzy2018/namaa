<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';
    protected $fillable = [
        'added_by',
        'title',
        'content',
        'status'
    ];

    const PENDING = 0;
    const APPROVED = 1;
    const REJECTED = 2;

    const STATUS_MAPPING = [
        0 => 'Under Review',
        1 => 'Approved',
        2 => 'Rejected'
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    public function scopeFilter($query, $request)
    {
        if ($request->has('search')) {
            $query->where(function ($q) use ($request){
                $q->where('title', 'like', $request->get('search'))->OrWhere('content', 'like', $request->get('search'));
            }) ;
        }
        return $query;
    }
}

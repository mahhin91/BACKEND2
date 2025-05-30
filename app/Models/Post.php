<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'category_id', 'status', 'rejection_reason', 'published_at', 'thumbnail', 'content', 'views'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reactions()
    {
        return $this->hasMany(PostReaction::class);
    }

    public function likes()
    {
        return $this->reactions()->where('reaction_type', 'like')->count();
    }

    public function dislikes()
    {
        return $this->reactions()->where('reaction_type', 'dislike')->count();
    }

    public function userReaction()
    {
        return $this->reactions()->where('user_id', auth()->id())->first();
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostStatus extends Model
{
    /** @use HasFactory<\Database\Factories\PostStatusFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the posts for the post status.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'status_id');
    }
}

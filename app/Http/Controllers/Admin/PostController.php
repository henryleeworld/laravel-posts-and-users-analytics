<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters([
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('title', 'like', "%{$value}%")
                              ->orWhere('content', 'like', "%{$value}%")
                              ->orWhereHas('author', function ($query) use ($value) {
                                  $query->where('name', 'like', "%{$value}%");
                              });
                    });
                }),

                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::exact('user_id'),

                AllowedFilter::callback('published_after', function ($query, $value) {
                    $query->where('published_at', '>=', $value);
                }),
                AllowedFilter::callback('published_before', function ($query, $value) {
                    $query->where('published_at', '<=', $value);
                }),

                AllowedFilter::scope('published'),
                AllowedFilter::scope('featured'),
            ])
            ->allowedSorts([
                'title',
                'created_at', 
                'published_at',
                'status_id',
                'category_id',
                'user_id'
            ])
            ->allowedIncludes(['author', 'category', 'status'])
            ->defaultSort('-created_at')
            ->with(['author', 'category', 'status'])
            ->paginate(15)
            ->appends(request()->query());

        $statuses = PostStatus::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $authors = User::whereIn('role_id', [2, 3])->orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'statuses', 'categories', 'authors'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['author', 'category', 'status']);
        
        return view('admin.posts.show', compact('post'));
    }
}

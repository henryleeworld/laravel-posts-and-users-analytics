<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewStats = $this->getViewStats();
        $topPosts = $this->getTopPosts();
        $recentViews = $this->getRecentViews();
        
        return view('admin.analytics.index', compact('viewStats', 'topPosts', 'recentViews'));
    }
    
    private function getViewStats(): array
    {
        $now = Carbon::now();
        
        return [
            'last_7_days' => Cache::remember('viewInTheLast7days', now()->addHour(), function () use ($now) {
                return PostView::where('viewed_at', '>=', $now->copy()->subDays(7))->count();
            }),
            'last_30_days' => Cache::remember('viewInTheLast30days', now()->addHour(), function () use ($now) {
                return PostView::where('viewed_at', '>=', $now->copy()->subDays(30))->count();
            }),
            'last_90_days' => Cache::remember('viewInTheLast90days', now()->addHour(), function () use ($now) {
                return PostView::where('viewed_at', '>=', $now->copy()->subDays(90))->count();
            })
        ];
    }
    
    private function getTopPosts()
    {
        return Cache::remember('topPosts', now()->addHour(), function () {
            return Post::select(['posts.id', 'posts.title', 'posts.excerpt', 'posts.user_id', 'posts.category_id', DB::raw('COUNT(post_views.id) as views_count')])
                ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
                ->where('post_views.viewed_at', '>=', Carbon::now()->subDays(30))
                ->with(['user', 'category', 'status'])
                ->groupBy('posts.id', 'posts.title', 'posts.excerpt', 'posts.user_id', 'posts.category_id')
                ->orderByDesc('views_count')
                ->limit(5)
                ->get();
        });
    }
    
    private function getRecentViews()
    {
        return Cache::remember('recentViews', now()->addHour(), function () {
            return PostView::with(['post', 'user'])
                ->orderByDesc('viewed_at')
                ->limit(20)
                ->get();
        });
    }
}

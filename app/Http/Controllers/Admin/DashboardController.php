<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status_id', 1)->count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status_id', 2)->count(),
            'draft_posts' => Post::where('status_id', 1)->count(),
        ];

        $recentUsers = User::with(['role', 'status'])
            ->latest()
            ->take(5)
            ->get();

        $recentPosts = Post::with(['author', 'category', 'status'])
            ->latest()
            ->take(5)
            ->get();

        $postsByStatus = Post::select('status_id', DB::raw('count(*) as total'))
            ->with('status')
            ->groupBy('status_id')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentPosts', 'postsByStatus'));
    }
}

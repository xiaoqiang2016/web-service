<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Product;
use App\Models\CaseModel;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'products' => Product::count(),
            'cases' => CaseModel::count(),
            'messages' => Message::where('status', 0)->count(),
        ];

        $recentMessages = Message::orderBy('created_at', 'desc')->take(5)->get();
        $recentArticles = Article::with('translation')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentArticles'));
    }
}

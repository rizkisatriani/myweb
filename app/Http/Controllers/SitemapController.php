<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Blog;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $blogs = Blog::whereNotNull('published_at')->orderByDesc('published_at')->get();

        $content = view('sitemap', compact('blogs'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}

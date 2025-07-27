<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('published_at', 'desc')->paginate(6);
        return view('indexblog', [
        'breadCrumb' => 'Blog',
        'title' => 'Blog Artikel',
        'subtitle' => 'Kumpulan artikel bermanfaat tentang teknologi, alat online, dan solusi digital 🚀',
        'actionUrl' => null,
        'blogs' => $blogs, // Tambahan ini
    ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
                return view('showblog', [
        'breadCrumb' => 'Blog',
        'title' => $blog->title,
        'subtitle' => $blog->title,
        'actionUrl' => null,
        'blog' => $blog, // Tambahan ini
    ]);
    }
}

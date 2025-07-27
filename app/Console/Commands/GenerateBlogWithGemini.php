<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GeminiService;
use App\Models\Blog;
use Illuminate\Support\Str;

class GenerateBlogWithGemini extends Command
{
    protected $signature = 'blog:generate {prompt : Prompt untuk Gemini} {--user=1}';
    protected $description = 'Generate blog post using Gemini API and insert into database';

    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        parent::__construct();
        $this->gemini = $gemini;
    }

    public function handle(): int
    {
        $prompt = $this->argument('prompt');
        $userId = $this->option('user');

        $this->info("Generating blog for prompt: \"$prompt\"...");

        $content = $this->gemini->generateContent($prompt);

        if (!$content) {
            $this->error("Failed to get content from Gemini.");
            return 1;
        }

        $title = Str::limit(strip_tags($prompt), 50);
        $slug = Str::slug($title) . '-' . Str::random(5);

        $blog = Blog::create([
            'title' => $title,
            'slug' => $slug,
            'excerpt' => Str::limit(strip_tags($content), 150),
            'content' => $content,
            'user_id' => $userId,
            'published_at' => now(),
        ]);

        $this->info("Blog created with ID: {$blog->id}");
        return 0;
    }
}

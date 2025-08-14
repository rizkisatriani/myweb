<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GeminiService;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenerateDailyBlogWithGemini extends Command
{
    protected $signature = 'blog:generate-daily {--user=1}';
    protected $description = 'Generate one blog post daily using Gemini, avoiding duplicate topics';

    protected $tema = [
        // Tetap relevan (Teknologi Umum & AI)
        "Teknologi",
        "Artificial Intelligence",
        "Machine Learning",
        "Deep Learning",
        "Neural Networks",
        "Natural Language Processing",
        "Computer Vision",
        "AI Ethics",
        "Generative AI",
        "Prompt Engineering",

        // Tetap relevan (Hardware & IoT)
        "Robotics",
        "Drone Technology",
        "Cybersecurity",
        "Hukum Siber",
        "Etika Digital",
        "IoT (Internet of Things)",
        "Smart Cities",
        "Smart Home",

        // Ganti jadi relevan ke dokumen
        "PDF Tools",
        "Word to PDF",
        "JPG to PDF",
        "Image Converter",
        "Document Scanner",
        "Online OCR",
        "File Compression",
        "PDF Merge",
        "PDF Split",
        "QR Code Generator",

        // Tetap relevan (Cloud & Data)
        "Cloud Computing",
        "Edge Computing",
        "Big Data",
        "Data Science",
        "Data Engineering",

        // Ganti jadi relevan (File Management)
        "File Security",
        "Document Encryption",
        "Digital Signature",
        "Watermark Tools",
        "Online Notepad",

        // Tetap relevan (AR, VR, Blockchain)
        "Augmented Reality",
        "Virtual Reality",
        "Blockchain",
        "Cryptocurrency",

        // Tetap relevan (Bisnis Tech)
        "FinTech",
        "EduTech",
        "Startup Teknologi",
        "SaaS (Software as a Service)",
        "PaaS",

        // Ganti jadi relevan (Tools Praktis)
        "Image Resizer",
        "Text to PDF",
        "HTML to PDF",
        "PPT to PDF",
        "Excel to PDF",
        "E-signature Tools"
    ];

    public function handle(GeminiService $gemini)
    {
        $userId = $this->option('user');
        $usedThemes = Blog::whereDate('created_at', Carbon::today())->pluck('title')->toArray();

        // Filter tema yang belum digunakan hari ini
        $unusedThemes = array_filter($this->tema, function ($tema) use ($usedThemes) {
            return !Str::contains(implode(' ', $usedThemes), $tema);
        });

        if (empty($unusedThemes)) {
            $this->error('All topics have been used today.');
            return 1;
        }

        $temaAcak = $unusedThemes[array_rand($unusedThemes)];
        [$kategori, $featuredImage] = $this->getKategoriDanGambar($temaAcak);
        $bahasa = rand(0, 1) ? 'id' : 'en';
        // $prompt = sprintf(
        //     "Generate an SEO-optimized, engaging, and potentially viral blog article based on the latest news in the theme of \"%s\". The article should include:\n\n" .
        //     "- A catchy title (Output format: Title: <title>)\n" .
        //     "- Well-structured content (Output format: Content: <body>)\n\n" .
        //     "The article must be around 800–1000 words, easy to read, include headings (H1, H2, H3 if needed), a captivating introduction, informative body, and strong conclusion that invites readers to interact or share. Only output the text with 'Title:' and 'Content:' as strict labels, with no additional formatting or symbols.",
        //     $temaAcak
        // );
        $prompt = $bahasa === 'id'
            ? sprintf(
                "Buatkan artikel blog yang dioptimalkan untuk SEO, menarik, dan berpotensi viral berdasarkan berita terbaru dengan tema \"%s\".\n\n" .
                    "- Judul yang menarik (Format output: Title: <judul>)\n" .
                    "- Konten yang tersusun baik (Format output: Content: <isi>)\n\n" .
                    "Artikel sekitar 800–1000 kata, mudah dibaca, memiliki heading (H1, H2, H3 jika perlu), pembukaan yang memikat, isi informatif, dan kesimpulan kuat yang mengajak pembaca untuk berinteraksi atau membagikan. Output hanya teks dengan label 'Title:' dan 'Content:' tanpa simbol atau format tambahan.",
                $temaAcak
            )
            : sprintf(
                "Generate an SEO-optimized, engaging, and potentially viral blog article based on the latest news in the theme of \"%s\". The article should include:\n\n" .
                    "- A catchy title (Output format: Title: <title>)\n" .
                    "- Well-structured content (Output format: Content: <body>)\n\n" .
                    "The article must be around 800–1000 words, easy to read, include headings (H1, H2, H3 if needed), a captivating introduction, informative body, and strong conclusion that invites readers to interact or share. Only output the text with 'Title:' and 'Content:' as strict labels, with no additional formatting or symbols.",
                $temaAcak
            );
        $this->info("Generating article for topic: $temaAcak");

        $response = $gemini->generateContent($prompt);

        if (!$response) {
            $this->error('Gemini API did not return content.');
            return 1;
        }

        // Parse Gemini response
        if (!Str::contains($response, 'Title:') || !Str::contains($response, 'Content:')) {
            $this->error('Gemini response format invalid.');
            return 1;
        }

        [$judulRaw, $isiRaw] = explode("Content:", $response, 2);
        $judul = trim(Str::replaceFirst('Title:', '', $judulRaw));
        $isi = trim($isiRaw);

        $slug = Str::slug($judul) . '-' . Str::random(5);

        $blog = \App\Models\Blog::create([
            'title' => $judul,
            'slug' => $slug,
            'excerpt' => Str::limit(strip_tags($isi), 150),
            'content' => $this->convertToHtml($isi),
            'user_id' => $userId,
            'featured_image' => $featuredImage,
            'published_at' => now(),
        ]);

        $this->info("Blog created with ID: {$blog->id}, Title: $judul");
        return 0;
    }

    protected function getKategoriDanGambar(string $tema): array
    {
        return match (true) {
            // AI & Machine Learning
            in_array($tema, [
                "Artificial Intelligence",
                "Machine Learning",
                "Deep Learning",
                "Neural Networks",
                "Natural Language Processing",
                "Computer Vision",
                "AI Ethics",
                "Generative AI",
                "Prompt Engineering"
            ]) =>
            ["AI & Machine Learning", "https://toolsborg.com/img/ai.png"],

            // Cybersecurity & Privacy
            in_array($tema, [
                "Cybersecurity",
                "Hukum Siber",
                "Etika Digital",
                "File Security",
                "Document Encryption",
                "Digital Signature"
            ]) =>
            ["Cybersecurity & Privacy", "https://toolsborg.com/img/cybersecurity.png"],

            // Document & File Tools
            in_array($tema, [
                "PDF Tools",
                "Word to PDF",
                "JPG to PDF",
                "Image Converter",
                "Document Scanner",
                "Online OCR",
                "File Compression",
                "PDF Merge",
                "PDF Split",
                "QR Code Generator",
                "Image Resizer",
                "Text to PDF",
                "HTML to PDF",
                "PPT to PDF",
                "Excel to PDF",
                "Online Notepad"
            ]) =>
            ["Document & File Tools", "https://toolsborg.com/img/document.png"],

            // File Security & Signing
            in_array($tema, [
                "Watermark Tools",
                "E-signature Tools"
            ]) =>
            ["File Security & Signing", "https://toolsborg.com/img/security.png"],

            // Web & App Development
            in_array($tema, [
                "Programming",
                "Open Source",
                "Backend Development",
                "Frontend Development",
                "Fullstack Development",
                "Mobile Development",
                "Game Development"
            ]) =>
            ["Web & App Development", "https://toolsborg.com/img/dev.png"],

            // Blockchain & Web3
            in_array($tema, [
                "Blockchain",
                "Cryptocurrency"
            ]) =>
            ["Blockchain & Web3", "https://toolsborg.com/img/blockchain.png"],

            // Hardware & Devices
            in_array($tema, [
                "Robotics",
                "Drone Technology",
                "IoT (Internet of Things)",
                "Smart Cities",
                "Smart Home"
            ]) =>
            ["Hardware & Devices", "https://toolsborg.com/img/hardware.png"],

            // Business Tech
            in_array($tema, [
                "FinTech",
                "EduTech",
                "Startup Teknologi",
                "SaaS (Software as a Service)",
                "PaaS"
            ]) =>
            ["Business Tech", "https://toolsborg.com/img/business.png"],

            // Emerging Technologies
            in_array($tema, [
                "Cloud Computing",
                "Edge Computing",
                "Big Data",
                "Data Science",
                "Data Engineering"
            ]) =>
            ["Emerging Technologies", "https://toolsborg.com/img/emerging.png"],

            // Default fallback
            default =>
            ["General Tech", "https://toolsborg.com/img/general.png"],
        };
    }
    protected function convertToHtml(string $isi, ?string $imageURL = null): string
    {
        $html = '';

        if (!empty($imageURL)) {
            $html .= sprintf(
                '<img src="%s" alt="Gambar Artikel" style="max-width:100%%; height:auto; display:block; margin:20px 0;">',
                $imageURL
            );
        }

        // Heading
        $isi = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $isi);
        $isi = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $isi);
        $isi = preg_replace('/^# (.*)$/m', '<h1>$1</h1>', $isi);

        // Bold
        $isi = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $isi);

        // Newlines ke <br>
        $isi = nl2br($isi);

        $html .= $isi;

        return $html;
    }
}

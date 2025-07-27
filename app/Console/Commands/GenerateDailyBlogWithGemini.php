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
        "Teknologi",
        "Ekonomi",
        "Sosial",
        "Budaya",
        "Entertaiment",
        "Kesehatan",
        "Lifestyle",
        "Fashion",
        "Parenting",
        "Inovasi",
        "Lingkungan",
        "Politik",
        "Pendidikan",
        "Karier",
        "Psikologi",
        "Keamanan Siber",
        "Startup",
        "Travel",
        "Kuliner",
        "Olahraga",
        "Digital Marketing",
        "AI",
        "Crypto",
        "Gaming",
        "Film",
        "Musik",
        "Seni",
        "Fotografi",
        "Self Improvement",
        "Spiritualitas",
        "Relationship",
        "Media Sosial",
        "Tren",
        "Edukasi Anak",
        "Bisnis",
        "Wirausaha",
        "Keuangan",
        "Investasi",
        "Properti",
        "Mobil Listrik",
        "Pemilu",
        "Kebijakan Publik",
        "Selebriti",
        "Meme",
        "Komedi",
        "Inspirasi",
        "Motivasi",
        "Cerita Nyata",
        "Opini Publik",
        "Keseimbangan Hidup",
        "Kesehatan Mental",
        "Remote Work",
        "Work-Life Balance",
        "Produktivitas",
        "Green Energy",
        "Zero Waste",
        "Food Waste",
        "Sustainable Living",
        "E-commerce",
        "Cloud Computing",
        "Gadget",
        "Startup Funding",
        "UX/UI Design",
        "Smart Home",
        "Cyberbullying",
        "Parenting Digital",
        "Digital Nomad",
        "Online Course",
        "Pelatihan Karier",
        "Resensi Buku",
        "Rekomendasi Film",
        "Trend Teknologi",
        "Kehidupan Sehari-hari",
        "Mindfulness",
        "Biohacking",
        "Fitness",
        "Tips Diet",
        "Kecantikan",
        "Skincare",
        "Kecerdasan Buatan",
        "Robotik",
        "Etika Digital",
        "Perdagangan Internasional",
        "Ekonomi Kreatif",
        "Kehidupan Kampus",
        "Tips Belajar",
        "Beasiswa",
        "Perjalanan Spiritual",
        "Riset Ilmiah",
        "Teknologi Pertanian",
        "Infrastruktur Digital",
        "Transportasi Masa Depan",
        "Augmented Reality",
        "Virtual Reality",
        "Metaverse",
        "Pemrograman",
        "Open Source",
        "UI/UX",
        "Hackathon",
        "Komunitas Online",
        "Crowdfunding",
        "EduTech",
        "FinTech",
        "GovTech",
        "Space Tech",
        "Kebijakan Iklim",
        "Hukum Siber",
        "Etika Sosial",
        "Gender dan Kesetaraan",
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
            in_array($tema, ["Teknologi", "AI", "Crypto", "Cloud Computing", "Gadget", "Startup", "UX/UI Design", "Smart Home", "Open Source", "Pemrograman", "UI/UX", "Hackathon", "FinTech", "GovTech", "Space Tech", "Virtual Reality", "Augmented Reality", "Metaverse", "Infrastruktur Digital", "Transportasi Masa Depan", "Kecerdasan Buatan", "Robotik", "Trend Teknologi"]) =>
            ["Technology, Innovation", "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhJC1y3sI9JOUI5oWgw1RkH86c1MbW9yeUHo1yHHycX6MtrFkLpRptEujjgOqn0B34nPBwynB7D1fR3EheTNAj68EznWvdoXwq867VeJqRDfnFbnr4fgvJR0iHp-WLz1BgoD-O7kjRXtuIZZLT33H2A-IxsesCPi3JkoRKHofS1AZyb3fI/s1600/Gemini_Generated_Image_6633dn6633dn6633.png"],
            in_array($tema, ["Ekonomi", "Digital Marketing", "Bisnis", "Wirausaha", "Investasi", "Keuangan", "Properti", "Karier", "Pelatihan Karier", "Remote Work", "Work-Life Balance", "Produktivitas", "E-commerce", "Crowdfunding", "Ekonomi Kreatif", "Perdagangan Internasional"]) =>
            ["Economy, Business, Career", "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEj5PCNcXjDSMRSmiKtWpOStJbcagzScgS1RSqp_ebhz6m3ji-Akc9-CzpOMwKPG2tjAWHKWFa_gnm9mWm0AGvKLpvFetlGtF8-mbgDGEe7UdOJQe5vbi43B0FWZFi-cohdeFH8z4tOc5raqzajVzZV3J030kiBLmqqF9kzYkvHUId0uE7M/s1600/Gemini_Generated_Image_udwfczudwfczudwf.png"],
            in_array($tema, ["Kesehatan", "Kesehatan Mental", "Lifestyle", "Skincare", "Kecantikan", "Fitness", "Tips Diet", "Biohacking", "Mindfulness", "Parenting", "Parenting Digital", "Edukasi Anak", "Pendidikan", "Tips Belajar", "Kehidupan Kampus", "Beasiswa", "Resensi Buku", "Online Course"]) =>
            ["Health, Lifestyle, Education", "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjAvXl92EUXYJvOir2mFOinrrFFoEt5UGAgTUavsadzBDDhohUWufuUx9KEfteOIq1LcbqabgrBScwsaD51ZkGYZhfOZRaZ6-ytV0_PnZ_XlH71nYgLobkbTuySAvq6uRZBQvlrP_OJAraesR5EWJ32Pf9VdvVwPceaeGrof-bfDFBPjQU/s1600/Gemini_Generated_Image_wc52cxwc52cxwc52.png"],
            in_array($tema, ["Lingkungan", "Green Energy", "Zero Waste", "Food Waste", "Sustainable Living", "Kebijakan Iklim", "Teknologi Pertanian", "Hukum Siber", "Keamanan Siber", "Cyberbullying", "Etika Digital"]) =>
            ["Environment, Sustainability", "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEj-FRLHyixrMNlN6xNAQDIXazWsjY3jBKzSPkJ0zMg-Ixkg7LHIRQCnIyH5V5fOwx1HCBdpYp4vhRh-vuxLjm-7JdHXyETCiNEg6ZY8N162FbE9Hf3IiKksOBl-XEghQ-fbalbhaFLFGLNW4R-Jgp_4gSGS5zF3jL0-7iTTXokFAWOj3bg/s1600/Gemini_Generated_Image_93scto93scto93sc.png"],
            default =>
            ["General", "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEguuHUBS7A0LQt8sYl3AgZTV-JBiHk0_dTMVLmIPmTVCAhojxpVMU-0Ji4EOc39klDUV7e6JtwONgW-Jme35FnYjJzrIKnQeC2Pd-RNrtcG5m57wcLpE6_muRteVUiRh7OmRcXlCI7RkPgyd53Ip2tVsfvi2zJ9j_pnsP7HS19Vs96HqyM/s1600/Gemini_Generated_Image_wpdsc9wpdsc9wpds.png"],
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

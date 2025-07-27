<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.gemini.endpoint');
        $this->apiKey = config('services.gemini.api_key');
    }

    public function generateContent(string $prompt): string|null
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->endpoint . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Ambil konten dari response
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        } else {
            logger()->error('Gemini API error', ['response' => $response->body()]);
            return null;
        }
    }
}

<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function generateContent($prompt)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
            ]);

            if ($response->failed()) {
                Log::error('Gemini API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return ['error' => 'Failed to generate content.'];
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Exception occurred while calling Gemini API', [
                'message' => $e->getMessage(),
            ]);
            return ['error' => 'An error occurred while generating content.'];
        }
    }
}

// namespace App\Services;

// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;
// use Exception;

// class GeminiService
// {
//     protected $apiKey;
//     protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

//     public function __construct()
//     {
//         $this->apiKey = config('services.gemini.api_key');
//     }

//     public function generateContent($prompt)
//     {
//         $response = Http::withHeaders([
//             'Content-Type' => 'application/json',
//         ])->post($this->apiUrl . '?key=' . $this->apiKey, [
//             'contents' => [
//                 ['parts' => [['text' => $prompt]]],
//             ],
//         ]);

//         return $response->json();
//     }
// }

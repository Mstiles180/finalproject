<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReputationClient
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) env('ML_API_URL', 'http://127.0.0.1:5000'), '/');
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function score(array $payload): array
    {
        $response = Http::acceptJson()->post($this->baseUrl . '/score', $payload);
        return $response->json() ?? ['ok' => false, 'error' => 'No response'];
    }
}



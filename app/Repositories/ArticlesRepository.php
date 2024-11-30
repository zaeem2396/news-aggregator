<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class ArticlesRepository
{
    public function fetchArticlesFromNYTimes(): array
    {
        $nytUrl = 'https://api.nytimes.com/svc/topstories/v2/world.json?api-key=' . env('NYT_API_KEY');
        $response = Http::retry(3, 100)->timeout(10)->get($nytUrl);

        if ($response->successful()) {
            return $response->json()['results'] ?? [];
        }

        return [];
    }

    public function fetchArticlesFromNewsApi(?string $from = null, ?string $to = null): array
    {
        $from ??= date('Y-m-d');
        $to ??= $from;
        $openNewsUrl = "https://newsapi.org/v2/everything?sources=techcrunch,bloomberg,al-jazeera-english&from=$from&to=$to&sortBy=popularity&apiKey=" . env('NEWS_API_KEY');

        $response = Http::retry(3, 100)->timeout(10)->get($openNewsUrl);

        if ($response->successful()) {
            return $response->json()['articles'] ?? [];
        }

        return [];
    }

    public function fetchArticlesFromGuardian(?string $from = null, ?string $to = null): array
    {
        $from ??= date('Y-m-d');
        $to ??= $from;
        $guardianUrl = "https://content.guardianapis.com/search?from-date=$from&to-date=$to&section=world&page-size=20&api-key=" . env('GUARDIAN_API_KEY');
        $response = Http::retry(3, 100)->timeout(10)->get($guardianUrl);

        if ($response->successful()) {
            return $response->json()['response']['results'] ?? [];
        }

        return [];
    }
}

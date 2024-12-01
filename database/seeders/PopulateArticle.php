<?php

namespace Database\Seeders;

use App\Models\Articles;
use App\Repositories\ArticlesRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PopulateArticle extends Seeder
{

    public function __construct(private ArticlesRepository $repository)
    {
        
    }

    public function run(): void
    {
        $NYTimesArticles = $this->repository->fetchArticlesFromNYTimes();
        foreach ($NYTimesArticles as $article) {
            app(Articles::class)->updateOrCreate(
                ['url' => $article['url']],
                [
                    "title" => $article["title"],
                    "section" => $article["section"],
                    "author" => $article["byline"],
                    "description" => $article["abstract"],
                    "content" => $article["abstract"],
                    "url" => $article["url"],
                    "image_url" => $article["multimedia"][0]["url"] ?? null,
                    "source_name" => "NY Times",
                    "published_at" => $article["published_date"]
                ]
            );
        }

        $newsApiArticles = $this->repository->fetchArticlesFromNewsApi('2024-11-11', '2024-12-01');
        foreach ($newsApiArticles as $article) {
            app(Articles::class)->updateOrCreate(
                ['url' => $article['url']],
                [
                    "title" => $article["title"],
                    "section" => $article["source"]["name"],
                    "author" => $article["author"],
                    "description" => $article["description"],
                    "content" => $article["description"],
                    "url" => $article["url"],
                    "image_url" => $article["urlToImage"],
                    "source_name" => "News Org",
                    "published_at" => date('Y-m-d H:i:s', strtotime($article["publishedAt"]))
                ]
            );
        }

        $guardianArticles = $this->repository->fetchArticlesFromGuardian('2024-11-11', '2024-12-01');
        foreach ($guardianArticles as $article) {
            app(Articles::class)->updateOrCreate(
                ['url' => $article['webUrl']],
                [
                    "title" => $article["webTitle"],
                    "section" => $article["sectionName"],
                    "author" => null,
                    "description" => null,
                    "content" => null,
                    "url" => $article["webUrl"],
                    "image_url" => null,
                    "source_name" => "Guardian News",
                    "published_at" => date('Y-m-d H:i:s', strtotime($article["webPublicationDate"]))
                ]
            );
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Articles;
use App\Repositories\ArticlesRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchArticles extends Command
{
    public function __construct(private ArticlesRepository $repository)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from API`s and store in database';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->fetchArticlesFromNYTimes();
        $this->fetchArticlesFromNewsApi();
        $this->fetchArticlesFromGuardian();
    }

    public function fetchArticlesFromNYTimes()
    {

        try {
            $articles = $this->repository->fetchArticlesFromNYTimes();
            foreach ($articles as $article) {
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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchArticlesFromNewsApi()
    {
        try {

            $articles = $this->repository->fetchArticlesFromNewsApi('2024-11-10', '2024-11-30');
            foreach ($articles as $article) {
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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchArticlesFromGuardian()
    {
        try {
            $articles = $this->repository->fetchArticlesFromGuardian('2024-11-10', '2024-11-30');
            foreach ($articles as $article) {
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
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

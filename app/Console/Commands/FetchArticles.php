<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Articles;
use Illuminate\Console\Command;
use App\Repositories\ArticlesRepository;
use App\Mappers\{GuardianArticleMapper, NewsApiArticleMapper, NYTimesArticleMapper};

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
                $mappedArticle = NYTimesArticleMapper::map($article);
                app(Articles::class)->updateOrCreate(['url' => $mappedArticle['url']], $mappedArticle);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchArticlesFromNewsApi()
    {
        try {

            $articles = $this->repository->fetchArticlesFromNewsApi(Carbon::now()->subDays(20)->format('Y-m-d'), Carbon::now()->format('Y-m-d'));
            foreach ($articles as $article) {
                $mappedArticle = NewsApiArticleMapper::map($article);
                app(Articles::class)->updateOrCreate(['url' => $mappedArticle['url']], $mappedArticle);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchArticlesFromGuardian()
    {
        try {
            $articles = $this->repository->fetchArticlesFromGuardian(
                Carbon::now()->subDays(20)->format('Y-m-d'),
                Carbon::now()->format('Y-m-d')
            );

            foreach ($articles as $article) {
                $mappedArticle = GuardianArticleMapper::map($article);
                app(Articles::class)->updateOrCreate(['url' => $mappedArticle['url']], $mappedArticle);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

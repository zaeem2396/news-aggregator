<?php

namespace Database\Seeders;

use App\Models\Articles;
use Illuminate\Database\Seeder;
use App\Repositories\ArticlesRepository;
use App\Mappers\{GuardianArticleMapper, NewsApiArticleMapper, NYTimesArticleMapper};

class PopulateArticle extends Seeder
{

    public function __construct(private ArticlesRepository $repository) {}

    public function run(): void
    {
        $NYTimesArticles = $this->repository->fetchArticlesFromNYTimes();
        foreach ($NYTimesArticles as $article) {
            $mappedArticle = NYTimesArticleMapper::map($article);
            app(Articles::class)->updateOrCreate(['url' => $article['url']], $mappedArticle);
        }

        $newsApiArticles = $this->repository->fetchArticlesFromNewsApi('2024-11-11', '2024-12-01');
        foreach ($newsApiArticles as $article) {
            $mappedArticle = NewsApiArticleMapper::map($article);
            app(Articles::class)->updateOrCreate(['url' => $article['url']], $mappedArticle);
        }

        $guardianArticles = $this->repository->fetchArticlesFromGuardian('2024-11-11', '2024-12-01');
        foreach ($guardianArticles as $article) {
            $mappedArticle = GuardianArticleMapper::map($article);
            app(Articles::class)->updateOrCreate(['url' => $article['webUrl']], $mappedArticle);
        }
    }
}

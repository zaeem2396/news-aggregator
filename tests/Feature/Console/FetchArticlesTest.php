<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\ArticlesRepository;
use App\Mappers\{GuardianArticleMapper, NewsApiArticleMapper, NYTimesArticleMapper};

class FetchArticlesTest extends TestCase
{
    public function test_fetch_articles_command()
    {
        $this->mock(ArticlesRepository::class, function ($mock) {
            $mock->shouldReceive('fetchArticlesFromNYTimes')
                ->andReturn([
                    ['title' => 'Test NY Times', 'url' => 'http://example.com', 'section' => 'World', 'byline' => 'Author', 'abstract' => 'Description', 'published_date' => now()->toDateString()]
                ]);
            $mock->shouldReceive('fetchArticlesFromNewsApi')
                ->andReturn([
                    ['title' => 'Test NewsAPI', 'url' => 'http://example-newsapi.com', 'source' => ['name' => 'Tech'], 'author' => 'NewsAPI Author', 'description' => 'NewsAPI Description', 'publishedAt' => now()->toDateString()]
                ]);
            $mock->shouldReceive('fetchArticlesFromGuardian')
                ->andReturn([
                    ['webTitle' => 'Test Guardian', 'webUrl' => 'http://example-guardian.com', 'sectionName' => 'Politics', 'webPublicationDate' => now()->toDateString()]
                ]);
        });

        $this->partialMock(NYTimesArticleMapper::class, function ($mock) {
            $mock->shouldReceive('map')->andReturn([
                'url' => 'http://example.com',
                'title' => 'Test NY Times',
                'section' => 'World',
                'author' => 'Author',
                'description' => 'Description',
                'content' => 'Description',
                'image_url' => null,
                'source_name' => 'NY Times',
                'published_at' => now()->toDateTimeString(),
            ]);
        });

        $this->partialMock(NewsApiArticleMapper::class, function ($mock) {
            $mock->shouldReceive('map')->andReturn([
                'url' => 'http://example-newsapi.com',
                'title' => 'Test NewsAPI',
                'section' => 'Tech',
                'author' => 'NewsAPI Author',
                'description' => 'NewsAPI Description',
                'content' => 'NewsAPI Description',
                'image_url' => null,
                'source_name' => 'News Org',
                'published_at' => now()->toDateTimeString(),
            ]);
        });

        $this->partialMock(GuardianArticleMapper::class, function ($mock) {
            $mock->shouldReceive('map')->andReturn([
                'url' => 'http://example-guardian.com',
                'title' => 'Test Guardian',
                'section' => 'Politics',
                'author' => null,
                'description' => null,
                'content' => null,
                'image_url' => null,
                'source_name' => 'Guardian News',
                'published_at' => now()->toDateTimeString(),
            ]);
        });

        // Run the Artisan command
        Artisan::call('app:fetch-articles');

        // Assertions
        $this->assertDatabaseHas('articles', [
            'url' => 'http://example.com',
            'title' => 'Test NY Times',
        ]);

        $this->assertDatabaseHas('articles', [
            'url' => 'http://example-newsapi.com',
            'title' => 'Test NewsAPI',
        ]);

        $this->assertDatabaseHas('articles', [
            'url' => 'http://example-guardian.com',
            'title' => 'Test Guardian',
        ]);
    }
}

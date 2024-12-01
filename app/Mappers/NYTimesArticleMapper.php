<?php

namespace App\Mappers;

class NYTimesArticleMapper
{
    public static function map(array $article): array
    {
        return [
            "title" => $article["title"],
            "section" => $article["section"],
            "author" => $article["byline"],
            "description" => $article["abstract"],
            "content" => $article["abstract"], // Response does not returns content
            "url" => $article["url"],
            "image_url" => $article["multimedia"][0]["url"] ?? null,
            "source_name" => "NY Times",
            "published_at" => $article["published_date"],
        ];
    }
}

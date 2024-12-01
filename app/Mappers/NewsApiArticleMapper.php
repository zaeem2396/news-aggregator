<?php

namespace App\Mappers;

class NewsApiArticleMapper
{
    public static function map(array $article): array
    {
        return [
            "title" => $article["title"],
            "section" => $article["source"]["name"],
            "author" => $article["author"],
            "description" => $article["description"],
            "content" => $article["description"], // Response does not returns content 
            "url" => $article["url"],
            "image_url" => $article["urlToImage"] ?? null,
            "source_name" => "News Org",
            "published_at" => date('Y-m-d H:i:s', strtotime($article["publishedAt"])),
        ];
    }
}

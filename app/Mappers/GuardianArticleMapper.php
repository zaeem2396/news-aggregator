<?php

namespace App\Mappers;

class GuardianArticleMapper
{
    public static function map(array $article): array
    {
        return [
            "title" => $article["webTitle"],
            "section" => $article["sectionName"],
            "author" => null, // Response does not returns author
            "description" => null, // Response does not returns description
            "content" => null, // Response does not returns content
            "url" => $article["webUrl"],
            "image_url" => null,
            "source_name" => "Guardian News",
            "published_at" => date('Y-m-d H:i:s', strtotime($article["webPublicationDate"])),
        ];
    }
}

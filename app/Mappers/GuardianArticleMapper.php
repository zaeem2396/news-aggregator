<?php

namespace App\Mappers;

class GuardianArticleMapper
{
    public static function map(array $article): array
    {
        return [
            "title" => $article["webTitle"],
            "section" => $article["sectionName"],
            "author" => null,
            "description" => null,
            "content" => null,
            "url" => $article["webUrl"],
            "image_url" => null,
            "source_name" => "Guardian News",
            "published_at" => date('Y-m-d H:i:s', strtotime($article["webPublicationDate"])),
        ];
    }
}

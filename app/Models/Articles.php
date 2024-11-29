<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $tableName = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'section', 'author', 'description', 'content', 'url', 'image_url', 'source_name', 'published_at'];
}

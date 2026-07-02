<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'locale', 'title', 'slug', 'summary', 'content', 'cover_image', 'seo_title', 'seo_keywords', 'seo_description'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}

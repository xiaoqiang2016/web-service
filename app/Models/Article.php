<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'author', 'source', 'view_count', 'status', 'is_top', 'is_recommend', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(ArticleTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(ArticleTranslation::class)->where('locale', app()->getLocale());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

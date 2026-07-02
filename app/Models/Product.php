<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'model', 'price', 'sort_order', 'is_show', 'is_recommend', 'view_count', 'cover_image', 'images'];

    protected $casts = [
        'images' => 'array',
    ];

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(ProductTranslation::class)->where('locale', app()->getLocale());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

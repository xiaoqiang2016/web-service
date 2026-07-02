<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'link_url', 'link_target', 'sort_order', 'is_show', 'position'];

    public function translations()
    {
        return $this->hasMany(BannerTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(BannerTranslation::class)->where('locale', app()->getLocale());
    }
}

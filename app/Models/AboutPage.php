<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function translations()
    {
        return $this->hasMany(AboutPageTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(AboutPageTranslation::class)->where('locale', app()->getLocale());
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPageTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['about_page_id', 'locale', 'content', 'summary', 'team_content'];

    public function aboutPage()
    {
        return $this->belongsTo(AboutPage::class);
    }
}
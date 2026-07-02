<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['banner_id', 'locale', 'title', 'description', 'image'];

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteConfigTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['config_id', 'locale', 'config_value'];

    public function config()
    {
        return $this->belongsTo(SiteConfig::class);
    }
}

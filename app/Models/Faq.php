<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['sort_order', 'is_show'];

    public function translations()
    {
        return $this->hasMany(FaqTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(FaqTranslation::class)->where('locale', app()->getLocale());
    }
}

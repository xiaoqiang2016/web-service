<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = ['category_id', 'client_name', 'industry', 'sort_order', 'is_show', 'view_count'];

    public function translations()
    {
        return $this->hasMany(CaseTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(CaseTranslation::class)->where('locale', app()->getLocale());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

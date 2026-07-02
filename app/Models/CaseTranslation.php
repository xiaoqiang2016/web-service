<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['case_id', 'locale', 'title', 'summary', 'content', 'cover_image', 'images'];

    protected $casts = [
        'images' => 'array',
    ];

    public function case()
    {
        return $this->belongsTo(CaseModel::class);
    }
}

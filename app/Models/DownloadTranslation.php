<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['download_id', 'locale', 'title', 'description'];

    public function download()
    {
        return $this->belongsTo(Download::class);
    }
}

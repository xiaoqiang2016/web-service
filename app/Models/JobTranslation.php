<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'locale', 'title', 'description', 'requirements'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'locale', 'name'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}

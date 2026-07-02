<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['locale', 'name', 'is_default', 'is_active', 'sort_order'];

    public static function getDefault()
    {
        return static::where('is_default', 1)->first();
    }

    public static function getActive()
    {
        return static::where('is_active', 1)->orderBy('sort_order')->get();
    }
}

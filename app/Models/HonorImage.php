<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HonorImage extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'caption', 'sort_order', 'is_show'];
}
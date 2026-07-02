<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'company', 'subject', 'content', 'status', 'reply_content', 'reply_at', 'ip'];
}

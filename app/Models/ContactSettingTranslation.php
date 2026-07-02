<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSettingTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['contact_setting_id', 'locale', 'label', 'description', 'value'];
    public $timestamps = false;
}

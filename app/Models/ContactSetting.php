<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'type', 'is_active', 'sort_order'];

    public function translation()
    {
        return $this->hasOne(ContactSettingTranslation::class)->where('locale', app()->getLocale());
    }

    public function translations()
    {
        return $this->hasMany(ContactSettingTranslation::class);
    }

    public static function getSettings($type = null)
    {
        $query = self::where('is_active', 1)->orderBy('sort_order');
        if ($type) {
            $query->where('type', $type);
        }
        return $query->with('translation')->get();
    }

    public static function getByKey($key)
    {
        return self::where('key', $key)->where('is_active', 1)->with('translation')->first();
    }

    public function getValueAttribute($value)
    {
        if ($this->relationLoaded('translation') && $this->translation && $this->translation->value) {
            return $this->translation->value;
        }
        return $value;
    }
}

 <?php

use App\Models\Language;

function get_translated($model, $field, $locale = null)
{
    if (!$model) {
        return null;
    }
    
    $currentLocale = $locale ?? app()->getLocale();
    
    if ($model->translation && $model->translation->{$field}) {
        return $model->translation->{$field};
    }
    
    $defaultLocale = Language::getDefault()?->locale ?? 'en';
    
    if ($currentLocale !== $defaultLocale) {
        $fallbackTranslation = $model->translations->where('locale', $defaultLocale)->first();
        if ($fallbackTranslation && $fallbackTranslation->{$field}) {
            return $fallbackTranslation->{$field};
        }
    }
    
    return null;
}

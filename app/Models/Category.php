<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'type', 'sort_order', 'is_show', 'template', 'url'];

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(CategoryTranslation::class)->where('locale', app()->getLocale());
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function cases()
    {
        return $this->hasMany(CaseModel::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public static function tree($type = null, $isShow = null)
    {
        $query = static::query();
        if ($type) {
            $query->where('type', $type);
        }
        if ($isShow !== null) {
            $query->where('is_show', $isShow);
        }
        $categories = $query->orderBy('sort_order')->get();
        
        return $categories->where('parent_id', 0)->map(function ($category) use ($categories) {
            $category->children = $categories->where('parent_id', $category->id)->values();
            return $category;
        });
    }

    public static function productTree($isShow = null)
    {
        $query = static::query();
        if ($isShow !== null) {
            $query->where('is_show', $isShow);
        }
        $categories = $query->orderBy('sort_order')->get();
        
        $productsCategory = $categories->first(function ($category) {
            return $category->type === 'page' && $category->url === '/products';
        });
        
        if (!$productsCategory) {
            return collect();
        }
        
        return $categories->where('parent_id', $productsCategory->id)->filter(function ($category) {
            return $category->type === 'product';
        })->map(function ($category) use ($categories) {
            $category->children = $categories->where('parent_id', $category->id)->filter(function ($child) {
                return $child->type === 'product';
            })->map(function ($child) use ($categories) {
                $child->children = $categories->where('parent_id', $child->id)->filter(function ($grandchild) {
                    return $grandchild->type === 'product';
                })->values();
                return $child;
            })->values();
            return $category;
        });
    }
}

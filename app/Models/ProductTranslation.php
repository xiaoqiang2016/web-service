<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'locale', 'name', 'slug', 'summary', 'description', 'seo_title', 'seo_keywords', 'seo_description', 'specifications', 'competitive_advantage', 'certification', 'min_order_quantity', 'packaging_details', 'delivery_time', 'payment_terms', 'supply_ability'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

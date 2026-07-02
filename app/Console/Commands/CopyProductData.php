<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductTranslation;

class CopyProductData extends Command
{
    protected $signature = 'product:copy-data {source_id=4 : Source product ID} {--force : Force overwrite existing data}';
    protected $description = 'Copy product data from source product to all other products';

    public function handle()
    {
        $sourceId = $this->argument('source_id');
        $force = $this->option('force');

        $sourceProduct = Product::with('translations')->find($sourceId);

        if (!$sourceProduct) {
            $this->error("Source product with ID {$sourceId} not found.");
            return;
        }

        $this->info("Source product ID: {$sourceId}");
        $this->info("Found {$sourceProduct->translations->count()} translation records.");

        // Get all products except the source
        $products = Product::where('id', '!=', $sourceId)->get();

        if ($products->isEmpty()) {
            $this->info("No other products found to update.");
            return;
        }

        $this->info("Found {$products->count()} products to update.");

        if (!$this->confirm("Do you want to copy data from product ID {$sourceId} to {$products->count()} other products?")) {
            $this->info("Operation cancelled.");
            return;
        }

        // Copy main product data (including cover_image and images from products table)
        foreach ($products as $product) {
            $product->category_id = $sourceProduct->category_id;
            $product->model = $sourceProduct->model;
            $product->price = $sourceProduct->price;
            $product->sort_order = $sourceProduct->sort_order;
            $product->is_show = $sourceProduct->is_show;
            $product->is_recommend = $sourceProduct->is_recommend;
            $product->cover_image = $sourceProduct->cover_image;
            $product->images = $sourceProduct->images;
            $product->save();
            $this->line("Updated product ID {$product->id} main data.");
        }

        // Copy translation data (cover_image and images now in products table, not translations)
        foreach ($sourceProduct->translations as $sourceTranslation) {
            foreach ($products as $product) {
                $existingTranslation = ProductTranslation::where('product_id', $product->id)
                    ->where('locale', $sourceTranslation->locale)
                    ->first();

                if ($existingTranslation) {
                    if ($force) {
                        $existingTranslation->name = $sourceTranslation->name;
                        $existingTranslation->slug = $sourceTranslation->slug;
                        $existingTranslation->summary = $sourceTranslation->summary;
                        $existingTranslation->description = $sourceTranslation->description;
                        $existingTranslation->seo_title = $sourceTranslation->seo_title;
                        $existingTranslation->seo_keywords = $sourceTranslation->seo_keywords;
                        $existingTranslation->seo_description = $sourceTranslation->seo_description;
                        $existingTranslation->specifications = $sourceTranslation->specifications;
                        $existingTranslation->competitive_advantage = $sourceTranslation->competitive_advantage;
                        $existingTranslation->certification = $sourceTranslation->certification;
                        $existingTranslation->min_order_quantity = $sourceTranslation->min_order_quantity;
                        $existingTranslation->packaging_details = $sourceTranslation->packaging_details;
                        $existingTranslation->delivery_time = $sourceTranslation->delivery_time;
                        $existingTranslation->payment_terms = $sourceTranslation->payment_terms;
                        $existingTranslation->supply_ability = $sourceTranslation->supply_ability;
                        $existingTranslation->save();
                        $this->line("Updated translation for product ID {$product->id}, locale {$sourceTranslation->locale}.");
                    } else {
                        $this->warn("Skipped translation for product ID {$product->id}, locale {$sourceTranslation->locale} (already exists). Use --force to overwrite.");
                    }
                } else {
                    ProductTranslation::create([
                        'product_id' => $product->id,
                        'locale' => $sourceTranslation->locale,
                        'name' => $sourceTranslation->name,
                        'slug' => $sourceTranslation->slug,
                        'summary' => $sourceTranslation->summary,
                        'description' => $sourceTranslation->description,
                        'seo_title' => $sourceTranslation->seo_title,
                        'seo_keywords' => $sourceTranslation->seo_keywords,
                        'seo_description' => $sourceTranslation->seo_description,
                        'specifications' => $sourceTranslation->specifications,
                        'competitive_advantage' => $sourceTranslation->competitive_advantage,
                        'certification' => $sourceTranslation->certification,
                        'min_order_quantity' => $sourceTranslation->min_order_quantity,
                        'packaging_details' => $sourceTranslation->packaging_details,
                        'delivery_time' => $sourceTranslation->delivery_time,
                        'payment_terms' => $sourceTranslation->payment_terms,
                        'supply_ability' => $sourceTranslation->supply_ability,
                    ]);
                    $this->line("Created translation for product ID {$product->id}, locale {$sourceTranslation->locale}.");
                }
            }
        }

        $this->info("Data copy completed successfully!");
    }
}
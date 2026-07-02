<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('translation', 'category.translation')->orderBy('sort_order')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $languages = Language::getActive();
        $categories = Category::where('type', 'product')->where('is_show', 1)->orderBy('sort_order')->get();
        return view('admin.products.create', compact('languages', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'is_recommend' => 'boolean',
            'translations.*.name' => 'required',
            'translations.*.description' => 'nullable',
        ]);

        // Handle cover image (shared across languages)
        $coverImage = null;
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')->store('products', 'public');
        }

        // Handle detail images (shared across languages)
        $detailImages = [];
        if ($request->hasFile('detail_images')) {
            foreach ($request->file('detail_images') as $image) {
                $detailImages[] = $image->store('products/gallery', 'public');
            }
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
            'is_recommend' => $request->is_recommend ?? 0,
            'cover_image' => $coverImage,
            'images' => $detailImages,
        ]);

        foreach ($request->translations as $locale => $data) {
            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => $locale,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'summary' => $data['summary'] ?? null,
                'description' => $data['description'] ?? null,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_keywords' => $data['seo_keywords'] ?? null,
                'seo_description' => $data['seo_description'] ?? null,
                'specifications' => $data['specifications'] ?? null,
                'competitive_advantage' => $data['competitive_advantage'] ?? null,
                'certification' => $data['certification'] ?? null,
                'min_order_quantity' => $data['min_order_quantity'] ?? null,
                'packaging_details' => $data['packaging_details'] ?? null,
                'delivery_time' => $data['delivery_time'] ?? null,
                'payment_terms' => $data['payment_terms'] ?? null,
                'supply_ability' => $data['supply_ability'] ?? null,
            ]);
        }

        Cache::forget('products');

        return redirect()->route('admin.products.index')->with('success', 'Product created');
    }

    public function edit(Product $product)
    {
        $product->load('translations');
        $languages = Language::getActive();
        $categories = Category::where('type', 'product')->where('is_show', 1)->orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'languages', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'is_recommend' => 'boolean',
            'translations.*.name' => 'required',
            'translations.*.description' => 'nullable',
        ]);

        // Handle cover image (shared across languages)
        $coverImage = $product->cover_image;
        if ($request->hasFile('cover_image')) {
            if ($coverImage) {
                Storage::disk('public')->delete($coverImage);
            }
            $coverImage = $request->file('cover_image')->store('products', 'public');
        } elseif ($request->has('deleted_cover_image')) {
            // User deleted the cover image
            if ($coverImage) {
                Storage::disk('public')->delete($coverImage);
            }
            $coverImage = null;
        }

        // Handle detail images (shared across languages)
        $detailImages = $product->images ?? [];
        if (is_string($detailImages)) {
            $detailImages = json_decode($detailImages, true) ?: [];
        }
        if (!is_array($detailImages)) {
            $detailImages = [];
        }
        if ($request->hasFile('detail_images')) {
            foreach ($request->file('detail_images') as $image) {
                $detailImages[] = $image->store('products/gallery', 'public');
            }
        }

        // Handle deleted detail images
        if ($request->has('deleted_detail_images')) {
            $deletedImages = $request->input('deleted_detail_images', []);
            if (is_string($deletedImages)) {
                $deletedImages = json_decode($deletedImages, true) ?: [];
            }
            $detailImages = array_filter($detailImages, function($image) use ($deletedImages) {
                return !in_array($image, $deletedImages);
            });
            $detailImages = array_values($detailImages); // Re-index array

            // Delete the removed images from storage
            foreach ($deletedImages as $deletedImage) {
                Storage::disk('public')->delete($deletedImage);
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
            'is_recommend' => $request->is_recommend ?? 0,
            'cover_image' => $coverImage,
            'images' => $detailImages,
        ]);

        foreach ($request->translations as $locale => $data) {
            $translation = $product->translations()->where('locale', $locale)->first();

            $translationData = [
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'summary' => $data['summary'] ?? null,
                'description' => $data['description'] ?? null,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_keywords' => $data['seo_keywords'] ?? null,
                'seo_description' => $data['seo_description'] ?? null,
                'specifications' => $data['specifications'] ?? null,
                'competitive_advantage' => $data['competitive_advantage'] ?? null,
                'certification' => $data['certification'] ?? null,
                'min_order_quantity' => $data['min_order_quantity'] ?? null,
                'packaging_details' => $data['packaging_details'] ?? null,
                'delivery_time' => $data['delivery_time'] ?? null,
                'payment_terms' => $data['payment_terms'] ?? null,
                'supply_ability' => $data['supply_ability'] ?? null,
            ];

            if ($translation) {
                $translation->update($translationData);
            } else {
                ProductTranslation::create(array_merge($translationData, [
                    'product_id' => $product->id,
                    'locale' => $locale,
                ]));
            }
        }

        Cache::forget('products');

        return redirect()->route('admin.products.edit', $product->id)->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        // Delete cover image
        if ($product->cover_image) {
            Storage::disk('public')->delete($product->cover_image);
        }

        // Delete detail images
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();
        Cache::forget('products');
        return redirect()->route('admin.products.index')->with('success', 'Product deleted');
    }
}

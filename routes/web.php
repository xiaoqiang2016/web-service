<?php

use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['set.admin.locale',"VerifyCsrfToken"])->group(function () {
    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
    Route::get('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('languages', \App\Http\Controllers\Admin\LanguageController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
        Route::resource('cases', \App\Http\Controllers\Admin\CaseController::class);
        Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class);
        Route::resource('contact-settings', \App\Http\Controllers\Admin\ContactSettingController::class)->except(['destroy']);
        Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
        Route::resource('admin-users', \App\Http\Controllers\Admin\AdminUserController::class);
        Route::resource('admin-roles', \App\Http\Controllers\Admin\AdminRoleController::class);
        Route::get('about-contents', [\App\Http\Controllers\Admin\AboutContentController::class, 'index'])->name('about-contents.index');
        Route::put('about-contents', [\App\Http\Controllers\Admin\AboutContentController::class, 'update'])->name('about-contents.update');
        Route::post('upload', [\App\Http\Controllers\Admin\UploadController::class, 'upload'])->name('upload');
        Route::resource('honor-images', \App\Http\Controllers\Admin\HonorImageController::class);
        Route::resource('factory-images', \App\Http\Controllers\Admin\FactoryImageController::class);
    });
});

// Front Routes
Route::group(['prefix' => '{locale}', 'middleware' => 'set.locale'], function () {
    Route::get('/', [\App\Http\Controllers\Front\PageController::class, 'index'])->name('front.index');
    Route::get('about', [\App\Http\Controllers\Front\PageController::class, 'about'])->name('front.about');
    Route::get('contact', [\App\Http\Controllers\Front\PageController::class, 'contact'])->name('front.contact');
    Route::get('contact/captcha', [\App\Http\Controllers\Front\PageController::class, 'contactCaptcha'])->name('front.contact.captcha');
    Route::post('contact', [\App\Http\Controllers\Front\PageController::class, 'contactSubmit'])->name('front.contact.submit');
    Route::get('faq', [\App\Http\Controllers\Front\FaqController::class, 'index'])->name('front.faq');

    Route::get('products', [\App\Http\Controllers\Front\ProductController::class, 'index'])->name('front.products');
    Route::get('products/detail/{id}', [\App\Http\Controllers\Front\ProductController::class, 'show'])->name('front.product');
    Route::get('products/{categorySlug}', [\App\Http\Controllers\Front\ProductController::class, 'index'])->name('front.products.category');
    Route::get('products/{categorySlug}/{subCategorySlug}', [\App\Http\Controllers\Front\ProductController::class, 'index'])->name('front.products.subcategory');

    Route::get('news', [\App\Http\Controllers\Front\ArticleController::class, 'index'])->name('front.news');
    Route::get('news/{slug}', [\App\Http\Controllers\Front\ArticleController::class, 'show'])->name('front.news.show');

    Route::get('cases', [\App\Http\Controllers\Front\CaseController::class, 'index'])->name('front.cases');
    Route::get('cases/{slug}', [\App\Http\Controllers\Front\CaseController::class, 'show'])->name('front.case.show');

    Route::get('jobs', [\App\Http\Controllers\Front\JobController::class, 'index'])->name('front.jobs');
    Route::get('jobs/{slug}', [\App\Http\Controllers\Front\JobController::class, 'show'])->name('front.job.show');

    Route::get('downloads', [\App\Http\Controllers\Front\DownloadController::class, 'index'])->name('front.downloads');
    Route::get('downloads/{id}/download', [\App\Http\Controllers\Front\DownloadController::class, 'download'])->name('front.download');

    Route::get('search', [\App\Http\Controllers\Front\SearchController::class, 'index'])->name('front.search');
});

Route::get('/', function () {
    return redirect()->route('front.index', ['locale' => 'en']);
});

<?php

namespace App\Http\Controllers\Front;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Article;
use App\Models\CaseModel;
use App\Models\Message;
use App\Models\AboutPage;
use App\Models\HonorImage;
use App\Models\FactoryImage;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        $banners = Banner::with('translation')->where('is_show', 1)->where('position', 'home')->orderBy('sort_order')->get();
        $products = Product::with('translation')->where('is_show', 1)->where('is_recommend', 1)->orderBy('sort_order')->take(8)->get();
        $articles = Article::with('translation')->where('status', 1)->orderBy('published_at', 'desc')->take(6)->get();
        $cases = CaseModel::with('translation')->where('is_show', 1)->orderBy('sort_order')->take(4)->get();
        $honorImages = HonorImage::where('is_show', 1)->orderBy('sort_order')->get();
        $factoryImages = FactoryImage::where('is_show', 1)->orderBy('sort_order')->get();
        $aboutPage = AboutPage::with('translations')->first();
        return view('front.index', compact('banners', 'products', 'articles', 'cases', 'honorImages', 'factoryImages', 'aboutPage'));
    }

    public function about()
    {
        $banner = Banner::where('position', 'about')->where('is_show', 1)->with('translation')->first();
        $aboutPage = AboutPage::with('translations')->first();
        $honorImages = HonorImage::where('is_show', true)->orderBy('sort_order')->get();
        $factoryImages = FactoryImage::where('is_show', true)->orderBy('sort_order')->get();
        
        // 获取About页面SEO信息
        $category = Category::where('url', '/about')->with('translations')->first();
        
        return view('front.about', compact('banner', 'aboutPage', 'honorImages', 'factoryImages', 'category'));
    }

    public function contact()
    {
        $banner = Banner::where('position', 'contact')->where('is_show', 1)->with('translation')->first();
        
        // 获取Contact页面SEO信息
        $category = Category::where('url', '/contact')->with('translations')->first();
        
        return view('front.contact', compact('banner', 'category'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:100',
            'content' => 'required|string|max:500',
            'captcha' => 'required|numeric',
        ], [
            'captcha.required' => 'Please enter the verification code',
            'captcha.numeric' => 'Verification code must be a number',
        ]);

        if (!session()->has('contact_captcha') || $request->captcha != session('contact_captcha')) {
            return back()->withErrors(['captcha' => 'Invalid verification code']);
        }

        session()->forget('contact_captcha');

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? null,
            'company' => $request->company ?? null,
            'subject' => 'Contact Inquiry',
            'content' => $request->content,
            'ip' => $request->ip(),
            'status' => 0,
        ]);

        return back()->with('success', 'Message sent successfully');
    }

    public function contactCaptcha()
    {
        $captcha = rand(1000, 9999);
        session(['contact_captcha' => $captcha]);

        $width = 120;
        $height = 40;
        $image = imagecreate($width, $height);
        
        $bg_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        
        for ($i = 0; $i < 100; $i++) {
            $x = rand(0, $width);
            $y = rand(0, $height);
            imagesetpixel($image, $x, $y, imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255)));
        }
        
        for ($i = 0; $i < 3; $i++) {
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255)));
        }
        
        $font_size = 5;
        $font_width = imagefontwidth($font_size);
        $font_height = imagefontheight($font_size);
        $text_width = $font_width * strlen($captcha);
        $x = ($width - $text_width) / 2;
        $y = ($height - $font_height) / 2;
        
        imagestring($image, $font_size, $x, $y, $captcha, $text_color);
        
        ob_clean();
        flush();
        
        return response()->stream(function () use ($image) {
            imagepng($image);
            imagedestroy($image);
        }, 200, ['Content-Type' => 'image/png']);
    }

    public function faq()
    {
        return view('front.faq');
    }
}

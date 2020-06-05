<?php

namespace App\Http\Controllers\Frontend;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->take(7)->get();
        $brands     = Brand::latest()->take(10)->get();
        $products   = Product::latest()->paginate(8);
        return view('welcome', compact('categories', 'brands', 'products'));
    }

    public function categoryWise($slug)
    {
        $categorieProducts = Category::where('slug', $slug)->get();
        return view('category-wise', compact('categorieProducts'));
    }

    public function brandWise($slug)
    {
        $brandProducts = Brand::where('slug', $slug)->get();
        return view('brand-wise', compact('brandProducts'));
    }

    public function productView($product)
    {
        return $product;
    }
}

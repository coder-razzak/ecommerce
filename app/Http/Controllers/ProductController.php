<?php

namespace App\Http\Controllers;

use App\Size;
use App\Brand;
use App\Color;
use App\Product;
use App\Category;
use App\MultiImage;
use App\ProductSubImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;

use Brian2694\Toastr\Facades\Toastr;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();
        $brands     = Brand::latest()->get();
        $colors     = Color::latest()->get();
        $sizes      = Size::latest()->get();
        return view('admin.product.create', compact('categories', 'brands', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id'           => 'required',
            'brand_id'              => 'required',
            'colors'                => 'required',
            'sizes'                 => 'required',
            'name'                  => 'required|unique:products',
            'sizes'                 => 'required',
            'price'                 => 'required',
            'short_description'     => 'required',
            'image'                 => 'required|mimes:png,jpg,jpeg,gif,webp',
            'long_description'      => 'required',
        ]);

        $slug = Str::slug($request->name);
        $image = $request->file('image');

        if(isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            // check product folder exists or not
            if(!Storage::disk('public')->exists('product'))
            {
                Storage::disk('public')->makeDirectory('product');
            }

            $productImage = Image::make($image)->resize(1200, 1486)->save($image);
            Storage::disk('public')->put('product/'.$imagename,$productImage);
        }else {
            $imagename = 'default.png';
        }

        $product                    = new Product();
        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;
        $product->name              = $request->name;
        $product->slug              = $slug;
        $product->image             = $imagename;
        $product->price             = $request->price;
        $product->short_description = $request->short_description;
        $product->price             = $request->price;
        $product->long_description  = $request->long_description;

        if($product->save()){
            $files = $request->sub_image;
            $oldSubImage = ProductSubImage::find($product->id);
            if(!empty($files)){
                foreach($files as $file){
                    $currentDate = Carbon::now()->toDateString();
                    $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();

                    // check product folder exists or not
                    if(!Storage::disk('public')->exists('product/sub'))
                    {
                        Storage::disk('public')->makeDirectory('product/sub');
                    }

                    $productSubImage = Image::make($file)->resize(1200, 1486)->save($file);
                    Storage::disk('public')->put('product/sub/'.$imagename,$productSubImage);

                    $sub_image = new ProductSubImage();
                    $sub_image->product_id = $product->id;
                    $sub_image->sub_image = $imagename;
                    $sub_image->save();
                }
            }
        }

        $product->colors()->attach($request->colors);
        $product->sizes()->attach($request->sizes);

        Toastr::success("Product Created Successfully !!!", "Success");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::latest()->get();
        $brands     = Brand::latest()->get();
        $colors     = Color::latest()->get();
        $sizes      = Size::latest()->get();

        return view('admin.product.edit',compact('product', 'categories', 'brands', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'category_id'           => 'required',
            'brand_id'              => 'required',
            'colors'                => 'required',
            'sizes'                 => 'required',
            'name'                  => 'required',
            'sizes'                 => 'required|mimes:png,jpg,jpeg,gif,webp',
            'price'                 => 'required',
            'short_description'     => 'required',
            'long_description'      => 'required',
        ]);

        $slug = Str::slug($request->name);
        $image = $request->file('image');

        if(isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            // check product folder exists or not
            if(!Storage::disk('public')->exists('product'))
            {
                Storage::disk('public')->makeDirectory('product');
            }
            // delete old image
            if(Storage::disk('public')->exists('product/'.$product->image))
            {
                Storage::disk('public')->delete('product/'.$product->image);
            }

            $productImage = Image::make($image)->resize(1200, 1486)->save($image);
            Storage::disk('public')->put('product/'.$imagename,$productImage);
        }else {
            $imagename = $product->image;
        }

        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;
        $product->name              = $request->name;
        $product->slug              = $slug;
        $product->image             = $imagename;
        $product->price             = $request->price;
        $product->short_description = $request->short_description;
        $product->price             = $request->price;
        $product->long_description  = $request->long_description;

        if($product->save()){
            $files = $request->sub_image;
            $oldSubImages = ProductSubImage::where('product_id', $product->id)->get()->toArray();
// return $oldSubImages;
            if(!empty($oldSubImages))
            {
                foreach($oldSubImages as $value)
                {
                    if(Storage::disk('public')->exists('product/sub/'.$value['sub_image']))
                    {
                        Storage::disk('public')->delete('product/sub/'.$value['sub_image']);
                    }
                    ProductSubImage::where('product_id', $product->id)->delete();
                }
            }

            if(!empty($files)){
                foreach($files as $file){
                    $currentDate = Carbon::now()->toDateString();
                    $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();

                    // check product folder exists or not
                    if(!Storage::disk('public')->exists('product/sub'))
                    {
                        Storage::disk('public')->makeDirectory('product/sub');
                    }
                                    
                    $productSubImage = Image::make($file)->resize(1200, 1486)->save($file);
                    Storage::disk('public')->put('product/sub/'.$imagename,$productSubImage);

                    $sub_image = new ProductSubImage();
                    $sub_image->product_id = $product->id;
                    $sub_image->sub_image = $imagename;
                    $sub_image->save();
                }
            }
        }

        $product->colors()->sync($request->colors);
        $product->sizes()->sync($request->sizes);


        Toastr::success("Product Updated Successfully !!!", "Success");
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image)
        {
            Storage::disk('public')->delete('product/'.$product->image);
        }
        $subImage = ProductSubImage::where('product_id', $product->id)->get();
        if(!empty($subImage))
        {
            foreach($subImage as $a)
            {
                Storage::disk('public')->delete('product/sub/'.$a->image);
            }
        }

        $product->sizes()->detach();
        $product->colors()->detach();

        $product->delete();
        Toastr::success('Product Deleted Successfully !!!', 'Success');
        return back();
    }
}

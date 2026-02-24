<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Taxonomy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Taxonomy::where('is_active', 1)->get();
        $featured_products = Product::where('is_featured', 1)
                                    ->where('is_active', 1)
                                    ->take(8)
                                    ->get();
        $banners = Banner::all();

        return view('home', compact('categories', 'featured_products', 'banners'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}

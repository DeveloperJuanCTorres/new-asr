<?php

namespace App\Http\Controllers;

use App\Mail\Contactanos;
use App\Mail\Reclamos;
use App\Models\Banner;
use App\Models\Company;
use App\Models\Product;
use App\Models\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $company = Company::first();

        return view('home', compact('categories', 'featured_products', 'banners', 'company'));
    }

    public function about()
    {
        $company = Company::first();
        return view('about', compact('company'));
    }

    public function contact()
    {
        $company = Company::first();
        return view('contact', compact('company'));
    }

    public function reclamaciones()
    {
        $company = Company::first();

        return view('libro-reclamaciones', compact('company'));
    }

    public function correoContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
       

        $correo = new Contactanos($request->all());
        try {
            Mail::to('contacto@asrramirez.com')->send($correo);
            return response()->json(['status' => true, 'msg' => "El correo fue enviado satisfactoriamente"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => "Hubo un error al enviar, inténtalo de nuevo más tarde." . $e->getMessage()]);
        }
    }

    public function correoReclamo(Request $request)
    {
        $correo = new Reclamos($request);
        try {
            Mail::to('reclamos@asrramirez.com')->send($correo);
            return response()->json(['status' => true, 'msg' => "El correo fue enviado satisfactoriamente"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => "Hubo un error al enviar, inténtalo de nuevo más tarde." . $e->getMessage()]);
        }
    }
}

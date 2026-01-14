<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriTreatment;
use App\Models\Product;
use App\Models\Treatment;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $kategoritreatment = KategoriTreatment::get();
        $treatment = Treatment::with('kategoritreatment')->get();
        $product = Product::with('kategoriproduk')->get();

        return view('index', compact('kategoritreatment', 'product', 'treatment'));
    }


    public function product()
    {
        $kategoritreatment = KategoriTreatment::get();
        $product = Product::with('kategoriproduk')->get();
        return view('product', compact('product', 'kategoritreatment'));
    }

    public function treatment($slug)
    {
        $kategoritreatment = KategoriTreatment::get();
        $treatment = Treatment::whereHas('kategoritreatment' ,  function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->get();        
        return view('treatment', compact('treatment', 'kategoritreatment'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriOperasional;
use Illuminate\Http\Request;

class KategoriOperasionalController extends Controller
{
    public function index ()
    {
      $kategori = KategoriOperasional::get();
      return view('kategorioperasional.index',compact('kategori'));
    }

    public function store (Request $request)
    {      
       $operasional = KategoriOperasional::create([
            'nama' => $request->nama
       ]);

       return back();
    }

    public function update (Request $request , $id)
    {
         $operasional = KategoriOperasional::where('id',$id)->update([
            'nama' => $request->nama
         ]);

         return back();
    }

    public function destroy ($id)
    {
        KategoriOperasional::where('id',$id)->delete();
        return back();
    }
}

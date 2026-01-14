<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriOperasional;
use App\Models\Operasional;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OperasionalController extends Controller
{
    public function index ()
    {
        $kategori = KategoriOperasional::get();
        $operasional = Operasional::with('kategori')->get();
       return view('operasional.index',compact('kategori','operasional'));
    }

    public function store (Request $request)
    {
       $operasional = Operasional::create([
            'kategorioperasional_id' => $request->kategori_id,
            'nama' => $request->nama,
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d') ,
            'nominal' => $request->nominal
       ]);

       return back();
    }

    public function destroy ($id)
    {  
        Operasional::where('id',$id)->delete();

        return back();
    }

    


}

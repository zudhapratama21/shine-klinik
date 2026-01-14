<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriTreatment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriTreatmentController extends Controller
{
    public function index()
    {
        $kategori = KategoriTreatment::get();
        return view('kategoritreatment.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $namefile = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $nameFile = Storage::disk('public')->putFileAs('kategoritreatment', $file, $filename);            
        }

        KategoriTreatment::create([
            'name' => $request->name,
            'file' => $nameFile,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Kategori Treatment berhasil ditambahkan');
    }

    public function destroy($id)
    {
        KategoriTreatment::find($id)->delete();
        return back()->with('success', 'Kategori Treatment berhasil dihapus');
    }
}

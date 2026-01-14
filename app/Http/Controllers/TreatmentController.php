<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriTreatment;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TreatmentController extends Controller
{
    public function index ()
    {
        $treatment = Treatment::with('kategoritreatment')->get();
        return view('treatment.index', compact('treatment'));
    }

    public function create ()
    {
        $kategori = KategoriTreatment::all();
        return view('treatment.create',compact('kategori'));
    }

      public function store(Request $request)
    {

        $last = Treatment::latest('id')->first();

        $number = $last ? $last->id + 1 : 1;


        $treatment = new Treatment();
        $treatment->nama = $request->nama;
        $treatment->kode = 'TR' . str_pad($number, 4, '0', STR_PAD_LEFT);
        $treatment->kategoritreatment_id = $request->kategori_id;        
        $treatment->harga = $request->harga;
        $treatment->status = $request->status;
        $treatment->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $nameFile = Storage::disk('public')->putFileAs('treatments', $file, $filename);
            $treatment->gambar = $nameFile;
        }

        $treatment->save();

        return redirect()->route('treatment.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit ($id)
    {
        $treatment = Treatment::findOrFail($id);
        $kategori = KategoriTreatment::get();
        return view('treatment.edit', compact('treatment', 'kategori'));
    }
    public function update(Request $request, $id)
    {
        $treatment = Treatment::findOrFail($id);
        $treatment->nama = $request->nama;
        $treatment->kategoritreatment_id = $request->kategori_id;        
        $treatment->harga = $request->harga;
        $treatment->status = $request->status;
        $treatment->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            if ($treatment->gambar) {
                Storage::disk('public')->delete($treatment->gambar);
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $nameFile = Storage::disk('public')->putFileAs('treatments', $file, $filename);
            $treatment->gambar = $nameFile;
        }

        $treatment->save();

        return redirect()->route('treatment.index')->with('success', 'Produk berhasil diubah.');
    }
    
    public function destroy($id)
    {

        $treatment = Treatment::findOrFail($id);
        if ($treatment->image) {
            Storage::disk('public')->delete($treatment->image);
        }
        $treatment->delete();
        return redirect()->route('treatment.index')->with('success', 'Produk berhasil dihapus.');
    }

    
}

<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
  
    public function index()
    {
        $dokter = Dokter::get();
        $judul = 'Data Dokter';
        return view('dokter_index', compact('dokter','judul'));
    }

   
    public function create()
    {
        return view('dokter_create');
    }

    
    public function store(Request $request)
    {       
        $dokter = Dokter::create([
            'kode_dokter' => 'DKT' . date('YmdHis'),
            'nama_dokter' => $request->nama_dokter,
            'nomor_hp' => $request->nomor_hp,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'status' => $request->status,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat
        ]);        
        return redirect()->route('dokter.index');        
    }

    public function show(string $id)
    {
        $data['dokter'] = Dokter::findOrFail($id);
        return view('dokter_show', $data);
    }

   
    public function edit(string $id)
    {
        $dokter = Dokter::findOrFail($id);      
        return view('dokter_edit', compact('dokter'));
    }

  
    public function update(Request $request, string $id)
    {       
        $dokter = Dokter::findOrFail($id);                        
        $dokter->update([
            'nama_dokter' => $request->nama_dokter,
            'nomor_hp' => $request->nomor_hp,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'status' => $request->status,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat
        ]);        
        return redirect()->route('dokter.index');
    }

   
    public function destroy(string $id)
    {
        $dokter = Dokter::findOrFail($id);        
        $dokter->delete();        
        return back();
    }

    public function laporan()
    {
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasienController extends Controller
{

    public function index()
    {
        $data = Pasien::all();
        $judul = 'Data-data Pasien';

        return view('pasien_index', compact('data','judul'));
    }


    public function create()
    {
        $data['judul'] = 'Tambah Data';
        return view('pasien_create', $data);
    }

  
    public function store(Request $request)
    {
        $pasien = Pasien::create([
            'nama_pasien' => $request->nama_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $request->status,
            'nomor_hp' => $request->nomor_hp,
            'kode_pasien' => 'PSN' . date('YmdHis'),
            'email' => $request->email,
            'alamat' => $request->alamat,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'tanggal_lahir' => Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
        ]);

        flash('Data berhasil disimpan');
        return redirect()->route('pasien.index');
    }

    public function show(string $id)
    {
        //
    }

   
    public function edit(string $id)
    {
        $data['pasien'] = \App\Models\Pasien::findOrFail($id);
        $data['judul'] = 'Tambah Data';
        return view('pasien_edit', $data);
    }

 
    public function update(Request $request, string $id)
    {
      
        $pasien = Pasien::where('id', $id)->update([
            'nama_pasien' => $request->nama_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $request->status,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'tanggal_lahir' => Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
        ]);
        
        flash('Data berhasil disimpan');
        return redirect()->route('pasien.index');
    }

   
    public function destroy(string $id)
    {
        $pasien = \App\Models\Pasien::findOrFail($id);
        if ($pasien->administrasi->count() >= 1) {
            flash('Data tidak bisa dihapus karena sudah digunakan')->error();
            return back();
        }
        $pasien->delete();
        flash('Data berhasil dihapus');
        return back();
    }

    public function laporan()
    {
    }
}

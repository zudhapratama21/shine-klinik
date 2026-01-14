<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
  public function index()
  {
    $kategori = KategoriProduk::get();
    $judul =  'Data Kategori Produk';
    return view('kategoriproduk.index', compact('kategori', 'judul'));
  }

  public function store(Request $request)
  {
      KategoriProduk::create($request->all());
      return redirect()->back()->with('success', 'Kategori Produk Berhasil Ditambahkan');
  }

  public function destroy($id)
  {      
      KategoriProduk::destroy($id);
      return redirect()->back()->with('success', 'Kategori Produk Berhasil Dihapus');
  }

}

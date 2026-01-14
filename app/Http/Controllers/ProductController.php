<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HistoryProduct;
use App\Models\KategoriProduk;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with('kategoriproduk')->get();
        $judul = "Data Produk";
        return view('product.index', compact('judul', 'product'));
    }

    public function create()
    {
        $kategori = KategoriProduk::get();
        return view('product.create', compact('kategori'));
    }

    public function store(Request $request)
    {

        $last = Product::latest('id')->first();

        $number = $last ? $last->id + 1 : 1;


        $product = new Product();
        $product->nama = $request->nama;
        $product->kode = 'P' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $product->kategoriproduk_id = $request->kategori_id;
        $product->berat = $request->berat;
        $product->stok = $request->stok;
        $product->harga = $request->harga;
        $product->status = $request->status;
        $product->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $nameFile = Storage::disk('public')->putFileAs('products', $file, $filename);
            $product->image = $nameFile;
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit ($id)
    {
        $product = Product::findOrFail($id);
        $kategori = KategoriProduk::get();
        return view('product.edit', compact('product', 'kategori'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->nama = $request->nama;
        $product->kategoriproduk_id = $request->kategori_id;
        $product->berat = $request->berat;
        $product->stok = $request->stok;
        $product->harga = $request->harga;
        $product->status = $request->status;
        $product->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $nameFile = Storage::disk('public')->putFileAs('products', $file, $filename);
            $product->image = $nameFile;
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Produk berhasil diubah.');
    }
    
    public function destroy($id)
    {

        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function historyProduct ($id)
    {
      $judul = "History Produk";
      $history  = HistoryProduct::where('produk_id',$id)->with('produk')->orderBy('id','desc')->get();
      $product = Product::findOrFail($id);

      return view('product.history',compact('history','judul','product'));

    }
}

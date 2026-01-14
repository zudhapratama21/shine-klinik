<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index ()
    {
      $supplier = Supplier::all();
      return view ('supplier.index', compact('supplier'));
    }

    public function store (Request $request)
    {
        Supplier::create([
            'nama' => $request->nama,
            'kode' => 'SP' . date('YmdHis'),
            'no_telp' => $request->no_telp,
            'npwp' => $request->npwp,
            'alamat' => $request->alamat
        ]);
        return back()->with('success', 'Supplier berhasil ditambahkan');
    }

    function update (Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'npwp' => $request->npwp,
            'alamat' => $request->alamat
        ]);
        return back()->with('success', 'Supplier berhasil ditambahkan');
    }

    public function destroy ($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return back()->with('success', 'Supplier berhasil dihapus');
    }
}

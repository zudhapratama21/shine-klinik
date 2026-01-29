<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('pasien', 'details.produk')->orderByDesc('id')->get();
        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $product = Product::all();
        $pasien = Pasien::all();
        return view('penjualan.create', compact('product', 'pasien'));
    }

    public function saveProduct(Request $request)
    {

        $productId = $request->product_id;

        $product = Product::where('id', $productId)->first();

        // ambil session lama
        $items = session()->get('penjualan_items', []);

        if ($product->stok < $request->qty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stok produk tidak mencukupi.'
            ], 400);
        }

        // cek apakah produk sudah ada di session
        if (isset($items[$productId])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product sudah dipilih'
            ], 409); // atau 422

        } else {

            // kalau belum ada → buat baru
            $items[$productId] = [
                'product_id'     => $productId,
                'qty'            => $request->qty,
                'harga_jual'     => $request->harga_jual,
                'diskon_persen'  => $request->diskon_persen ?? 0,
                'diskon_rupiah'  => $request->diskon_rupiah ?? 0,
                'ongkos_kirim'   => $request->ongkos_kirim ?? 0,
            ];
        }

        // simpan ke session
        session()->put('penjualan_items', $items);

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    public function dataProduct()
    {
        $items = session('penjualan_items', []);

        $data = [];

        foreach ($items as $item) {
            $subtotal = ($item['harga_jual'] * $item['qty']) - ($item['harga_jual'] * $item['qty'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'];

            $data[] = [
                'nama'        => \App\Models\Product::find($item['product_id'])->nama ?? '-',
                'harga_jual'  => $item['harga_jual'],
                'qty'         => $item['qty'],
                'harga'       => $item['harga_jual'] * $item['qty'],
                'diskon_rupiah' => $item['diskon_rupiah'],
                'diskon_persen' => $item['diskon_persen'],
                'subtotal'    => $subtotal,
                'product_id'  => $item['product_id'],
                'ongkos_kirim'   => $item['ongkos_kirim'] ?? 0,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function hapusItem(Request $request)
    {
        $productId = $request->product_id;

        // ambil session lama
        $items = session()->get('penjualan_items', []);

        // hapus item berdasarkan product_id
        unset($items[$productId]);

        // simpan kembali ke session
        session()->put('penjualan_items', $items);

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    public function hitungTotal()
    {
        $items = session('penjualan_items', []);

        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_jual'] * $item['qty'];
            $total_diskon += ($item['harga_jual'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
            $total_ongkir += $item['ongkos_kirim'] ?? 0;
        }

        $ppn = 0; // Misalnya tidak ada PPN 
        $total = $subtotal - $total_diskon + $total_ongkir;


        return response()->json([
            'subtotal'      => number_format($subtotal, 0, ',', '.'),
            'diskon'        => number_format($total_diskon, 0, ',', '.'),
            'ongkir'        => number_format($total_ongkir, 0, ',', '.'),
            'total'         => number_format($total, 0, ',', '.'),
            'ppn'         => number_format($ppn, 0, ',', '.')
        ]);
    }


    public function simpan(Request $request)
    {

        $last = Penjualan::latest('id')->first();

        $number = $last ? $last->id + 1 : 1;

        $items = session('penjualan_items', []);

        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_jual'] * $item['qty'];
            $total_diskon += ($item['harga_jual'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
            $total_ongkir += $item['ongkos_kirim'] ?? 0;
        }

        // Hitung grand total
        $grandtotal = $subtotal - $total_diskon + $total_ongkir;

        // Simpan penjualan
        $penjualan = Penjualan::create([
            'kode' => ' TRXPJ' . str_pad($number, 4, '0', STR_PAD_LEFT),
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'pasien_id' => (int)$request->pasien,
            'subtotal' => (float)$subtotal,
            'diskon' => (float)$total_diskon,
            'ppn' => 0, // Misalnya tidak ada PPN
            'grandtotal' => (float)$grandtotal,
            'keterangan' => $request->keterangan
        ]);

        foreach ($items as $item) {
            \App\Models\PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $item['product_id'],
                'qty' => $item['qty'],
                'harga_jual' => $item['harga_jual'],
                'diskon_persen' => $item['diskon_persen'],
                'diskon_rupiah' => $item['diskon_rupiah'],
                'subtotal' => ($item['harga_jual'] * $item['qty']),
                'total' => ($item['harga_jual'] * $item['qty']) - ($item['harga_jual'] * $item['qty'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'],
                'ongkos_kirim' => $item['ongkos_kirim'] ?? 0,
            ]);

            // Update stok produk
            $product = Product::find($item['product_id']);
            $product->stok -= $item['qty'];
            $product->save();

            // save di history product
            \App\Models\HistoryProduct::create([
                'produk_id' => $item['product_id'],
                'kode_transaksi' => $penjualan->kode,
                'jenis' => 'PJ',
                'qty' => $item['qty'],
                'stok' => $product->stok,
            ]);
        }

        // Hapus session items setelah disimpan
        session()->forget('penjualan_items');

        return response()->json([
            'status' => 'success',
            'message' => 'Penjualan berhasil disimpan.'
        ]);
    }

    public function edit($id)
    {
        $pasien = Pasien::all();
        $product = Product::all();

        $penjualan = Penjualan::with('details.produk')->find($id);
        return view('penjualan.edit', compact('pasien', 'product', 'penjualan'));
    }

    public function dataProductEdit(Request $request)
    {
        $items = PenjualanDetail::with('produk')->where('penjualan_id', $request->id)->get();

        $data = [];

        foreach ($items as $item) {
            $subtotal = ($item['harga_jual'] * $item['qty']) - ($item['harga_jual'] * $item['qty'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'];

            $data[] = [
                'nama'        => \App\Models\Product::find($item['produk_id'])->nama ?? '-',
                'harga_jual'  => $item['harga_jual'],
                'qty'         => $item['qty'],
                'harga'       => $item['harga_jual'] * $item['qty'],
                'diskon_rupiah' => $item['diskon_rupiah'],
                'diskon_persen' => $item['diskon_persen'],
                'subtotal'    => $subtotal,
                'product_id'  => $item['produk_id'],
                'ongkos_kirim'   => $item['ongkos_kirim'] ?? 0,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function hitungTotalEdit(Request $request)
    {
        $items = PenjualanDetail::where('penjualan_id', $request->id)->get();

        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_jual'] * $item['qty'];
            $total_diskon += ($item['harga_jual'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
            $total_ongkir += $item['ongkos_kirim'] ?? 0;
        }

        $ppn = 0; // Misalnya tidak ada PPN 
        $total = $subtotal - $total_diskon + $total_ongkir;

        return response()->json([
            'subtotal'      => number_format($subtotal, 0, ',', '.'),
            'diskon'        => number_format($total_diskon, 0, ',', '.'),
            'ongkir'        => number_format($total_ongkir, 0, ',', '.'),
            'total'         => number_format($total, 0, ',', '.'),
            'ppn'         => number_format($ppn, 0, ',', '.')
        ]);
    }


    public function hapusItemEdit(Request $request)
    {
        $item = PenjualanDetail::with('penjualan')->where('penjualan_id', $request->penjualan_id)
            ->where('produk_id', $request->product_id)
            ->first();
        $product = Product::find($request->product_id);


        $product->stok += $item->qty;
        $product->save();

        // save di history product
        \App\Models\HistoryProduct::create([
            'produk_id' => $product->id,
            'kode_transaksi' => $item->penjualan->kode,
            'jenis' => 'PJ(edit)',
            'qty' => $item['qty'],
            'stok' => $product->stok,
        ]);

        $item->delete();

        return response()->json(['status' => 'success', 'message' => 'Item berhasil dihapus.']);
    }

    public function saveProductEdit(Request $request)
    {
        $penjualan = Penjualan::find($request->penjualan_id);
        $produk = Product::find($request->product_id);

        // Kurangi stok produk
        $produk->stok -= $request->qty;
        $produk->save();

        // save di history product
        \App\Models\HistoryProduct::create([
            'produk_id' => $produk->id,
            'kode_transaksi' => $penjualan->kode,
            'jenis' => 'PJ',
            'qty' => $request->qty,
            'stok' => $produk->stok,
        ]);

        PenjualanDetail::create([
            'penjualan_id' => $request->penjualan_id,
            'produk_id' => $request->product_id,
            'harga_jual' => $request->harga_jual,
            'qty' => $request->qty,
            'diskon_persen' => $request->diskon_persen ?? 0,
            'diskon_rupiah' => $request->diskon_rupiah ?? 0,
            'subtotal' => $request->harga_jual * $request->qty,
            'ongkos_kirim' => $request->ongkos_kirim ?? 0,
            'total' => ($request->harga_jual * $request->qty) - ($request->harga_jual * $request->qty * ($request->diskon_persen ?? 0) / 100) - ($request->diskon_rupiah ?? 0),
        ]);

        // hitung ulang untuk total yang ada di penjualan
        $items = PenjualanDetail::where('penjualan_id', $request->penjualan_id)->get();
        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_jual'] * $item['qty'];
            $total_diskon += ($item['harga_jual'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
            $total_ongkir += $item['ongkos_kirim'] ?? 0;
        }

        // Update total penjualan
        $penjualan->update([
            'subtotal' => $subtotal,
            'diskon' => $total_diskon,
            'ongkir' => $total_ongkir,
            'ppn' => 0,
            'grandtotal' => ($subtotal - $total_diskon + $total_ongkir)
        ]);

        return response()->json(['status' => 'success', 'message' => 'Item berhasil ditambahkan.']);
    }

    public function simpanEdit(Request $request)
    {
        $penjualan = Penjualan::find($request->penjualan_id);
        $penjualan->update([
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'pasien_id' => $request->pasien,            
            'keterangan' => $request->keterangan
        ]);


        return response()->json(['status' => 'success', 'message' => 'Penjualan berhasil disimpan.']);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::with('details')->find($id);

        // Kembalikan stok produk sebelum menghapus penjualan
        foreach ($penjualan->details as $detail) {
            $product = Product::find($detail->produk_id);

            $product->stok += $detail->qty;
            $product->save();

            // save di history product
            \App\Models\HistoryProduct::create([
                'produk_id' => $product->id,
                'kode_transaksi' => $penjualan->kode,
                'jenis' => 'Hapus PO',
                'qty' => $detail->qty,
                'stok' => $product->stok,
            ]);
        }

        // Hapus detail penjualan
        PenjualanDetail::where('penjualan_id', $id)->delete();

        // Hapus penjualan
        $penjualan->delete();

        return response()->json(['status' => 'success', 'message' => 'Penjualan berhasil dihapus.']);
    }

    public function print ($id)
    {
        $penjualan = Penjualan::with('details.produk','pasien')->findOrFail($id);
        $jmlBaris  = $penjualan->details->count();
        $perBaris = 22;
        $totalPage = ceil($jmlBaris / $perBaris);
        $ongkir = PenjualanDetail::where('penjualan_id', $id)->sum('ongkos_kirim');
        
        $data = [
            'totalPage' => $totalPage,
            'perBaris' => $perBaris,
            'date' => date('d/m/Y'),
            'penjualan' => $penjualan,
            'penjualandetail' => $penjualan->details,
            'ongkir' => $ongkir
        ];

        $pdf = Pdf::loadView('penjualan.print', $data)->setPaper('a5', 'landscape');
        return $pdf->download( $penjualan->kode . '.pdf');
    }
}

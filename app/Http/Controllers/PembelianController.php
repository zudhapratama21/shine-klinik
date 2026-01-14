<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

use function PHPSTORM_META\map;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::with('supplier', 'details.produk')->orderByDesc('id')->get();
        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $product = Product::all();
        $supplier = Supplier::all();
        return view('pembelian.create', compact('product', 'supplier'));
    }

    public function saveProduct(Request $request)
    {
        $productId = $request->product_id;

        // ambil session lama
        $items = session()->get('pembelian_items', []);

        // cek apakah produk sudah ada di session
        if (isset($items[$productId])) {

            // kalau sudah ada → qty ditambah
            $items[$productId]['qty'] += $request->qty;
        } else {

            // kalau belum ada → buat baru
            $items[$productId] = [
                'product_id'     => $productId,
                'qty'            => $request->qty,
                'harga_beli'     => $request->harga_beli,
                'diskon_persen'  => $request->diskon_persen ?? 0,
                'diskon_rupiah'  => $request->diskon_rp ?? 0,
                'ongkos_kirim'   => $request->ongkos_kirim ?? 0,
            ];
        }

        // simpan ke session
        session()->put('pembelian_items', $items);

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    public function dataProduct()
    {
        $items = session('pembelian_items', []);

        $data = [];

        foreach ($items as $item) {
            $subtotal = ($item['harga_beli'] * $item['qty']) - ($item['harga_beli'] * $item['qty'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'];

            $data[] = [
                'nama'        => \App\Models\Product::find($item['product_id'])->nama ?? '-',
                'harga_beli'  => $item['harga_beli'],
                'qty'         => $item['qty'],
                'harga'       => $item['harga_beli'] * $item['qty'],
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
        $items = session()->get('pembelian_items', []);

        // hapus item berdasarkan product_id
        unset($items[$productId]);

        // simpan kembali ke session
        session()->put('pembelian_items', $items);

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    public function hitungTotal()
    {
        $items = session('pembelian_items', []);

        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_beli'] * $item['qty'];
            $total_diskon += ($item['harga_beli'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
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

        $last = Pembelian::latest('id')->first();

        $number = $last ? $last->id + 1 : 1;

        $items = session('pembelian_items', []);

        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_beli'] * $item['qty'];
            $total_diskon += ($item['harga_beli'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
            $total_ongkir += $item['ongkos_kirim'] ?? 0;
        }

        // Hitung grand total
        $grandtotal = $subtotal - $total_diskon + $total_ongkir;

        // Simpan pembelian
        $pembelian = Pembelian::create([
            'kode' => ' TRXP' . str_pad($number, 4, '0', STR_PAD_LEFT),
            'kode_supplier' => $request->kode,
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'supplier_id' => (int)$request->supplier,
            'subtotal' => (float)$subtotal,
            'diskon' => (float)$total_diskon,
            'ppn' => 0, // Misalnya tidak ada PPN
            'grandtotal' => (float)$grandtotal,
            'keterangan' => $request->keterangan
        ]);

        foreach ($items as $item) {
            \App\Models\PembelianDetail::create([
                'pembelian_id' => $pembelian->id,
                'produk_id' => $item['product_id'],
                'qty' => $item['qty'],
                'harga_beli' => $item['harga_beli'],
                'diskon_persen' => $item['diskon_persen'],
                'diskon_rupiah' => $item['diskon_rupiah'],
                'subtotal' => ($item['harga_beli'] * $item['qty']),
                'total' => ($item['harga_beli'] * $item['qty']) - ($item['harga_beli'] * $item['qty'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'],
                'ongkos_kirim' => $item['ongkos_kirim'] ?? 0,
            ]);

            // Update stok produk
            $product = Product::find($item['product_id']);
            $product->stok += $item['qty'];
            $product->save();

            // save di history product
            \App\Models\HistoryProduct::create([
                'produk_id' => $item['product_id'],
                'kode_transaksi' => $pembelian->kode,
                'jenis' => 'PO',
                'qty' => $item['qty'],
                'stok' => $product->stok,
            ]);
        }

        // Hapus session items setelah disimpan
        session()->forget('pembelian_items');

        return response()->json([
            'status' => 'success',
            'message' => 'Pembelian berhasil disimpan.'
        ]);
    }

    public function edit($id)
    {
        $supplier = Supplier::all();
        $product = Product::all();

        $pembelian = Pembelian::with('details.produk')->find($id);
        return view('pembelian.edit', compact('supplier', 'product', 'pembelian'));
    }

    public function dataProductEdit(Request $request)
    {
        $items = PembelianDetail::with('produk')->where('pembelian_id', $request->id)->get();

        $data = [];

        foreach ($items as $item) {
            $subtotal = ($item['harga_beli'] * $item['qty']) - ($item['harga_beli'] * $item['qty'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'];

            $data[] = [
                'nama'        => \App\Models\Product::find($item['produk_id'])->nama ?? '-',
                'harga_beli'  => $item['harga_beli'],
                'qty'         => $item['qty'],
                'harga'       => $item['harga_beli'] * $item['qty'],
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
        $items = PembelianDetail::where('pembelian_id', $request->id)->get();

        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_beli'] * $item['qty'];
            $total_diskon += ($item['harga_beli'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
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
        $item = PembelianDetail::with('pembelian')->where('pembelian_id', $request->pembelian_id)
            ->where('produk_id', $request->product_id)
            ->first();
        $product = Product::find($request->product_id);

        if ($product->stok <= $item->qty) {
            return response()->json(['status' => 'error', 'message' => 'Stok produk tidak mencukupi untuk menghapus item ini.']);
        } else {
            // Kurangi stok produk
            $product->stok -= $item->qty;
            $product->save();

            // save di history product
            \App\Models\HistoryProduct::create([
                'produk_id' => $product->id,
                'kode_transaksi' => $item->pembelian->kode,
                'jenis' => 'PO(edit)',
                'qty' => $item['qty'] * -1,
                'stok' => $product->stok,
            ]);

            $item->delete();

            return response()->json(['status' => 'success', 'message' => 'Item berhasil dihapus.']);
        }
    }

    public function saveProductEdit(Request $request)
    {
        $pembelian = Pembelian::find($request->pembelian_id);
        $produk = Product::find($request->product_id);

        // Kurangi stok produk
        $produk->stok += $request->qty;
        $produk->save();

        // save di history product
        \App\Models\HistoryProduct::create([
            'produk_id' => $produk->id,
            'kode_transaksi' => $pembelian->kode,
            'jenis' => 'PO',
            'qty' => $request->qty,
            'stok' => $produk->stok,
        ]);

        PembelianDetail::create([
            'pembelian_id' => $request->pembelian_id,
            'produk_id' => $request->product_id,
            'harga_beli' => $request->harga_beli,
            'qty' => $request->qty,
            'diskon_persen' => $request->diskon_persen ?? 0,
            'diskon_rupiah' => $request->diskon_rupiah ?? 0,
            'subtotal' => $request->harga_beli * $request->qty,
            'ongkos_kirim' => $request->ongkos_kirim ?? 0,
            'total' => ($request->harga_beli * $request->qty) - ($request->harga_beli * $request->qty * ($request->diskon_persen ?? 0) / 100) - ($request->diskon_rupiah ?? 0),
        ]);

        // hitung ulang untuk total yang ada di pembelian
        $items = PembelianDetail::where('pembelian_id', $request->pembelian_id)->get();
        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga_beli'] * $item['qty'];
            $total_diskon += ($item['harga_beli'] * $item['qty'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
            $total_ongkir += $item['ongkos_kirim'] ?? 0;
        }

        // Update total pembelian
        $pembelian->update([
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
        $pembelian = Pembelian::find($request->pembelian_id);
        $pembelian->update([
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'supplier_id' => $request->supplier,
            'kode_supplier' => $request->kode,
            'keterangan' => $request->keterangan
        ]);

        return response()->json(['status' => 'success', 'message' => 'Pembelian berhasil disimpan.']);
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::with('details')->find($id);

        // Kembalikan stok produk sebelum menghapus pembelian
        foreach ($pembelian->details as $detail) {
            $product = Product::find($detail->produk_id);

            if ($product->stok < $detail->qty) {
                return response()->json([
                    'message' => 'Stok produk tidak mencukupi untuk menghapus pembelian ini. Barang sudah mengalami pengeluaran'
                ], 422); // atau 400
            } else {
                $product->stok -= $detail->qty;
                $product->save();

                // save di history product
                \App\Models\HistoryProduct::create([
                    'produk_id' => $product->id,
                    'kode_transaksi' => $pembelian->kode,
                    'jenis' => 'Hapus PO',
                    'qty' => $detail->qty * -1,
                    'stok' => $product->stok,
                ]);
            }
        }

        // Hapus detail pembelian
        PembelianDetail::where('pembelian_id', $id)->delete();

        // Hapus pembelian
        $pembelian->delete();

        return response()->json(['status' => 'success', 'message' => 'Pembelian berhasil dihapus.']);
    }
}

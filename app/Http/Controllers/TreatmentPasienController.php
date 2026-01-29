<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HistoryProduct;
use App\Models\Pasien;
use App\Models\Product;
use App\Models\Treatment;
use App\Models\TreatmentPasien;
use App\Models\TreatmentPasienDetail;
use App\Models\TreatmentPasienProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TreatmentPasienController extends Controller
{
    public function index()
    {

        $treatment = TreatmentPasien::with('pasien', 'details','dokter')->get();
        return view('treatmentpasien.index', compact('treatment'));
    }

    public function create()
    {
        $pasien = Pasien::get();
        $dokter = Dokter::get();
        $treatment = Treatment::get();

        return view('treatmentpasien.create', compact('pasien', 'treatment','dokter'));
    }

    public function saveTreatment(Request $request)
    {
        $treatmentId = $request->treatment_id;

        // ambil session lama
        $items = session()->get('treatment_pasien', []);

        if (isset($items[$treatmentId])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Treatment sudah dipilih'
            ], 409); // atau 422

        } else {

            // kalau belum ada → buat baru
            $items[$treatmentId] = [
                'treatment_id'     => $treatmentId,
                'harga'     => $request->harga,
                'diskon_persen'  => $request->diskon_persen ?? 0,
                'diskon_rupiah'  => $request->diskon_rupiah ?? 0,
                'ongkos_kirim'   => $request->ongkos_kirim ?? 0,
            ];
        }

        // simpan ke session
        session()->put('treatment_pasien', $items);

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    public function dataTreatment()
    {
        $items = session('treatment_pasien', []);

        $data = [];

        foreach ($items as $item) {
            $subtotal = ($item['harga']) - ($item['harga'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'];

            $data[] = [
                'nama'        => \App\Models\Treatment::find($item['treatment_id'])->nama ?? '-',
                'harga'  => $item['harga'],
                'diskon_rupiah' => $item['diskon_rupiah'],
                'diskon_persen' => $item['diskon_persen'],
                'subtotal'    => $subtotal,
                'treatment_id'  => $item['treatment_id'],
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function hapusItem(Request $request)
    {
        $treatmentId = $request->treatment_id;

        // ambil session lama
        $items = session()->get('treatment_pasien', []);

        // hapus item berdasarkan product_id
        unset($items[$treatmentId]);

        // simpan kembali ke session
        session()->put('treatment_pasien', $items);

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    public function hitungTotal()
    {
        $items = session('treatment_pasien', []);

        $subtotal = 0;
        $total_diskon = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga'];
            $total_diskon += ($item['harga']  * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
        }

        $ppn = 0; // Misalnya tidak ada PPN 
        $total = $subtotal - $total_diskon;


        return response()->json([
            'subtotal'      => number_format($subtotal, 0, ',', '.'),
            'diskon'        => number_format($total_diskon, 0, ',', '.'),
            'total'         => number_format($total, 0, ',', '.'),
            'ppn'         => number_format($ppn, 0, ',', '.')
        ]);
    }

    public function simpan(Request $request)
    {

        $last = TreatmentPasien::latest('id')->first();

        $number = $last ? $last->id + 1 : 1;

        $items = session('treatment_pasien', []);

        $subtotal = 0;
        $total_diskon = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga'];
            $total_diskon += ($item['harga'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
        }

        // Hitung grand total
        $grandtotal = $subtotal - $total_diskon;

        // Simpan penjualan
        $treatment = TreatmentPasien::create([
            'kode' => ' TRXPS' . str_pad($number, 4, '0', STR_PAD_LEFT),
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'pasien_id' => (int)$request->pasien,
            'dokter_id' => (int)$request->dokter,
            'subtotal' => (float)$subtotal,
            'diskon' => (float)$total_diskon,
            'ppn' => 0, // Misalnya tidak ada PPN
            'grandtotal' => (float)$grandtotal,
            'keterangan' => $request->keterangan
        ]);

        foreach ($items as $item) {
            \App\Models\TreatmentPasienDetail::create([
                'treatmentpasien_id' => $treatment->id,
                'treatment_id' => $item['treatment_id'],
                'harga' => $item['harga'],
                'diskon_persen' => $item['diskon_persen'],
                'diskon_rupiah' => $item['diskon_rupiah'],
                'total' => ($item['harga']) - ($item['harga']  * $item['diskon_persen'] / 100) - $item['diskon_rupiah'],
            ]);
        }

        // Hapus session items setelah disimpan
        session()->forget('treatment_pasien');

        return response()->json([
            'status' => 'success',
            'message' => 'Penjualan berhasil disimpan.'
        ]);
    }

    public function edit($id)
    {
        $pasien =  Pasien::get();
        $treatment = Treatment::get();
        $dokter = Dokter::get();

        $treatmentpasien = TreatmentPasien::where('id', $id)->first();

        return view('treatmentpasien.edit', compact('pasien', 'treatment', 'treatmentpasien','dokter'));
    }

    public function dataTreatmentEdit(Request $request)
    {
        $items = TreatmentPasienDetail::with('treatment')->where('treatmentpasien_id', $request->id)->get();

        $data = [];

        foreach ($items as $item) {
            $subtotal = ($item['harga']) - ($item['harga'] * $item['diskon_persen'] / 100) - $item['diskon_rupiah'];

            $data[] = [
                'nama'        => \App\Models\Treatment::find($item['treatment_id'])->nama ?? '-',
                'harga'       => $item['harga'],
                'diskon_rupiah' => $item['diskon_rupiah'],
                'diskon_persen' => $item['diskon_persen'],
                'subtotal'    => $subtotal,
                'treatmentpasien_id'  => $item['treatmentpasien_id'],
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function hitungTotalEdit(Request $request)
    {
        $items = TreatmentPasienDetail::where('treatmentpasien_id', $request->id)->get();

        $subtotal = 0;
        $total_diskon = 0;
        $total_ongkir = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga'];
            $total_diskon += ($item['harga']  * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
        }

        $ppn = 0; // Misalnya tidak ada PPN 
        $total = $subtotal - $total_diskon + $total_ongkir;

        return response()->json([
            'subtotal'      => number_format($subtotal, 0, ',', '.'),
            'diskon'        => number_format($total_diskon, 0, ',', '.'),
            'total'         => number_format($total, 0, ',', '.'),
            'ppn'         => number_format($ppn, 0, ',', '.')
        ]);
    }

    public function hapusItemEdit(Request $request)
    {
        $items = TreatmentPasienDetail::where('treatmentpasien_id', $request->treatmentpasien_id)
            ->where('treatment_id', $request->id)
            ->first();

        $treatment = TreatmentPasienDetail::where('treatmentpasien_id', $request->treatmentpasien_id)->get();

        $subtotal = 0;
        $total_diskon = 0;
        // ngubah grandtotal di treatment pasien
        foreach ($treatment as $item) {
            $subtotal += $item['harga'];
            $total_diskon += ($item['harga'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
        }

        TreatmentPasien::where('id', $request->treatmentpasien_id)->update([
            'subtotal' => $subtotal,
            'diskon' => $total_diskon,
            'ppn' => 0,
            'grandtotal' => $subtotal - $total_diskon,
        ]);

        $item->delete();

        return response()->json(['status' => 'success', 'message' => 'Item berhasil dihapus.']);
    }

    public function saveTreatmentEdit(Request $request)
    {
        $treatment = TreatmentPasien::find($request->treatmentpasien_id);

        TreatmentPasienDetail::create([
            'treatmentpasien_id' => $treatment->id,
            'treatment_id' => $request->treatment_id,
            'harga' => $request->harga,
            'diskon_persen' => $request->diskon_persen ?? 0,
            'diskon_rupiah' => $request->diskon_rupiah ?? 0,
            'total' => ($request->harga) - ($request->harga * ($request->diskon_persen ?? 0) / 100) - ($request->diskon_rupiah ?? 0),
        ]);

        // hitung ulang untuk total yang ada di penjualan
        $items = TreatmentPasienDetail::where('treatmentpasien_id', $request->treatmentpasien_id)->get();
        $subtotal = 0;
        $total_diskon = 0;

        foreach ($items as $item) {
            $subtotal += $item['harga'];
            $total_diskon += ($item['harga'] * $item['diskon_persen'] / 100) + $item['diskon_rupiah'];
        }

        // Update total penjualan
        $treatment->update([
            'subtotal' => $subtotal,
            'diskon' => $total_diskon,
            'ppn' => 0,
            'grandtotal' => ($subtotal - $total_diskon)
        ]);

        return response()->json(['status' => 'success', 'message' => 'Item berhasil ditambahkan.']);
    }

    public function simpanEdit(Request $request)
    {
        $treatment = TreatmentPasien::find($request->treatmentpasien_id);
        $treatment->update([
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'pasien_id' => $request->pasien,
            'dokter_id' => $request->dokter,
            'keterangan' => $request->keterangan
        ]);

        return response()->json(['status' => 'success', 'message' => 'Penjualan berhasil disimpan.']);
    }

    public function inputProduk($id)
    {
        $product = Product::get();
        $treatmentproduct = TreatmentPasienProduct::where('treatmentpasien_id', $id)->with('product')->get();
        return view('treatmentpasien.inputproduk', compact('id', 'product', 'treatmentproduct'));
    }

    public function tambahProduk(Request $request, $id)
    {        
        $produk = Product::where('id', $request->produk_id)->first();
        $treatment = TreatmentPasien::where('id', $id)->first();
        if ($produk->stok < $request->qty) {
            return back()->with('error', 'Stok Tidak Mencukupi');
        } else {
            $stok = $produk->stok - $request->qty;
            
            $produk->update([
                'stok' => $stok
            ]);

            HistoryProduct::create([
                'produk_id' => $produk->id,
                'kode_transaksi' => $treatment->kode,
                'jenis' => 'Tr',
                'qty' => -1 * $request->qty,
                'stok' => $stok,
            ]);

            TreatmentPasienProduct::create([
                'product_id' => $produk->id,
                'treatmentpasien_id' => $id,
                'qty' => $request->qty
            ]);
        }

        return back();
    }

    public function deleteProduk($id)
    {
        $treatment = TreatmentPasienProduct::where('id', $id)->with('treatmentpasien')->first();
        $produk = Product::where('id', $treatment->product_id)->first();

        $stok = $produk->stok + $treatment->qty;
        $produk->update([
            'stok' => $stok
        ]);

        HistoryProduct::create([
            'produk_id' => $produk->id,
            'kode_transaksi' => $treatment->treatmentpasien->kode,
            'jenis' => 'Tr(DEL)',
            'qty' => $treatment->qty,
            'stok' => $stok,
        ]);

        $treatment->delete();

        return back();
    }

    public function destroy($id)
    {
        $treatmentproduk =  TreatmentPasienProduct::where('treatmentpasien_id',$id)->first();

        if ($treatmentproduk) {
            return back()->with('error', 'Data tidak bisa dihapus , hapus product terlebih dahulu');
        }else{
            $treatment = TreatmentPasien::where('id',$id)->delete();
        }

        return back();
    }


    public function print ($id)
    {
        $treatment = TreatmentPasien::where('id', $id)->with('pasien', 'dokter')->first();
        $treatmentdetail = TreatmentPasienDetail::where('treatmentpasien_id', $id)->with('treatment')->get();

        $jmlBaris  = count($treatmentdetail);
        $perBaris = 22;
        $totalPage = ceil($jmlBaris / $perBaris);        
        
        $data = [
            'totalPage' => $totalPage,
            'perBaris' => $perBaris,
            'date' => date('d/m/Y'),
            'treatment' => $treatment,
            'treatmentdetail' => $treatmentdetail,           
        ];

        $pdf = Pdf::loadView('treatmentpasien.print', $data)->setPaper('a5', 'landscape');
        return $pdf->download( $treatment->kode . '.pdf');        
    }
}

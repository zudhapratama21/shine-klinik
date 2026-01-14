<?php

namespace App\Http\Controllers;

use App\Models\Operasional;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\TreatmentPasien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $penjualan = Penjualan::sum('grandtotal');
        $pembelian = Pembelian::sum('grandtotal');
        $treatment = TreatmentPasien::sum('grandtotal');
        $operasional = Operasional::sum('nominal');


        return view('home', compact('penjualan', 'pembelian', 'treatment', 'operasional'));
    }


    public function grafikPenjualan(Request $request)
    {
        $data = Penjualan::selectRaw('MONTH(tanggal) bulan, SUM(grandtotal) total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $total = [];


        foreach ($data as $key) {
            $total[$key->bulan] = [
                'total' => $key->total
            ];
        }

        $laba = array();
        // $total = [;
        for ($i = 0; $i <= 12; $i++) {
            if ($i == 0) {
                $laba[] = 0;
                $bulan[] = 0;
            } else {
                if (!empty($total[$i])) {
                    $laba[] = $total[$i]['total'];
                } else {
                    $laba[] = 0;
                }
                $databulan = '1-' . $i . '-2023';
                $bulan[] = Carbon::parse($databulan)->format('F');
            }
        }

        return response()->json([
            'total' => $laba,
            'bulan' => $bulan
        ]);
    }

    public function grafikTreatment(Request $request)
    {
        $data = TreatmentPasien::selectRaw('MONTH(tanggal) bulan, SUM(grandtotal) total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $total = [];


        foreach ($data as $key) {
            $total[$key->bulan] = [
                'total' => $key->total
            ];
        }

        $laba = array();
        // $total = [;
        for ($i = 0; $i <= 12; $i++) {
            if ($i == 0) {
                $laba[] = 0;
                $bulan[] = 0;
            } else {
                if (!empty($total[$i])) {
                    $laba[] = $total[$i]['total'];
                } else {
                    $laba[] = 0;
                }
                $databulan = '1-' . $i . '-2023';
                $bulan[] = Carbon::parse($databulan)->format('F');
            }
        }

        return response()->json([
            'total' => $laba,
            'bulan' => $bulan
        ]);
    }

    public function grafikPembelian()
    {
        $data = Pembelian::selectRaw('MONTH(tanggal) bulan, SUM(grandtotal) total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $total = [];


        foreach ($data as $key) {
            $total[$key->bulan] = [
                'total' => $key->total
            ];
        }

        $laba = array();
        // $total = [;
        for ($i = 0; $i <= 12; $i++) {
            if ($i == 0) {
                $laba[] = 0;
                $bulan[] = 0;
            } else {
                if (!empty($total[$i])) {
                    $laba[] = $total[$i]['total'];
                } else {
                    $laba[] = 0;
                }
                $databulan = '1-' . $i . '-2023';
                $bulan[] = Carbon::parse($databulan)->format('F');
            }
        }

        return response()->json([
            'total' => $laba,
            'bulan' => $bulan
        ]);
    }

    public function grafikOperasional(Request $request)
    {
        $data = Operasional::selectRaw('MONTH(tanggal) bulan, SUM(nominal) total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $total = [];


        foreach ($data as $key) {
            $total[$key->bulan] = [
                'total' => $key->total
            ];
        }

        $laba = array();
        // $total = [;
        for ($i = 0; $i <= 12; $i++) {
            if ($i == 0) {
                $laba[] = 0;
                $bulan[] = 0;
            } else {
                if (!empty($total[$i])) {
                    $laba[] = $total[$i]['total'];
                } else {
                    $laba[] = 0;
                }
                $databulan = '1-' . $i . '-2023';
                $bulan[] = Carbon::parse($databulan)->format('F');
            }
        }

        return response()->json([
            'total' => $laba,
            'bulan' => $bulan
        ]);
    }
}

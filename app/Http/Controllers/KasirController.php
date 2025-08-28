<?php

namespace App\Http\Controllers;

use App\Models\kartu;
use App\Models\Barang;
use App\Models\Santri;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KasirController extends Controller
{
    public function index()
    {
        $data = Barang::get();
        return view('kasir.kasir', compact('data'));
    }

    public function transaksi(Request $request)
    {
        try {
            // Validasi request
            $validator = Validator::make($request->all(), [
                'no_kartu' => 'required',
                'pin' => 'required',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer', // TAMBAH VALIDASI ID BARANG
                'items.*.nama' => 'required|string',
                'items.*.jumlah' => 'required|integer|min:1',
                'items.*.harga' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $idpegawai = $user->id_pegawai;
            
            $kartu = Kartu::where('no_kartu', $request->no_kartu)->first();

            if (!$kartu) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kartu tidak ditemukan.'
                ], 404);
            }

            if ($kartu->status !== 'aktif') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kartu tidak aktif.'
                ], 400);
            }

            if (!Hash::check($request->pin, $kartu->pin)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'PIN salah.'
                ], 400);
            }

            $total = collect($request->items)->sum(fn($item) => $item['jumlah'] * $item['harga']);

            if ($kartu->saldo < $total) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Saldo tidak mencukupi. Saldo tersedia: Rp' . number_format($kartu->saldo, 0, ',', '.')
                ], 400);
            }

            DB::beginTransaction();

            $saldo_awal = $kartu->saldo;
            $saldo_akhir = $saldo_awal - $total;

            // Kurangi saldo kartu
            $kartu->update(['saldo' => $saldo_akhir]);

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'id_santri' => $kartu->id_santri,
                'id_pegawai' => $idpegawai,
                'jenis' => 'pembelian',
                'total' => $total,
                'saldo_awal' => $saldo_awal,
                'saldo_akhir' => $saldo_akhir,
                'tanggal_transaksi' => now(),
            ]);

            // Simpan detail transaksi 
            foreach ($request->items as $item) {
            $transaksi->detail()->create([
                'id_barang' => $item['id'], 
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'], 
                'sub_total' => $item['jumlah'] * $item['harga'], 
            ]);
        }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil. Saldo akhir: Rp' . number_format($saldo_akhir, 0, ',', '.'),
                'saldo_akhir' => $saldo_akhir
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Transaksi Error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}
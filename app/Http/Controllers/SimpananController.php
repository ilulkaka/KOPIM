<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AnggotaModel;
use App\Models\SimpananModel;

class SimpananController extends Controller
{
    public function frm_simpanan()
    {
        $no_anggota = AnggotaModel::where('status', '=', 'Aktif')->get();
        return view('transaksi/frm_simpanan', [
            'no_anggota' => $no_anggota,
        ]);
    }

    public function simpan_sim(Request $request)
    {
        //dd($request->all());
        $namaanggota = AnggotaModel::select('nama')
            ->where('no_barcode', $request->sim_nomer)
            ->get();

        if ($request->role == 'Administrator') {
            $ins_sim = SimpananModel::create([
                'id_simpanan' => str::uuid(),
                'no_anggota' => $request->sim_nomer,
                'nama' => $namaanggota[0]->nama,
                'jml_simpanan' => $request->sim_jml,
                'tgl_simpan' => $request->sim_tgl,
                'jenis_simpanan' => $request->sim_jenis,
                'status_simpanan' => 'Open',
            ]);

            return [
                'message' => 'Input Simpanan Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Input Simpanan Gagal .',
                'success' => false,
            ];
        }
    }

    public function list_sim(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $Datas = DB::table('tb_simpanan')
            ->select(
                'nama',
                DB::raw('sum(jml_simpanan)as jml_simpanan'),
                'jenis_simpanan'
            )
            ->where('status_simpanan', '=', 'Open')
            ->where(function ($q) use ($search) {
                $q
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('jenis_simpanan', 'like', '%' . $search . '%');
            })
            ->groupBy('nama', 'jenis_simpanan')
            //->orderBy('no_pinjaman', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_simpanan')
            ->select(
                'nama',
                DB::raw('sum(jml_simpanan)as jml_simpanan'),
                'jenis_simpanan'
            )
            ->where('status_simpanan', '=', 'Open')
            ->where(function ($q) use ($search) {
                $q
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('jenis_simpanan', 'like', '%' . $search . '%');
            })
            //->groupBy('nama', 'jenis_simpanan')
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function selectRow(Request $request)
    {
        // dd($request->all());
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $simPeriodeAwal = $request->simPeriode . '-01';
        $simPeriodeAkhirBulan = Carbon::parse($simPeriodeAwal)
            ->endOfMonth()
            ->toDateString();
        $simNull = $request->simNull;
        $simJenis = $request->simJenis;
        // dd($simPeriodeAkhirBulan);

        $Datas = DB::table('tb_anggota as a')
            ->select(
                'a.no_barcode',
                'a.nama',
                'b.jenis_simpanan',
                'b.jml_simpanan'
            )
            ->leftJoin('tb_simpanan as b', function ($join) use (
                $simPeriodeAwal,
                $simPeriodeAkhirBulan,
                $simJenis
            ) {
                $join
                    ->on('a.no_barcode', '=', 'b.no_anggota')
                    ->where('jenis_simpanan', $simJenis)
                    ->whereBetween('b.tgl_simpan', [
                        $simPeriodeAwal,
                        $simPeriodeAkhirBulan,
                    ]);
            })
            ->where('a.status', '=', 'Aktif')
            ->when(
                $simNull == 0,
                function ($query) {
                    // Jika nullable == 0, tampilkan data yang tidak ada pada tb_cuti_hak
                    return $query->whereNull('b.no_anggota');
                },
                function ($query) use ($search) {
                    // Jika nullable == 1, tampilkan data yang sudah ada pada tb_cuti_hak
                    return $query->where(function ($q) use ($search) {
                        $q
                            ->orWhereNotNull('b.no_anggota')
                            ->orWhere(
                                'b.no_anggota',
                                'like',
                                '%' . $search . '%'
                            );
                    });
                }
            )
            ->skip($start)
            ->take($length)
            ->get();
        // dd($Datas);

        $count = DB::table('tb_anggota as a')
            ->select(
                'a.no_barcode',
                'a.nama',
                'b.jenis_simpanan',
                'b.jml_simpanan'
            )
            ->leftJoin('tb_simpanan as b', function ($join) use (
                $simPeriodeAwal,
                $simPeriodeAkhirBulan,
                $simJenis
            ) {
                $join
                    ->on('a.no_barcode', '=', 'b.no_anggota')
                    ->where('jenis_simpanan', $simJenis)
                    ->whereBetween('b.tgl_simpan', [
                        $simPeriodeAwal,
                        $simPeriodeAkhirBulan,
                    ]);
            })
            ->where('a.status', '=', 'Aktif')
            ->when(
                $simNull == 0,
                function ($query) {
                    // Jika nullable == 0, tampilkan data yang tidak ada pada tb_cuti_hak
                    return $query->whereNull('b.no_anggota');
                },
                function ($query) use ($search) {
                    // Jika nullable == 1, tampilkan data yang sudah ada pada tb_cuti_hak
                    return $query->where(function ($q) use ($search) {
                        $q
                            ->orWhereNotNull('b.no_anggota')
                            ->orWhere(
                                'b.no_anggota',
                                'like',
                                '%' . $search . '%'
                            );
                    });
                }
            )
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function sendSelected(Request $request)
    {
        // dd($request->all());
        $simPeriode = $request->simPeriode . '-01';
        $simJml = $request->simJml;
        $simJenis = $request->simJenis;
        $countNoAnggota = $request->selectedNoAnggota;

        if ($request->role == 'Administrator') {
            if (!empty($countNoAnggota)) {
                $coun = count($countNoAnggota);
                foreach ($countNoAnggota as $noAnggota) {
                    // Memeriksa apakah data sudah ada di tabel
                    $existingData = SimpananModel::where(
                        'no_anggota',
                        $noAnggota
                    )
                        ->where('tgl_simpan', $simPeriode)
                        ->where('jenis_simpanan', $simJenis)
                        ->first();

                    if (!$existingData) {
                        for ($i = 0; $i < $coun; $i++) {
                            $namaAnggota = DB::table('tb_anggota')
                                ->select('nama')
                                ->where(
                                    'no_barcode',
                                    $request->selectedNoAnggota[$i]
                                )
                                ->first();

                            $ins_sim = SimpananModel::create([
                                'id_simpanan' => str::uuid(),
                                'no_anggota' => $request->selectedNoAnggota[$i],
                                'nama' => $namaAnggota->nama,
                                'jml_simpanan' => $simJml,
                                'tgl_simpan' => $simPeriode,
                                'jenis_simpanan' => $simJenis,
                                'status_simpanan' => 'Open',
                            ]);
                        }
                        return [
                            'message' => 'Input Simpanan Berhasil .',
                            'success' => true,
                        ];
                    } else {
                        return [
                            'message' => 'Input Simpanan Gagal .',
                            'success' => false,
                        ];
                    }
                }
            }
        } else {
            return [
                'message' => 'Akses ditolak .',
                'success' => false,
            ];
        }
    }
}

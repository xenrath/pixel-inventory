<?php

namespace App\Http\Controllers\Admin;


use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $laporans = Laporan::query();

        if ($status) {
            $laporans->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $laporans->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $laporans->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $laporans->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            $laporans->whereDate('tanggal_awal', Carbon::today());
        }

        $laporans->orderBy('id', 'DESC');
        $laporans = $laporans->get();

        return view('admin.laporan.index', compact('laporans'));
    }

    public function create()
    {

        return view('admin/laporan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
            ],
            [
                'keterangan.required' => 'masukkan laporan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');

        $barangs = Laporan::create([
            'user_id' => auth()->user()->id,
            'kode_laporan' => $kode,
            'keterangan' => $request->keterangan,
            'tanggal_awal' => $tanggal,
        ]);

        return redirect('admin/laporan')->with('success', 'Berhasil menambahkan laporan');
    }


    public function edit($id)
    {
        $laporan = Laporan::where('id', $id)->first();
        return view('admin/laporan.update', compact('laporan'));
    }

    public function show($id)
    {

        $laporan = Laporan::where('id', $id)->first();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
            ],
            [
                'keterangan.required' => 'Masukkan laporan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $laporan = Laporan::findOrFail($id);

        $laporan->keterangan = $request->keterangan;

        $laporan->save();

        return redirect('admin/laporan')->with('success', 'Berhasil memperbarui laporan');
    }

    public function kode()
    {
        $item = Laporan::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Laporan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }
        $tahun = date('y');
        $data = 'AL';
        $tanggal = date('dm');
        $kode_item = $data . "/" . $tanggal . $tahun . "/" . $num;

        return $kode_item;
    }

    public function destroy($id)
    {
        $laporan = Laporan::find($id);
        $laporan->delete();

        return redirect('admin/laporan')->with('success', 'Berhasil menghapus laporan');
    }
}
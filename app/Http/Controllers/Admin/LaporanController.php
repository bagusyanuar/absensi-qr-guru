<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\AbsenDetail;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function laporan_absen()
    {
        return view('admin.laporan.index');
    }

    public function laporan_absen_data()
    {
        try {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = AbsenDetail::with(['absen', 'user.guru'])
                ->whereHas('absen', function ($query) use ($tgl1, $tgl2) {
                    return $query->whereBetween('tanggal', [$tgl1, $tgl2]);
                })
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_absen_cetak()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = AbsenDetail::with(['absen', 'user.guru'])
            ->whereHas('absen', function ($query) use ($tgl1, $tgl2) {
                return $query->whereBetween('tanggal', [$tgl1, $tgl2]);
            })
            ->get();
        return $this->convertToPdf('admin.laporan.cetak', [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'data' => $data
        ]);
    }
}

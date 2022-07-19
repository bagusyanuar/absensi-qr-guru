<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Absen;
use App\Models\AbsenDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            if ($this->request->method() === 'POST') {
                $code = $this->postField('code');
                $type = $this->postField('tipe');
                $absen = Absen::where('code', '=', $code)
                    ->first();
                if (!$absen) {
                    return $this->jsonResponse('kode absen tidak ditemukan!', 202);
                }
                $is_exists = AbsenDetail::with('absen')
                    ->whereHas('absen', function ($query) use ($code) {
                        return $query->where('code', '=', $code);
                    })
                    ->where('user_id', '=', Auth::id())
                    ->where('tipe', '=', 'pulang')
                    ->first();
                if ($type === 'masuk' || $type === 'istirahat') {
                    if ($is_exists) {
                        return $this->jsonResponse('tidak bisa absen. anda sudah melakukan absensi pulang', 202);
                    }
                }

                if ($type === 'pulang' && $is_exists) {
                    return $this->jsonResponse('anda sudah melakukan absensi pulang', 202);
                }

                $keterangan = $this->postField('keterangan');
                switch ($type) {
                    case 'masuk':
                        $keterangan = 'Absen Masuk';
                        break;
                    case 'pulang':
                        $keterangan = 'Absen Pulang';
                        break;
                    default:
                        break;
                }
                $data_detail = [
                    'user_id' => Auth::id(),
                    'absen_id' => $absen->id,
                    'waktu' => Carbon::now('Asia/Jakarta'),
                    'keterangan' => $keterangan,
                    'tipe' => $type
                ];
                AbsenDetail::create($data_detail);
                return $this->jsonResponse('success', 200);
            }
            $data = Absen::with(['detail'])->whereHas('detail', function ($query) {
                return $query->where('user_id', '=', Auth::id());
            })
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }

    }
}

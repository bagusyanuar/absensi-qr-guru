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
                    ->first();
                if ($is_exists) {
                    if ($is_exists->pulang === null) {
                        $is_exists->update([
                            'pulang' => Carbon::now('Asia/Jakarta'),
                        ]);
                    } else {
                        return $this->jsonResponse('tidak bisa absen. anda sudah melakukan absensi pulang', 202);
                    }
                } else {
                    $data_detail = [
                        'user_id' => Auth::id(),
                        'absen_id' => $absen->id,
                        'masuk' => Carbon::now('Asia/Jakarta'),
                        'pulang' => null,
                    ];
                    AbsenDetail::create($data_detail);
                }
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

    public function data()
    {
        try {
            $data = AbsenDetail::with('absen')
                ->where('user_id', '=', Auth::id())
                ->get();
            return $this->jsonResponse('success', 200, $data);
        }catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }
}

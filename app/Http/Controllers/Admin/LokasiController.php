<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Location;

class LokasiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Location::first();
        if ($this->request->method() === 'POST') {
            try {
                $data->update([
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ]);
                return redirect()->back()->with(['success' => 'Berhasil Merubah Data...']);
            } catch (\Exception $e) {
                return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
            }
        }
        return view('admin.location.index')->with(['data' => $data]);
    }

    public function data()
    {
        try {
            $data = Location::first();
            if(!$data) {
                return $this->jsonResponse('lokasi belum di setting', 202);
            }
            return $this->jsonResponse('success', 200, $data);
        }catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan '.$e->getMessage(), 500);
        }
    }
}

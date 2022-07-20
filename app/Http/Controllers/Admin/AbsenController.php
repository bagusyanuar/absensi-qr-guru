<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Absen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AbsenController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Absen::all();
        return view('admin.absen.index')->with(['data' => $data]);

//
//        return view('login');

    }

    public function add_page()
    {
        return view('admin.absen.add');
    }

    public function create()
    {
        try {
            $code = bin2hex($this->postField('tanggal'));
            $data = [
                'tanggal' => $this->postField('tanggal'),
                'code' => $code,
            ];

            $is_exists = Absen::where('tanggal', '=', $this->postField('tanggal'))
                ->first();
            if ($is_exists) {
                return redirect()->back()->with(['failed' => 'tanggal absen sudah dibuat']);
            }
            QrCode::size(500)
                ->format('png')
                ->generate($code, public_path('assets/qr/' . $code . '.png'));
            Absen::create($data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = Absen::findOrFail($id);
        return view('admin.absen.detail')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $user = User::find($id);

            $data = [
                'username' => $this->postField('username'),
            ];

            if ($this->postField('password') !== '') {
                $data['password'] = Hash::make($this->postField('password'));
            }
            $user->update($data);
            return redirect('/admin')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            $id = $this->postField('id');
            User::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}

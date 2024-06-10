<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'sales')
            ->select('id', 'nama', 'telp', 'alamat')
            ->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required',
        ], [
            'nama.required' => 'Nama Lengkap harus diisi!',
            'telp.required' => 'Nomor Telepon harus diisi!',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        User::create([
            'username' => $request->telp,
            'password' => bcrypt('sales'),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'role' => 'sales'
        ]);

        return redirect('admin/user')->with('success', 'Berhasil menambahkan user');
    }

    public function kode()
    {
        $id = User::getId();
        foreach ($id as $value);
        $idlm = $value->id;
        $idbr = $idlm + 1;
        $num = sprintf("%06s", $idbr);
        $data = 'AA';
        $kode_user = $data . $num;

        return $kode_user;
    }

    public function show($id)
    {

        $user = User::where('id', $id)->first();
        return view('admin.user.show', compact('user'));
    }

    public function edit($id)
    {

        $user = User::where('id', $id)->first();
        return view('admin.user.update', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'nama' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'role.required' => 'Pilih jabatan',
                'username.required' => 'Masukkan username',
                'username.unique' => 'Username sudah digunakan!',
                'nama.required' => 'Masukkan nama lengkap',
                'telp.required' => 'Masukkan no telepon',
                'alamat.required' => 'Masukkan alamat',
                'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $user = User::findOrFail($id);

        if ($request->gambar) {
            Storage::disk('local')->delete('public/uploads/' . $user->gambar);
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'user/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $user->gambar;
        }

        User::where('id', $user->id)
            ->update([
                'role' => $request->role,
                'username' => $request->username,
                'nama' => $request->nama,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'gambar' => $namaGambar,
            ]);

        return redirect('admin/user')->with('success', 'Berhasil mengubah user');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('admin/user')->with('success', 'Berhasil menghapus user');
    }
}

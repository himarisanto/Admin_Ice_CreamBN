<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller
{
    function index()
    {
        $profiles = Profil::all();
        $users = User::all();
        return view('autentikasi.user.index', compact('profiles', 'users'));
    }

    function store(Request $request)
    {
        $request->validate([
            'foto_profil'   => 'file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048|nullable',
            'nama_lengkap'  => 'string',
            'job'           => 'string',
            'wa'            => 'numeric',
            'tentang'       => 'string|nullable'
        ]);


        // Periksa apakah ada data pertama dalam tabel user
        $profilUser = Profil::first();

        if ($profilUser) {
            // Inisialisasi variabel $photoProfil
            $photoProfil = $profilUser->foto_profil;
            if ($request->hasFile('foto_profil')) {
                $fotoProfil = $request->file('foto_profil');
                $name = time() . '_' . $fotoProfil->getClientOriginalName(); // Nama file unik
                $destinationPath = public_path('/profil_user');
                if ($fotoProfil->move($destinationPath, $name)) {
                    // Hapus gambar lama jika ada
                    if ($photoProfil && File::exists(public_path('profil_user/' . $photoProfil))) {
                        File::delete(public_path('profil_user/' . $photoProfil));
                    }
                    $photoProfil = $name; // atur nilai photoProfil jika gambar berhasil diunggah
                }
            }
            // Jika data sudah ada, lakukan update
            // dd($photoProfil);
            $profilUser->update([
                'foto_profil'   => $photoProfil,
                'nama_lengkap'  => $request['nama_lengkap'],
                'job'           => $request['job'],
                'wa'            => $request['wa'],
                'tentang'       => $request['tentang']
            ]);

            // Redirect atau lakukan sesuatu setelah update
            return redirect()->back()->with('message', 'Data profil user berhasil diperbarui.');
        } else {
            // Inisialisasi variabel $fotoUser
            $fotoUser = null;

            // Periksa apakah gambar diunggah
            if ($request->hasFile('foto_profil')) {
                $fotoProfil = $request->file('foto_profil');
                $name = time() . '_' . $fotoProfil->getClientOriginalName(); // Nama file unik
                $destinationPath = public_path('/profil_user');
                if ($fotoProfil->move($destinationPath, $name)) {
                    $fotoUser = $name; // atur nilai fotoUser jika gambar berhasil diunggah
                }
            }
            Profil::create([
                'foto_profil'   => $fotoUser, // Pastikan untuk menetapkan $fotoUser ke kolom 'foto_profil'
                'nama_lengkap'  => $request['nama_lengkap'],
                'job'           => $request['job'],
                'wa'            => $request['wa'],
                'tentang'       => $request['tentang']
            ]);
            return redirect()->back()->with('message', 'Data profil user berhasil di simpan.');
        }
    }

    function kirim(Request $request)
    {
        $request->validate([
            'username'  => 'string',
            'email'           => 'email|string',
        ]);
        $user = User::first();

        if ($user) {
            $user->update($request->all()); // Memperbarui data user
            return back()->with('message', 'Data user berhasil diperbarui');
        } else {
            return back()->with('error', 'User tidak ditemukan'); // Handle jika user tidak ditemukan
        }
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required',
            'newpassword' => 'required',
            'confirmpassword' => 'required|same:newpassword',
        ]);

        // Mendapatkan pengguna yang sedang diautentikasi
        $current_user = auth()->user();

        // Memeriksa apakah password saat ini sesuai dengan yang dimasukkan pengguna
        if (Hash::check($request->currentPassword, $current_user->password)) {

            // Validasi panjang password baru
            if (strlen($request->newpassword) < 8) {
                return redirect()->back()->with('warning', 'Password baru minimal 8 karakter');
            }

            // Mengupdate password pengguna
            $current_user->password = Hash::make($request->newpassword);
            $current_user->save();

            return redirect()->back()->with('message', 'Password berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Password lama salah');
        }
    }
}

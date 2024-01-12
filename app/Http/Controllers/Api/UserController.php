<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserProfileResource;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->latest()->paginate(10);

        return new UserResource(true, 'Daftar Pengguna', $users);
    }

    /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'username' => 'required|max:30',
            'email' => 'required',
            'password' => 'required|min:8',
            'nik' => 'required|numeric|min:16',
            'nama_lengkap' => 'required|max:50',
            'tanggal_lahir' => 'required',
            'village_id' => 'required',
            'alamat' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            // Required error message doesn't need to show on User, just adding required attribute on Input Field
            'username.max' => 'Username maksimal terdiri dari 30 karakter.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'nik.min' => 'NIK kurang tepat, silahkan periksa kembali.',
            'nik.numeric' => 'NIK harus berisikan angka, silahkan periksa kembali.',
            'nama_lengkap.min' => 'Nama Lengkap maksimal terdiri dari 50 karakter.',
            'alamat.max' => 'Alamat maksimal terdiri dari 200 karakter.',
            'foto.mimes' => 'Foto harus memiliki format jpeg, png, jpg, atau webp.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $foto = $request->file('foto');
        $foto->storeAs('public/profile', $foto->hashName());

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $user_profile = UserProfile::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'village_id' => $request->village_id,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'status' => $request->status,
            'foto' => $foto->hashName(),
        ]);

        return new UserProfileResource(true, 'New User successfully added !', $user_profile);
    }

    /**
     * show
     *
     * @param mixed $user
     * @return void
     */
    public function show(User $user) /* Try to solve this bug */
    {
        // $user = User::findOrFail($id)->first();
        $user_profile = UserProfile::with('user')->where('user_id', $user->id)->with('village')->first();

        return new UserProfileResource(true, 'User Detail', $user_profile);
    }

    /**
     * update
     *
     * @param mixed $user
     * @param mixed $request
     * @return void
     */
    public function update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:30',
            'email' => 'required',
            'password' => 'required|min:8',
            'role_id' => 'required',
            'nik' => 'required|numeric|min:16',
            'nama_lengkap' => 'required|max:50',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            // Required error message doesn't need to show on User, just adding required attribute on Input Field
            'username.max' => 'Username maksimal terdiri dari 30 karakter.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'nik.min' => 'NIK kurang tepat, silahkan periksa kembali.',
            'nik.numeric' => 'NIK harus berisikan angka, silahkan periksa kembali.',
            'nama_lengkap.min' => 'Nama Lengkap maksimal terdiri dari 50 karakter.',
            'alamat.max' => 'Alamat maksimal terdiri dari 200 karakter.',
            'foto.mimes' => 'Foto harus memiliki format jpeg, png, jpg, atau webp.',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // $user = User::findOrFail($id)->first();

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $user_profile = UserProfile::with('user')->where('user_id', $user->id)->first();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $foto->storeAs('public/profile', $foto->hashName());

            Storage::delete('public/profile/' . basename($user_profile->foto));

            $user_profile->update([
                'user_id' => $user->id,
                'village_id' => $request->village_id,
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tanggal_lahir' => $request->tanggal_lahir,
                'gender' => $request->gender,
                'alamat' => $request->alamat,
                'pekerjaan' => $request->pekerjaan,
                'status' => $request->status,
                'foto' => $foto->hashName(),
            ]);
        } else {
            $user_profile->update([
                'user_id' => $user->id,
                'village_id' => $request->village_id,
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tanggal_lahir' => $request->tanggal_lahir,
                'gender' => $request->gender,
                'alamat' => $request->alamat,
                'pekerjaan' => $request->pekerjaan,
                'status' => $request->status,
            ]);
        }

        return new UserResource(true, 'User update successfully !', $user_profile);
    }

    /**
     * destroy
     *
     * @param mixed $user
     * @return void
     */
    public function destroy(User $user)
    {
        // $user = User::findOrFail($id)->with('role')->first();
        $user_profile = UserProfile::with('user')->where('user_id', $user->id)->first();

        $user_profile->delete();
        $user->delete();

        return new UserResource(true, 'User has successfully deleted !', null);
    }
}

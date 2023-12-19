<?php

namespace App\Http\Controllers\Api;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserProfileResource;

class UserProfileController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $user_profiles = UserProfile::all();

        return new UserProfileResource(true, 'Daftar Profile User', $user_profiles);
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
            'user_id' => 'required',
            'nik' => 'reuired|min:21',
            'nama_lengkap' => 'required|max:50',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $foto = $request->file('foto');
        $foto->storeAs('public/profile', $foto->hashName());

        $user_profile = UserProfile::create([
            'user_id' => Auth::id(),
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'kawin' => $request->kawin,
            'foto' => $foto->hashName(),
        ]);

        return new UserProfileResource(true, 'Profile Berhasil Ditambah!', $user_profile);
    }

    /**
     * show
     *
     * @param mixed $user_profile
     * @return void
     */
    public function show(UserProfile $user_profile)
    {
        return new UserProfileResource(true, 'Profile User', $user_profile);
    }

    /**
     * update
     *
     * @param mixed $request
     * @param mixed $user_profile
     * @return void
     */
    public function update(Request $request, UserProfile $user_profile)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'nik' => 'reuired|min:21',
            'nama_lengkap' => 'required|max:50',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails())
            return response()->json($validator->errros(), 422);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $foto->storeAs('public', $foto->hashName());

            Storage::delete('public/' . basename($user_profile->foto));

            $user_profile->update([
                'user_id' => Auth::id(),
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tanggal_lahir' => $request->tanggal_lahir,
                'gender' => $request->gender,
                'alamat' => $request->alamat,
                'pekerjaan' => $request->pekerjaan,
                'kawin' => $request->kawin,
                'foto' => $foto->hashName(),
            ]);
        } else {
            $foto = $request->file('foto');
            $foto->storeAs('public', $foto->hashName());

            Storage::delete('public/' . basename($user_profile->foto));

            $user_profile->update([
                'user_id' => Auth::id(),
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tanggal_lahir' => $request->tanggal_lahir,
                'gender' => $request->gender,
                'alamat' => $request->alamat,
                'pekerjaan' => $request->pekerjaan,
                'kawin' => $request->kawin,
            ]);
        }

        return new UserProfileResource(true, 'Berhasil Memeperbarui Profil!', $user_profile);
    }

    /**
     * destroy
     *
     * @param mixed $user_profile
     * @return void
     */
    public function destroy(UserProfile $user_profile)
    {
        $user_profile->delete();

        return new UserProfileResource(true, 'Profil Berhasil Dihapus!', null);
    }
}
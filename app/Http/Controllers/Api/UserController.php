<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

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
            'username' => 'required|max:30',
            'email' => 'required',
            'password' => 'required|min:8',
            'role' => 'required',
            'nik' => 'required|min:16',
            'nama_lengkap' => 'required|max:50',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
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
            'role' => $request->role,
        ]);

        $user_profile = UserProfile::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'kawin' => $request->kawin,
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
    public function show(User $user)
    {
        $user_profile = UserProfile::with('user')->where('user_id', $user->id)->first();

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
            'role' => 'required',
            'nik' => 'required|min:16',
            'nama_lengkap' => 'required|max:50',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $user_profile = UserProfile::with('user')->where('user_id', $user->id)->first();

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
        $user_profile = UserProfile::with('user')->where('user_id', $user->id)->first();

        $user_profile->delete();
        $user->delete();

        return new UserResource(true, 'User has successfully deleted !', null);
    }
}
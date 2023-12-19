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
        $users = User::latest()->paginate(5);

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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new UserResource(true, 'New User successfully added !', $user);
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new UserResource(true, 'User update successfully !', $user);
    }

    /**
     * destroy
     *
     * @param mixed $user
     * @return void
     */
    public function destroy(User $user)
    {
        $user->delete();

        return new UserResource(true, 'User has successfully deleted !', null);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return new ServiceResource(true, 'Daftar Layanan', $services);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:30',
            'jenis' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'deskripsi' => 'required|max:255',
            'infromasi' => 'required',
            'persyaratan' => 'required',
            'kontak' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $gambar = $request->file('gambar');
        $gambar->storeAs('public/services', $gambar->hashName());

        $service = Service::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'gambar' => $request->gambar,
            'deskripsi' => $request->deskripsi,
            'informasi' => $request->informasi,
            'persyaratan' => $request->persyaratan,
            'kontak' => $request->kontak,
        ]);

        return new ServiceResource(true, 'New Service successfully added !', $service);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

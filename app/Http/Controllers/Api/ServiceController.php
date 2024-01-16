<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('type')->latest()->paginate(10);

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
            'type_id' => 'required',
            'nama' => 'required|max:30',
            'gambar' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'deskripsi' => 'required',
            'informasi' => 'required',
            'persyaratan' => 'required',
            'kontak' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $gambar = $request->file('gambar');
        $gambar->storeAs('public/service', $gambar->hashName());

        $service = Service::create([
            'type_id' => $request->type_id,
            'nama' => $request->nama,
            'gambar' => $gambar->hashName(),
            'deskripsi' => $request->deskripsi,
            'informasi' => $request->informasi,
            'persyaratan' => $request->persyaratan,
            'kontak' => $request->kontak,
        ]);

        $data = Service::with('type')->where('id', $service->id)->get();

        return new ServiceResource(true, 'New Service successfully added !', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // $data = Service::with('type')->where('id', $service->id)->get();

        return new ServiceResource(true, 'Service Detail', $service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'nama' => 'required|max:30',
            'gambar' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
            'deskripsi' => 'required',
            'informasi' => 'required',
            'persyaratan' => 'required',
            'kontak' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/service', $gambar->hashName());

            Storage::delete('public/service/' . basename($service->gambar));

            $service->update([
                'type_id' => $request->type_id,
                'nama' => $request->nama,
                'gambar' => $gambar->hashName(),
                'deskripsi' => $request->deskripsi,
                'informasi' => $request->informasi,
                'persyaratan' => $request->persyaratan,
                'kontak' => $request->kontak,
            ]);
        } else {
            $service->update([
                'type_id' => $request->type_id,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'informasi' => $request->informasi,
                'persyaratan' => $request->persyaratan,
                'kontak' => $request->kontak,
            ]);
        }

        // $data = Service::with('type')->where('id', $service->id)->get();

        return new ServiceResource(true, 'Update Service Successfully!', $service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return new ServiceResource(true, 'Service has been deleted!', null);
    }
}

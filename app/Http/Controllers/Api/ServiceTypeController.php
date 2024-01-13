<?php

namespace App\Http\Controllers\Api;

use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ServiceType::latest()->paginate(10);

        return new ServiceResource(true, 'Daftar Jenis Layanan!', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $logo = $request->file('logo');
        $logo->storeAs('public/service', $logo->hashName());

        $data = ServiceType::create([
            'nama' => $request->nama,
            'logo' => $logo->hashName(),
        ]);

        return new ServiceResource(true, 'Berhasil Menambahkan Jenis Layanan!', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceType $service_type)
    {
        return new ServiceResource(true, 'Detail Jenis Layanan', $service_type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceType $service_type)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo->storeAs('public/service', $logo->hashName());

            Storage::delete('public/service/' . basename($service_type->logo));

            $service_type->update([
                'nama' => $request->nama,
                'logo' => $logo->hashName(),
            ]);
        } else {
            $service_type->update([
                'nama' => $request->nama,
            ]);
        }

        return new ServiceResource(true, 'Berhasil Menambahkan Jenis Layanan!', $service_type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceType $service_type)
    {
        $service_type->delete();

        return new ServiceResource(true, 'Berhasil Menghapus Jenis Layanan!', null);
    }
}

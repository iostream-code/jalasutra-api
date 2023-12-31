<?php

namespace App\Http\Controllers\Api;

use App\Models\Mail;
use App\Models\UserMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MailResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mails = Mail::latest()->paginate(10);

        return new MailResource(true, 'Daftar Surat!', $mails);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blanko' => 'file|mimes:pdf|max:10485760',
            'nama' => 'required|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $blanko = $request->file('blanko');
        $blanko->storeAs('public/mail/blanko', $blanko->hashName());

        $mail = Mail::create([
            'service_id' => $request->service_id,
            'blanko' => $blanko->hashName(),
            'nama' => $request->nama,
        ]);

        return new MailResource(true, 'Berhasil Menyimpan Surat!', $mail);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mail $mail)
    {
        return new MailResource(true, 'Detail Surat!', $mail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateForAdmin(Request $request, Mail $mail)
    {
        $validator = Validator::make($request->all(), [
            'blanko' => 'required|file|mimes:pdf|max:10485760',
            'nama' => 'required|max:30',
            'nomor' => 'max:20',
            'tanda_tangan' => 'image|mimes:png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tanda_tangan = $request->file('tanda_tangan');
        $tanda_tangan->storeAs('public/mail/tanda_tangan', $tanda_tangan->hashName());

        if ($request->hasFile('blanko')) {

            $blanko = $request->file('blanko');
            $blanko->storeAs('public/mail/blanko', $blanko->hashName());

            Storage::delete('public/mail/blanko/' . basename($mail->gambar));

            $mail->update([
                'service_id' => $request->service_id,
                'nama' => $request->nama,
                'blanko' => $blanko->hashName(),
            ]);

            $mail_detail = UserMail::create([
                'mail_id' => $mail->id,
                'nomor' => $request->nomor,
                'status' => $request->status,
                'tanda_tangan' => $tanda_tangan->hashName(),
            ]);
        } else {
            $mail->update([
                'service_id' => $request->service_id,
                'nama' => $request->nama,
                'nomor' => $request->nomor,
                'status' => $request->status,
                'tanda_tangan' => $tanda_tangan->hashName(),
            ]);

            $mail_detail = UserMail::create([
                'mail_id' => $mail->id,
                'nomor' => $request->nomor,
                'status' => $request->status,
                'tanda_tangan' => $tanda_tangan->hashName(),
            ]);
        }

        return new MailResource(true, 'Berhasil Menyimpan Perubahan Surat!', $mail_detail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateForUser(Request $request, Mail $mail)
    {
        $validator = Validator::make($request->all(), [
            'blanko' => 'required|file|mimes:pdf|max:10485760',
            'nama' => 'required|max:30',
            'nomor' => 'max:30',
            'tanda_tangan' => 'image|mimes:png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mail_detail = UserMail::with('mail', 'user')->where('mail_id', $mail->id)->first();

        $mail_detail->update([
            'user_id' => $request->user_id,
            'isi' => $request->isi,
        ]);

        return new MailResource(true, 'Berhasil Menyimpan Perubahan Surat!', $mail_detail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mail $mail)
    {
        //
    }
}

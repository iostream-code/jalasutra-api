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
     * Display a listing of the resource.
     */
    public function indexMailSubmission()
    {
        $mails = UserMail::latest()->paginate(10);

        return new MailResource(true, 'Daftar Surat Masuk!', $mails);
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
     * Store UserMail a newly created resource in storage.
     */
    public function storeUserMail(Request $request, Mail $mail)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'mail_id' => 'required',
            'isi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mail_detail = UserMail::create([
            // 'user_id' => Auth()->id,
            'user_id' => $request->user_id,
            'mail_id' => $mail->id,
            'isi' => $request->isi,
        ]);

        return new MailResource(true, 'Berhasil Menyimpan Surat!', $mail_detail);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mail $mail)
    {
        return new MailResource(true, 'Detail Surat!', $mail);
    }

    /**
     * Update UserMail the specified resource in storage.
     */
    public function approval(Request $request, Mail $mail)
    {
        $validator = Validator::make($request->all(), [
            'nomor' => 'max:20',
            'tanda_tangan' => 'image|mimes:png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tanda_tangan = $request->file('tanda_tangan');
        $tanda_tangan->storeAs('public/mail/tanda_tangan', $tanda_tangan->hashName());

        $mail_detail = UserMail::create([
            'mail_id' => $mail->id,
            'nomor' => $request->nomor,
            'status' => $request->status,
            'tanda_tangan' => $tanda_tangan->hashName(),
        ]);

        return new MailResource(true, 'Berhasil Menyimpan Perubahan Surat!', $mail_detail);
    }

    /**
     * Update Mail the specified resource in storage.
     */
    public function updateMailAdmin(Request $request, Mail $mail)
    {
        $validator = Validator::make($request->all(), [
            'blanko' => 'file|mimes:pdf|max:10485760',
            'nama' => 'max:30',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('blanko')) {

            $blanko = $request->file('blanko');
            $blanko->storeAs('public/mail/blanko', $blanko->hashName());

            Storage::delete('public/mail/blanko/' . basename($mail->gambar));

            $mail->update([
                'service_id' => $request->service_id,
                'nama' => $request->nama,
                'blanko' => $blanko->hashName(),
            ]);
        } else {
            $mail->update([
                'service_id' => $request->service_id,
                'nama' => $request->nama,
            ]);
        }

        return new MailResource(true, 'Berhasil Menyimpan Perubahan Surat!', $mail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateMailUser(Request $request, Mail $mail)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'mail_id' => 'required',
            'isi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mail_detail = UserMail::with('mail', 'user')->where('mail_id', $mail->id)->first();

        $mail_detail->update([
            'user_id' => $request->user_id,
            'mail_id' => $mail->id,
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

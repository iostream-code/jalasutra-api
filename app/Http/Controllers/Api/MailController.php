<?php

namespace App\Http\Controllers\Api;

use App\Models\Mail;
use App\Models\UserMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MailResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    /**
     * Fungsi untuk menampilkan semua jenis surat berdasarkan layananannya pada User Admin
     */
    public function indexMailAdmin()
    {
        $mails = Mail::latest()->paginate(10);

        return new MailResource(true, 'Daftar Seluruh Surat!', $mails);
    }

    /**
     * Fungsi untuk menampilkan semua surat yang dibuat berdasarkan pembuatnya pada User Warga
     */
    public function indexMailUser()
    {
        $mails = UserMail::where('user_id', Auth::id())->latest()->paginate(10);

        return new MailResource(true, 'Daftar Seluruh Surat!', $mails);
    }

    /**
     * Fungsi untuk menampilkan semua rekap surat yang telah dibuat oleh User Warga pada User Admin
     */
    public function indexMailSubmission()
    {
        $mails = UserMail::latest()->paginate(10);

        return new MailResource(true, 'Daftar Surat Masuk!', $mails);
    }

    /**
     * Fungsi untuk membuat jenis surat baru berdasarkan layanannya pada User Admin
     */
    public function storeMailAdmin(Request $request)
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
     * Fungsi untuk membuat surat baru berdasarkan jenis suratnya pada User Warga
     */
    public function storeMailUser(Request $request, Mail $mail)
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
     * Fungsi untuk menampilkan detail surat berdasarkan jenisnya pada user Admin
     */
    public function showMailAdmin(Mail $mail)
    {
        return new MailResource(true, 'Detail Surat!', $mail);
    }

    /**
     * Fungsi untuk menampilkan rekap dari surat yang dibuat oleh User Warga berdasarkan jenisnya pada User Admin
     */
    public function recapMailAdmin(Mail $mail)
    {
        $mails = UserMail::where('mail_id', $mail->id)->latest()->paginate(10);

        return new MailResource(true, 'Rekap Surat!', $mails);
    }

    /**
     * Fungsi untuk menampilkan detail surat yang dibuat pada User Warga
     */
    public function showMailUser(Mail $mail)
    {
        $mail_detail = UserMail::where('id', $mail->id)->first();

        return new MailResource(true, 'Detail Surat!', $mail_detail);
    }

    /**
     * Fungsi untuk melakukan persetujuan detail surat yang disubmit oleh User Warga pada User Admin
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
     * Fungsi untuk merubah detail jenis surat pada User Admin
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
     * Fungsi untuk merubah detail surat yang dibuat pada User Warga
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

        $mail_detail = UserMail::where('mail_id', $mail->id)
            ->where('user_id', $request->user_id)
            ->first();

        $mail_detail->update([
            'user_id' => $request->user_id,
            'mail_id' => $mail->id,
            'isi' => $request->isi,
        ]);

        return new MailResource(true, 'Berhasil Menyimpan Perubahan Surat!', $mail_detail);
    }

    /**
     * Fungsi untuk mengahpus jenis surat pada User Admin
     */
    public function deleteMailAdmin(Mail $mail)
    {
        $mail->delete();

        return new MailResource(true, 'Berhasil Dihapus!', null);
    }

    /**
     * Fungsi untuk mengahpus surat yang dibuat pada User Warga
     */
    public function deleteMailUser(UserMail $mail)
    {
        $mail->delete();

        return new MailResource(true, 'Berhasil Dihapus!', null);
    }
}

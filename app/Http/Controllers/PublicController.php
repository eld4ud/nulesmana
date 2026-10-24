<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use App\Models\Member;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class PublicController extends Controller
{
    public function index()
    {
        $publishedNews = Schema::hasTable('news')
            ? News::latest()->get()
            : collect();

        $ipnuCount = Schema::hasTable('members')
            ? Member::where('banom', 'IPNU')
                ->where('status', 'approved')
                ->count()
            : 0;

        $ippnuCount = Schema::hasTable('members')
            ? Member::where('banom', 'IPPNU')
                ->where('status', 'approved')
                ->count()
            : 0;

        $ansorCount = Schema::hasTable('members')
            ? Member::where('banom', 'Ansor')
                ->where('status', 'approved')
                ->count()
            : 0;

        $fatayatCount = Schema::hasTable('members')
            ? Member::where('banom', 'Fatayat')
                ->where('status', 'approved')
                ->count()
            : 0;

        return view('welcome', compact(
            'publishedNews',
            'ipnuCount',
            'ippnuCount',
            'ansorCount',
            'fatayatCount'
        ));
    }

    public function registerMember(Request $request)
    {
        // Validasi semua data pendaftaran.
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'gender' => [
                'required',
                'in:Laki-laki,Perempuan',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'address' => [
                'required',
                'string',
                'max:2000',
            ],

            'banom' => [
                'required',
                'in:IPNU,IPPNU,Ansor,Banser,Fatayat,Muslimat,NU',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],

            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        // Simpan foto ke storage/app/public/members.
        $photoPath = $request->file('photo')
            ->store('members', 'public');

        // Batalkan penyimpanan file jika gagal.
        if (! $photoPath) {
            return back()
                ->withInput($request->except([
                    'password',
                    'password_confirmation',
                    'photo',
                ]))
                ->withErrors([
                    'photo' => 'Foto gagal disimpan. Silakan coba lagi.',
                ]);
        }

        try {
            DB::transaction(function () use ($validated, $photoPath) {

                // Buat akun anggota dengan status pending.
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'member',
                    'status' => 'pending',
                ]);

                // Simpan data anggota dan foto.
                Member::create([
                    'user_id' => $user->id,
                    'name' => $validated['name'],
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'banom' => $validated['banom'],
                    'status' => 'pending',
                    'photo' => $photoPath,
                ]);

            });

        } catch (\Throwable $e) {

            // Jangan menyisakan file jika database gagal.
            Storage::disk('public')->delete($photoPath);

            throw $e;
        }

        return redirect()
            ->route('member.login')
            ->with(
                'success',
                'Pendaftaran berhasil! Tunggu verifikasi pengurus sebelum masuk ke akun.'
            );
    }

    public function sendFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            $adminEmail = env(
                'MAIL_FROM_ADDRESS',
                'admin@nupasiramanlor.or.id'
            );

            Mail::to($adminEmail)->send(
                new FeedbackMail(
                    $request->name,
                    $request->email,
                    $request->message
                )
            );

            return back()->with(
                'success',
                'Saran berhasil terkirim ke email pengurus!'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal mengirim saran.'
            );
        }
    }

    public function news()
    {
        $newsList = News::latest()->paginate(11);

        return view('news.index', compact('newsList'));
    }

    public function showNews($id)
    {
        $news = News::findOrFail($id);

        return view('news.show', compact('news'));
    }
}

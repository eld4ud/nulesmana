<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\News;
use App\Models\User;
use App\Models\InfaqTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $pendingMembers = Schema::hasTable('members')
            ? Member::query()
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get()
            : collect();

        $totalApprovedMembers = Schema::hasTable('members')
            ? Member::query()
                ->where('status', 'approved')
                ->count()
            : 0;

        $totalNews = Schema::hasTable('news')
            ? News::query()->count()
            : 0;

        $totalInfaq = 0;

        if (Schema::hasTable('infaq_transactions')) {
            $infaqMasuk = InfaqTransaction::query()
                ->where('type', 'masuk')
                ->sum('amount');

            $infaqKeluar = InfaqTransaction::query()
                ->where('type', 'keluar')
                ->sum('amount');

            $totalInfaq = $infaqMasuk - $infaqKeluar;
        }

        return view('admin.dashboard', compact(
            'pendingMembers',
            'totalApprovedMembers',
            'totalNews',
            'totalInfaq'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function membersIndex()
    {
        $pendingMembers = Schema::hasTable('members')
            ? Member::query()
                ->where('status', 'pending')
                ->latest()
                ->get()
            : collect();

        $approvedMembers = Schema::hasTable('members')
            ? Member::query()
                ->where('status', 'approved')
                ->latest()
                ->get()
            : collect();

        return view('admin.members', compact(
            'pendingMembers',
            'approvedMembers'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CEK KEUNIKAN NIA
    |--------------------------------------------------------------------------
    |
    | Satu NIA boleh berada pada:
    | - users.nia milik akun yang sama
    | - members.nia milik anggota yang sama
    |
    | Tetapi tidak boleh dimiliki orang lain.
    |
    */

    private function niaDipakaiOrangLain(
        string $nia,
        User $user,
        Member $member
    ): bool {
        $dipakaiUserLain = User::query()
            ->where('nia', $nia)
            ->where('id', '!=', $user->id)
            ->exists();

        $dipakaiMemberLain = Member::query()
            ->where('nia', $nia)
            ->where('id', '!=', $member->id)
            ->exists();

        return $dipakaiUserLain || $dipakaiMemberLain;
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATOR NIA BARU
    |--------------------------------------------------------------------------
    |
    | Contoh:
    | LSM-26-000001
    | LSM-26-000002
    |
    | Nomor menggunakan ID anggota yang unik.
    | NIA dibuat satu kali saat ACC.
    | NIA lama yang valid tidak diganti.
    |
    */

    private function generateUniqueNia(
        User $user,
        Member $member
    ): string {
        $year = now()->format('y');

        // ID anggota adalah dasar nomor urut.
        $base = sprintf(
            'LSM-%s-%06d',
            $year,
            $member->id
        );

        // Periksa calon NIA pertama.
        if (! $this->niaDipakaiOrangLain(
            $base,
            $user,
            $member
        )) {
            return $base;
        }

        // Cadangan untuk menghindari konflik
        // dengan NIA lama yang kebetulan sama.
        for ($number = 1; $number <= 100; $number++) {
            $candidate = $base . '-' . $number;

            if (! $this->niaDipakaiOrangLain(
                $candidate,
                $user,
                $member
            )) {
                return $candidate;
            }
        }

        throw ValidationException::withMessages([
            'nia' => 'Tidak bisa membuat NIA unik. Hubungi pengelola sistem.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ACC ANGGOTA
    |--------------------------------------------------------------------------
    |
    | Alur:
    | 1. Cari anggota yang menunggu ACC.
    | 2. Pastikan terhubung akun member yang valid.
    | 3. Pastikan akun bukan milik anggota lain.
    | 4. Periksa NIA lama.
    | 5. Buat NIA baru jika belum ada / bentrok.
    | 6. Simpan pada users dan members bersamaan.
    |
    */

    public function approveMember($id)
    {
        DB::transaction(function () use ($id) {

            $member = Member::query()
                ->lockForUpdate()
                ->findOrFail($id);

            // Jangan menerbitkan NIA ulang pada anggota
            // yang sudah disetujui.
            if ($member->status === 'approved') {
                throw ValidationException::withMessages([
                    'member' => 'Anggota ini sudah disetujui sebelumnya.',
                ]);
            }

            if ($member->status !== 'pending') {
                throw ValidationException::withMessages([
                    'member' => 'Hanya anggota berstatus pending yang dapat di-ACC.',
                ]);
            }

            /*
             * Cari akun yang memang terhubung
             * melalui members.user_id.
             */
            $user = $member->user_id
                ? User::query()
                    ->lockForUpdate()
                    ->find($member->user_id)
                : null;

            /*
             * Jangan otomatis menghubungkan akun
             * berdasarkan nama yang kebetulan sama.
             */
            if (! $user || $user->role !== 'member') {
                throw ValidationException::withMessages([
                    'member' => 'Pendaftar belum memiliki akun login anggota yang valid. Hubungkan data dengan akun yang benar sebelum ACC.',
                ]);
            }

            /*
             * Cegah satu akun dipakai oleh
             * beberapa data anggota.
             */
            $otherMemberExists = Member::query()
                ->where('user_id', $user->id)
                ->where('id', '!=', $member->id)
                ->exists();

            if ($otherMemberExists) {
                throw ValidationException::withMessages([
                    'member' => 'Akun login ini terhubung ke lebih dari satu data anggota. Periksa data ganda terlebih dahulu.',
                ]);
            }

            if ($user->status === 'rejected') {
                throw ValidationException::withMessages([
                    'member' => 'Akun anggota berstatus ditolak. Periksa status akun sebelum ACC.',
                ]);
            }

            /*
             * Ambil NIA lama jika ada.
             */
            $userNia = trim((string) $user->nia);
            $memberNia = trim((string) $member->nia);

            /*
             * Jika NIA di users dan members berbeda,
             * jangan pilih sembarangan.
             */
            if (
                $userNia !== ''
                && $memberNia !== ''
                && $userNia !== $memberNia
            ) {
                throw ValidationException::withMessages([
                    'nia' => 'NIA pada akun dan data anggota berbeda. Periksa identitas sebelum menyetujui.',
                ]);
            }

            $nia = $userNia ?: $memberNia;

            /*
             * Kalau belum ada NIA, buat baru.
             *
             * Kalau NIA lama bentrok dengan orang lain,
             * buat NIA unik untuk pendaftar yang masih
             * pending tanpa mengubah NIA orang lain.
             */
            if (
                $nia === ''
                || $this->niaDipakaiOrangLain(
                    $nia,
                    $user,
                    $member
                )
            ) {
                if ($user->status === 'approved') {
                    throw ValidationException::withMessages([
                        'nia' => 'NIA akun yang sudah aktif mengalami konflik. Periksa secara manual sebelum mengubahnya.',
                    ]);
                }

                $nia = $this->generateUniqueNia(
                    $user,
                    $member
                );
            }

            /*
             * Simpan status dan NIA dalam satu transaksi.
             */
            $user->update([
                'status' => 'approved',
                'nia' => $nia,
            ]);

            $member->update([
                'status' => 'approved',
                'nia' => $nia,
            ]);
        });

        return back()->with(
            'success',
            'Anggota berhasil di-ACC! Akun aktif dan NIA sudah diterbitkan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TOLAK PENDAFTARAN
    |--------------------------------------------------------------------------
    |
    | PERBAIKAN UTAMA:
    |
    | Data lama yang user_id kosong atau akun
    | login-nya tidak ditemukan tetap boleh ditolak.
    |
    | Jangan pernah mengubah akun admin yang
    | kebetulan tercantum pada user_id.
    |
    */

    public function rejectMember($id)
    {
        $hasLinkedMemberAccount = DB::transaction(
            function () use ($id) {

                $member = Member::query()
                    ->lockForUpdate()
                    ->findOrFail($id);

                if ($member->status !== 'pending') {
                    throw ValidationException::withMessages([
                        'member' => 'Hanya pendaftaran berstatus pending yang dapat ditolak.',
                    ]);
                }

                /*
                 * Cari akun, jika masih tersedia.
                 */
                $user = $member->user_id
                    ? User::query()
                        ->lockForUpdate()
                        ->find($member->user_id)
                    : null;

                /*
                 * PENTING:
                 * Status pendaftaran ditolak tanpa
                 * mengharuskan akun login tersedia.
                 */
                $member->update([
                    'status' => 'rejected',
                ]);

                /*
                 * Kalau akun memang akun member
                 * dan tidak dipakai record anggota lain,
                 * sinkronkan status login.
                 */
                if ($user && $user->role === 'member') {

                    $dipakaiAnggotaLain = Member::query()
                        ->where('user_id', $user->id)
                        ->where('id', '!=', $member->id)
                        ->exists();

                    if (! $dipakaiAnggotaLain) {
                        $user->update([
                            'status' => 'rejected',
                        ]);

                        return true;
                    }
                }

                return false;
            }
        );

        $message = $hasLinkedMemberAccount
            ? 'Pendaftaran ditolak. Status akun anggota juga dinonaktifkan.'
            : 'Pendaftaran berhasil ditolak. Tidak ada akun login yang diubah karena hubungan akun belum valid.';

        return back()->with('success', $message);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT ANGGOTA
    |--------------------------------------------------------------------------
    |
    | Mendukung:
    | - Nama
    | - Banom
    | - Jenis kelamin
    | - Foto profil
    |
    */

    public function updateMember(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'banom' => [
                'required',
                'in:IPNU,IPPNU,Ansor,Banser,Fatayat,Muslimat,NU',
            ],

            'gender' => [
                'nullable',
                'in:Laki-laki,Perempuan',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $member = Member::findOrFail($id);

        $oldPhoto = $member->photo;
        $newPhoto = null;

        if ($request->hasFile('photo')) {
            $newPhoto = $request->file('photo')
                ->store('members', 'public');
        }

        try {

            $member->name = $validated['name'];
            $member->banom = $validated['banom'];

            if ($request->exists('gender')) {
                $member->gender =
                    $validated['gender'] ?? null;
            }

            if ($newPhoto) {
                $member->photo = $newPhoto;
            }

            $member->save();

        } catch (\Throwable $e) {

            if ($newPhoto) {
                Storage::disk('public')->delete($newPhoto);
            }

            throw $e;
        }

        /*
         * Hapus foto lama setelah perubahan
         * database berhasil.
         */
        if (
            $newPhoto
            && $oldPhoto
            && $oldPhoto !== $newPhoto
        ) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return back()->with(
            'success',
            'Data dan foto anggota berhasil diperbarui!'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS ANGGOTA
    |--------------------------------------------------------------------------
    |
    | Menghapus data anggota juga mencabut
    | status approved dari akun member terkait
    | jika akun itu tidak dipakai anggota lain.
    |
    */

    public function destroyMember($id)
    {
        $photoPath = DB::transaction(function () use ($id) {

            $member = Member::query()
                ->lockForUpdate()
                ->findOrFail($id);

            $user = $member->user_id
                ? User::query()
                    ->lockForUpdate()
                    ->find($member->user_id)
                : null;

            $otherMemberExists = $user
                ? Member::query()
                    ->where('user_id', $user->id)
                    ->where('id', '!=', $member->id)
                    ->exists()
                : false;

            /*
             * Jangan menonaktifkan akun admin.
             * Jangan menonaktifkan akun member
             * yang masih punya data anggota lain.
             */
            if (
                $user
                && $user->role === 'member'
                && ! $otherMemberExists
            ) {
                $user->update([
                    'status' => 'rejected',
                ]);
            }

            $photoPath = $member->photo;

            $member->delete();

            return $photoPath;
        });

        if ($photoPath) {
            Storage::disk('public')->delete($photoPath);
        }

        return back()->with(
            'success',
            'Data anggota berhasil dihapus. Akses akun terkait dicabut jika tidak digunakan anggota lain.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA BERITA
    |--------------------------------------------------------------------------
    */

    public function newsIndex()
    {
        $publishedNews = Schema::hasTable('news')
            ? News::latest()->get()
            : collect();

        return view(
            'admin.news',
            compact('publishedNews')
        );
    }

    public function storeNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('news', 'public');
        }

        News::create([
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'content' => $validated['content'],
            'image' => $imagePath,
        ]);

        return back()->with(
            'success',
            'Berita berhasil dipublikasikan!'
        );
    }

    public function destroyNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return back()->with(
            'success',
            'Berita berhasil dihapus.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA INFAQ DAN KAS
    |--------------------------------------------------------------------------
    */

    public function infaqIndex()
    {
        $hasTable = Schema::hasTable(
            'infaq_transactions'
        );

        $infaqTransactions = $hasTable
            ? InfaqTransaction::latest()->get()
            : collect();

        $infaqMasuk = $hasTable
            ? InfaqTransaction::query()
                ->where('type', 'masuk')
                ->sum('amount')
            : 0;

        $infaqKeluar = $hasTable
            ? InfaqTransaction::query()
                ->where('type', 'keluar')
                ->sum('amount')
            : 0;

        $totalInfaq = $infaqMasuk - $infaqKeluar;

        return view('admin.infaq', compact(
            'infaqTransactions',
            'infaqMasuk',
            'infaqKeluar',
            'totalInfaq'
        ));
    }

    public function storeInfaq(Request $request)
    {
        $validated = $request->validate([
            'amount' => [
                'required',
                'integer',
                'min:1',
            ],

            'type' => [
                'required',
                'in:masuk,keluar',
            ],

            'description' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        InfaqTransaction::create([
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'description' => $validated['description'],
        ]);

        return back()->with(
            'success',
            'Transaksi kas/infaq berhasil dicatat!'
        );
    }

    public function destroyInfaq($id)
    {
        $infaq = InfaqTransaction::findOrFail($id);
        $infaq->delete();

        return back()->with(
            'success',
            'Catatan transaksi berhasil dihapus.'
        );
    }
}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gabung Banom - NU Pasiraman Lor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex text-gray-900">

    <!-- KANAN: Visual & Illustration Banner (Sembunyi di Mobile, Tampil di Desktop) -->
    <div class="hidden lg:flex lg:w-1/2 bg-[#d5f028] p-12 flex-col justify-between relative overflow-hidden">
        <!-- Header Brand -->
        <div class="flex items-center gap-3 z-10">
            <div class="w-10 h-10 bg-green-900 rounded-full flex items-center justify-center text-white font-bold">
                <i class="ph ph-globe-hemisphere-west text-2xl"></i>
            </div>
            <span class="font-black text-2xl tracking-tight text-gray-900">NU Pasiraman Lor</span>
        </div>

        <!-- Floating Cards Illustration ala Linktree -->
        <div class="relative z-10 my-auto max-w-lg mx-auto w-full space-y-4">
            <div class="bg-white p-6 rounded-3xl shadow-xl transform -rotate-2 hover:rotate-0 transition duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-800 flex items-center justify-center font-bold text-xl">
                        🌱
                    </div>
                    <div>
                        <h4 class="font-extrabold text-lg text-gray-900">IPNU & IPPNU</h4>
                        <p class="text-xs text-gray-500">Wadah Keterampilan & Karakter Pelajar NU</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-900 text-white p-6 rounded-3xl shadow-xl transform rotate-2 hover:rotate-0 transition duration-300 ml-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center font-bold text-xl">
                        🛡️
                    </div>
                    <div>
                        <h4 class="font-extrabold text-lg">GP Ansor & Banser</h4>
                        <p class="text-xs text-green-200">Garda Depan Penjaga Ulama & NKRI</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Text -->
        <p class="text-xs font-semibold text-gray-700 z-10">
            © 2026 Ranting NU Pasiraman Lor. Merawat Tradisi, Membangun Negeri.
        </p>
    </div>

    <!-- KIRI: Form Pendaftaran ala Linktree -->
    <div class="w-full lg:w-1/2 flex flex-col justify-between p-8 sm:p-12 lg:p-20 overflow-y-auto">
        
        <!-- Top Nav -->
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-gray-500 hover:text-green-800 flex items-center gap-1">
                <i class="ph ph-arrow-left text-base"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('login') }}" class="text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-full transition">
                Login Admin
            </a>
        </div>

        <!-- Form Container -->
        <div class="max-w-md w-full mx-auto my-auto">
            
            <h1 class="text-4xl font-black tracking-tight text-gray-900 mb-2">Join Banom NU</h1>
            <p class="text-gray-500 text-sm font-medium mb-8">Daftarkan diri Anda untuk menjadi bagian dari keluarga besar Ranting NU Pasiraman Lor.</p>

            <!-- Alert Notifikasi -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 text-sm font-bold rounded-2xl flex items-center gap-2">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="/register-member" method="POST" class="space-y-4">
                @csrf
                
                <!-- Input Nama -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Masukkan nama lengkap Anda" 
                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-100 outline-none transition">
                </div>

                <!-- Select Banom -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Badan Otonom (Banom)</label>
                    <select name="banom" required 
                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-100 outline-none transition appearance-none">
                        <option value="">-- Pilih Banom --</option>
                        <option value="IPNU">IPNU (Ikatan Pelajar NU - Putra)</option>
                        <option value="IPPNU">IPPNU (Ikatan Pelajar Putri NU)</option>
                        <option value="Ansor">GP Ansor (Pemuda NU)</option>
                        <option value="Banser">Banser (Barisan Ansor Serbaguna)</option>
                        <option value="Fatayat">Fatayat NU (Pemudi NU)</option>
                        <option value="Muslimat">Muslimat NU (Ibu-Ibu NU)</option>
                    </select>
                </div>

                <!-- Input No HP -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nomor WhatsApp (Opsional)</label>
                    <input type="text" name="phone" placeholder="08xxxxxxxxxx" 
                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-semibold focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-100 outline-none transition">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full mt-4 bg-gray-900 hover:bg-green-800 text-white font-extrabold text-sm py-4 rounded-2xl shadow-xl transition transform active:scale-95">
                    Kirim Pendaftaran
                </button>
            </form>

        </div>

        <!-- Bottom Link -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 font-medium">Dengan mendaftar, data Anda akan diverifikasi oleh pengurus admin Ranting NU.</p>
        </div>

    </div>

</body>
</html>
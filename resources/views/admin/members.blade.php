<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Anggota - Admin NU Pasiraman Lor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style> 
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8faf9; } 
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* STYLE KHUSUS PRINT / CETAK KTA */
        @media print {
            body * {
                visibility: hidden;
            }
            #printableKtpCard, #printableKtpCard * {
                visibility: visible;
            }
            #printableKtpCard {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
                max-width: 600px;
                box-shadow: none !important;
                border: 1px solid #166534 !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="text-slate-700 h-screen overflow-hidden flex font-sans p-4 gap-4 font-normal">

    <aside class="w-[260px] bg-white rounded-3xl flex flex-col justify-between py-6 shadow-sm hidden md:flex">
        <div>
            <div class="px-8 flex items-center gap-3 mb-10">
                <div class="w-9 h-9 rounded-full bg-green-900 text-white flex items-center justify-center font-normal">
                    <i class="ph ph-globe-hemisphere-west text-xl"></i>
                </div>
                <div>
                    <h1 class="text-base font-extrabold tracking-tight text-gray-900 leading-none">Portal Resmi Pasiraman Lor</h1>
                    <span class="text-[10px] text-green-700 font-medium uppercase tracking-wider block mt-1">Admin Panel</span>
                </div>
            </div>

            <div class="px-4">
                <p class="px-4 text-[11px] font-medium text-gray-400 mb-3 tracking-wider">MODUL UTAMA</p>
                <nav class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-normal text-sm transition">
                        <i class="ph ph-squares-four text-lg"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-4 py-3 bg-green-50 text-green-900 rounded-2xl relative font-medium text-sm">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-7 bg-green-800 rounded-r-full"></div>
                        <i class="ph ph-users-three text-lg"></i> Kelola Anggota
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-normal text-sm transition">
                        <i class="ph ph-newspaper text-lg"></i> Kelola Berita
                    </a>
                    <a href="{{ route('admin.infaq.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-normal text-sm transition">
                        <i class="ph ph-wallet text-lg"></i> Kelola Infaq / Kas
                    </a>
                </nav>
            </div>
        </div>

        <div class="px-4">
            <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-50 text-gray-600 rounded-2xl font-normal text-xs hover:bg-gray-100 transition">
                <i class="ph ph-arrow-left text-base"></i> Kembali
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm">
        <header class="h-20 px-8 flex items-center justify-between border-b border-gray-100">
            <div>
                <h2 class="text-lg font-medium text-gray-800">Kelola Data Anggota Banom</h2>
                <p class="text-xs font-light text-gray-400">Klik kartu di bawah untuk melihat & mencetak KTA digital</p>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 no-scrollbar space-y-8">
            
            @if(session('success'))
                <div class="bg-green-900 text-white px-6 py-4 rounded-2xl font-normal text-xs shadow flex items-center justify-between">
                    <span><i class="ph ph-check-circle text-base mr-2 align-middle"></i> {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()"><i class="ph ph-x text-base"></i></button>
                </div>
            @endif

            @if(isset($pendingMembers) && count($pendingMembers) > 0)
                <div class="bg-orange-50/50 border border-orange-100 rounded-3xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-orange-950 flex items-center gap-2">
                            <i class="ph ph-clock-counter-clockwise text-lg text-orange-600"></i>
                            Antrean Membutuhkan ACC ({{ count($pendingMembers) }})
                        </h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($pendingMembers as $m)
                            <div class="bg-white p-4 rounded-2xl border border-orange-100 shadow-sm flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $m->photo ? asset('storage/'.$m->photo) : 'https://ui-avatars.com/api/?name='.urlencode($m->name).'&background=166534&color=fff' }}" 
                                         class="w-11 h-11 rounded-2xl object-cover border border-orange-100">
                                    <div>
                                        <h4 class="font-normal text-xs text-gray-900">{{ $m->name }}</h4>
                                        <span class="inline-block mt-0.5 text-[10px] font-normal text-orange-800 bg-orange-100/70 px-2.5 py-0.5 rounded-full">
                                            {{ $m->banom }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <form action="{{ route('admin.members.approve', $m->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-green-800 hover:bg-green-900 text-white text-[11px] font-normal px-3 py-1 rounded-xl transition w-full">ACC</button>
                                    </form>
                                    <form action="{{ route('admin.members.reject', $m->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-gray-50 hover:bg-red-50 hover:text-red-600 text-gray-500 text-[11px] font-normal px-3 py-1 rounded-xl transition w-full">Tolak</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-medium text-gray-800">Daftar Anggota Resmi ({{ isset($approvedMembers) ? count($approvedMembers) : 0 }})</h3>
                        <p class="text-xs font-light text-gray-400">Klik salah satu kartu untuk membuka KTA & Opsi Cetak/Edit Foto.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @forelse($approvedMembers as $m)
                        @php
                            $photoUrl = $m->photo ? asset('storage/'.$m->photo) : 'https://ui-avatars.com/api/?name='.urlencode($m->name).'&background=166534&color=fff';
                            $memberId = 'ID-' . str_pad($m->id, 4, '0', STR_PAD_LEFT);
                            $formattedDate = $m->created_at ? $m->created_at->format('d M Y') : '-';
                            $genderText = $m->gender ?? 'Laki-laki';
                        @endphp
                        
                        <div onclick="openKtpModal('{{ $m->id }}', '{{ addslashes($m->name) }}', '{{ $m->banom }}', '{{ $genderText }}', '{{ $formattedDate }}', '{{ $photoUrl }}', '{{ $memberId }}')"
                             class="bg-gray-50/70 hover:bg-white border border-gray-100 hover:border-green-200 p-5 rounded-3xl cursor-pointer hover:shadow-md transition-all duration-300 group flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <img src="{{ $photoUrl }}" alt="{{ $m->name }}" class="w-12 h-12 rounded-2xl object-cover border border-gray-100">
                                    <span class="text-xs font-normal text-gray-300 group-hover:text-green-700 transition">
                                        <i class="ph ph-identification-card text-xl"></i>
                                    </span>
                                </div>
                                <h4 class="font-medium text-gray-800 text-sm leading-snug group-hover:text-green-900 transition line-clamp-1">
                                    {{ $m->name }}
                                </h4>
                                <div class="mt-1.5">
                                    <span class="inline-block text-[10px] font-normal text-green-800 bg-green-50 px-2.5 py-0.5 rounded-full border border-green-100">
                                        {{ $m->banom }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400 font-light">
                                <span><i class="ph ph-gender-intersex align-middle mr-1"></i> {{ $genderText }}</span>
                                <span class="font-normal text-green-800">Buka KTA →</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-400 bg-gray-50/50 rounded-3xl border border-dashed border-gray-200">
                            <p class="text-xs font-medium text-gray-600">Belum Ada Anggota Resmi</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <div id="ktpModal" class="fixed inset-0 bg-black/60 z-[100] hidden flex flex-col items-center justify-center backdrop-blur-sm p-4">
        
        <div class="relative w-full max-w-xl">
            <button onclick="closeKtpModal()" class="no-print absolute -top-12 right-0 text-white/80 hover:text-white bg-white/10 hover:bg-white/20 rounded-full w-9 h-9 flex items-center justify-center transition">
                <i class="ph ph-x text-lg"></i>
            </button>

            <div id="printableKtpCard" class="bg-gradient-to-br from-green-900 via-green-850 to-green-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-green-700/60 font-sans">
                
                <div class="absolute -right-8 -bottom-8 text-white/5 text-[11rem] font-black pointer-events-none select-none">
                    <i class="ph ph-globe-hemisphere-west"></i>
                </div>

                <div class="flex items-center justify-between border-b border-white/15 pb-4 mb-6 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-lime-400 text-gray-900 flex items-center justify-center text-xl font-bold shadow-md">
                            <i class="ph ph-globe-hemisphere-west"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold tracking-widest uppercase text-lime-400 leading-tight">KARTU TANDA ANGGOTA</h3>
                            <p class="text-[11px] font-light text-white/80">Pengurus Ranting NU Pasiraman Lor</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span id="modalIdTag" class="text-xs font-mono font-medium bg-white/10 px-3 py-1 rounded-full text-white/90 border border-white/15 inline-block">
                            ID-0001
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6 items-center my-2 relative z-10">
                    <div class="col-span-4 sm:col-span-4 flex flex-col items-center">
                        <div class="relative">
                            <img id="modalPhoto" src="" alt="Pasfoto" class="w-24 h-32 sm:w-28 sm:h-36 rounded-2xl object-cover border-2 border-lime-400/80 shadow-xl bg-green-950">
                            <div class="absolute -bottom-2 -right-2 bg-lime-400 text-gray-900 w-6 h-6 rounded-full flex items-center justify-center text-xs shadow-md">
                                <i class="ph ph-check-bold"></i>
                            </div>
                        </div>
                        <span class="text-[9px] font-light text-lime-300 mt-3 uppercase tracking-wider">VERIFIED MEMBER</span>
                    </div>

                    <div class="col-span-8 sm:col-span-8 space-y-3">
                        <div>
                            <p class="text-[9px] font-light uppercase tracking-wider text-white/50">Nama Lengkap</p>
                            <h4 id="modalName" class="font-medium text-base text-white leading-tight">
                                Nama Anggota
                            </h4>
                        </div>

                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <div>
                                <p class="text-[9px] font-light uppercase tracking-wider text-white/50">Badan Otonom</p>
                                <span id="modalBanom" class="inline-block text-xs font-medium text-gray-900 bg-lime-400 px-3 py-0.5 rounded-md mt-0.5">
                                    IPNU
                                </span>
                            </div>
                            <div>
                                <p class="text-[9px] font-light uppercase tracking-wider text-white/50">Jenis Kelamin</p>
                                <p id="modalGender" class="text-xs font-normal text-white/90 mt-0.5">
                                    Laki-laki
                                </p>
                            </div>
                        </div>

                        <div class="pt-1">
                            <p class="text-[9px] font-light uppercase tracking-wider text-white/50">Tanggal Diterima</p>
                            <p id="modalJoinedAt" class="text-xs font-normal text-white/90 mt-0.5">
                                01 Jan 2026
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 mt-4 border-t border-white/15 text-[10px] text-white/60 font-light relative z-10">
                    <span>Dokumen Digital Resmi PRNU Pasiraman Lor</span>
                    <span class="text-lime-300 font-normal">Status: Aktif</span>
                </div>

            </div>

            <div class="no-print mt-4 flex flex-wrap justify-between items-center gap-3">
                <div class="flex gap-2">
                    <button onclick="window.print()" class="bg-lime-400 hover:bg-lime-300 text-gray-900 font-medium px-4 py-2.5 rounded-2xl transition text-xs flex items-center gap-2 shadow-md">
                        <i class="ph ph-printer text-base"></i> Cetak KTA (PDF)
                    </button>

                    <button onclick="openEditPhotoModal()" class="bg-white/10 hover:bg-white/20 text-white font-normal px-4 py-2.5 rounded-2xl transition text-xs flex items-center gap-2 border border-white/20">
                        <i class="ph ph-camera text-base"></i> Ganti Foto Profil
                    </button>
                </div>

                <form id="deleteMemberForm" method="POST" action="" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini dari database?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500/80 hover:bg-red-600 text-white font-normal px-4 py-2.5 rounded-2xl transition text-xs flex items-center gap-2 backdrop-blur-sm">
                        <i class="ph ph-trash text-sm"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

    </div>

    <div id="editPhotoModal" class="fixed inset-0 bg-black/70 z-[110] hidden flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-medium text-gray-800">Ganti Foto Profil Anggota</h3>
                <button onclick="closeEditPhotoModal()" class="text-gray-400 hover:text-gray-600"><i class="ph ph-x text-lg"></i></button>
            </div>

            <form id="updatePhotoForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                
                <input type="hidden" id="edit_name" name="name">
                <input type="hidden" id="edit_banom" name="banom">

                <div>
                    <label class="block text-xs font-normal text-gray-600 mb-1">Pilih Foto Baru (Maks 2MB)</label>
                    <input type="file" name="photo" accept="image/*" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2 text-xs">
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="button" onclick="closeEditPhotoModal()" class="flex-1 bg-gray-100 text-gray-700 font-normal py-2.5 rounded-xl text-xs">Batal</button>
                    <button type="submit" class="flex-1 bg-green-800 hover:bg-green-900 text-white font-normal py-2.5 rounded-xl text-xs">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentMemberId = null;
        let currentMemberName = '';
        let currentMemberBanom = '';

        function openKtpModal(id, name, banom, gender, joinedAt, photoUrl, memberId) {
            currentMemberId = id;
            currentMemberName = name;
            currentMemberBanom = banom;

            document.getElementById('modalPhoto').src = photoUrl;
            document.getElementById('modalName').innerText = name;
            document.getElementById('modalBanom').innerText = banom;
            document.getElementById('modalGender').innerText = gender;
            document.getElementById('modalJoinedAt').innerText = joinedAt;
            document.getElementById('modalIdTag').innerText = memberId;

            // Action Hapus & Update Foto
            document.getElementById('deleteMemberForm').action = "/admin/members/" + id;
            document.getElementById('updatePhotoForm').action = "/admin/members/" + id;

            // Tampilkan Modal KTP
            document.getElementById('ktpModal').classList.remove('hidden');
        }

        function closeKtpModal() {
            document.getElementById('ktpModal').classList.add('hidden');
        }

        // Sub Modal Ganti Foto
        function openEditPhotoModal() {
            document.getElementById('edit_name').value = currentMemberName;
            document.getElementById('edit_banom').value = currentMemberBanom;
            document.getElementById('editPhotoModal').classList.remove('hidden');
        }

        function closeEditPhotoModal() {
            document.getElementById('editPhotoModal').classList.add('hidden');
        }

        // Close modal saat klik latar belakang hitam
        window.onclick = function(event) {
            const ktpModal = document.getElementById('ktpModal');
            if (event.target === ktpModal) {
                closeKtpModal();
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cek Kartu Anggota | NU Lesmana</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #F5F4F0;
        }

        .heading {
            font-family: 'Bebas Neue', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen text-[#183C2F]">

    <main class="mx-auto max-w-5xl px-5 py-20">

        <a
            href="{{ route('home') }}"
            class="mb-12 inline-flex items-center gap-2
                   text-sm font-semibold hover:opacity-60"
        >
            ← Kembali ke Beranda
        </a>

        <div class="mb-12">
            <span class="text-xs font-bold uppercase tracking-[0.3em]">
                Portal Keanggotaan
            </span>

            <h1 class="heading mt-4 text-6xl leading-none sm:text-8xl">
                CEK KARTU
                <br>
                ANGGOTA.
            </h1>

            <p class="mt-5 max-w-xl text-sm leading-7 text-stone-600">
                Akses informasi keanggotaan dan kartu identitas
                digital melalui akun NU Lesmana.
            </p>
        </div>

        <section
            class="overflow-hidden rounded-3xl
                   border border-[#183C2F]/15 bg-white"
        >
            <div class="grid md:grid-cols-2">

                <div class="bg-[#183C2F] p-8 text-white sm:p-12">

                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/60">
                        NU Lesmana
                    </p>

                    <h2 class="heading mt-12 text-5xl leading-none">
                        IDENTITAS
                        <br>
                        KEANGGOTAAN.
                    </h2>

                    <p class="mt-5 text-sm leading-7 text-white/70">
                        Informasi kartu anggota hanya dapat diakses
                        melalui akun yang terhubung dengan data
                        keanggotaan.
                    </p>

                    <div class="mt-12 border-t border-white/20 pt-5">
                        <p class="text-xs uppercase tracking-widest text-white/50">
                            PRNU Lesmana
                        </p>
                    </div>

                </div>

                <div class="flex flex-col justify-center p-8 sm:p-12">

                    @auth

                        <span class="mb-4 text-xs font-bold uppercase tracking-widest">
                            Akun Terhubung
                        </span>

                        <h3 class="heading text-4xl">
                            HALO, {{ auth()->user()->name }}.
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-stone-600">
                            Kamu sudah masuk ke akun NU Lesmana.
                            Buka dashboard anggota untuk melihat
                            informasi keanggotaan yang tersedia.
                        </p>

                        @if(auth()->user()->role === 'admin')

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="mt-8 inline-flex justify-center
                                       rounded-full bg-[#183C2F]
                                       px-6 py-4 text-sm font-bold
                                       text-white transition hover:bg-[#275643]"
                            >
                                Buka Dashboard Admin →
                            </a>

                        @else

                            <a
                                href="{{ route('member.dashboard') }}"
                                class="mt-8 inline-flex justify-center
                                       rounded-full bg-[#183C2F]
                                       px-6 py-4 text-sm font-bold
                                       text-white transition hover:bg-[#275643]"
                            >
                                Buka Dashboard Anggota →
                            </a>

                        @endif

                    @else

                        <span class="mb-4 text-xs font-bold uppercase tracking-widest">
                            Akses Anggota
                        </span>

                        <h3 class="heading text-4xl">
                            MASUK UNTUK
                            <br>
                            MELANJUTKAN.
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-stone-600">
                            Silakan login menggunakan akun anggota
                            untuk mengakses informasi kartu digital.
                        </p>

                        <a
                            href="{{ route('member.login') }}"
                            class="mt-8 inline-flex justify-center
                                   rounded-full bg-[#183C2F]
                                   px-6 py-4 text-sm font-bold
                                   text-white transition hover:bg-[#275643]"
                        >
                            Login Anggota →
                        </a>

                        <a
                            href="{{ route('member.signup') }}"
                            class="mt-4 text-center text-sm font-semibold
                                   underline underline-offset-4"
                        >
                            Belum punya akun? Daftar di sini
                        </a>

                    @endauth

                </div>

            </div>
        </section>

        <p class="mt-8 text-center text-xs text-stone-500">
            © {{ date('Y') }} NU Lesmana. Portal Resmi Warga.
        </p>

    </main>

</body>
</html>

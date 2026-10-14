{{-- Simpan sebagai resources/views/components/whatsapp-channel.blade.php --}}
@props(['url' => ''])
@if(filled($url))
    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
       aria-label="Ikuti saluran WhatsApp NU Lesmana"
       class="nu-wa-float fixed bottom-5 right-5 sm:bottom-7 sm:right-7 z-[100] inline-flex items-center gap-2 rounded-full bg-[#173d30] px-4 py-3 text-white shadow-lg hover:bg-[#102c22] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#173d30]">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="currentColor" aria-hidden="true">
            <path d="M16 .9A15.1 15.1 0 0 0 2.94 23.6L.8 31.2l7.78-2.05A15.1 15.1 0 1 0 16 .9Zm0 27.45a12.28 12.28 0 0 1-6.26-1.72l-.45-.26-4.62 1.22 1.23-4.49-.3-.47a12.33 12.33 0 1 1 10.4 5.72Zm6.77-9.24c-.37-.19-2.2-1.08-2.54-1.21-.34-.12-.59-.19-.84.19-.25.37-.96 1.21-1.18 1.46-.22.25-.44.28-.81.09-.37-.19-1.57-.58-2.99-1.85-1.11-.99-1.86-2.21-2.08-2.58-.22-.37-.02-.57.17-.76.17-.16.37-.44.56-.65.19-.22.25-.37.37-.62.12-.25.06-.47-.03-.65-.09-.19-.84-2.03-1.15-2.78-.3-.73-.61-.63-.84-.64h-.72c-.25 0-.65.09-.99.47-.34.37-1.3 1.27-1.3 3.09s1.33 3.59 1.52 3.84c.19.25 2.61 3.98 6.32 5.58.88.38 1.57.61 2.11.78.89.28 1.7.24 2.34.15.71-.11 2.2-.9 2.51-1.77.31-.87.31-1.61.22-1.77-.09-.16-.34-.25-.71-.44Z"/>
        </svg>
        <span class="hidden sm:inline text-xs font-bold">Saluran NU Lesmana</span>
    </a>
    <style>
        .nu-wa-float {animation:nu-wa-appear .6s ease-out both;transition:transform .2s ease,background-color .2s ease,box-shadow .2s ease}
        .nu-wa-float:hover {transform:translateY(-4px);box-shadow:0 12px 30px rgba(0,0,0,.18)}
        @keyframes nu-wa-appear {from {opacity:0;transform:translateY(18px)}to {opacity:1;transform:translateY(0)}}
        @media (prefers-reduced-motion:reduce) {.nu-wa-float{animation:none;transition:none}}
    </style>
@endif

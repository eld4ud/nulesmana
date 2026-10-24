{{-- Komponen ini bisa dipakai pada dashboard anggota dan halaman KIA. --}}
<div class="nla-flip-widget" data-nla-flip-widget>
    <button type="button" class="nla-flip-open" data-nla-open aria-label="Perbesar dan balik kartu anggota">
        @include('member.components.kia-card', ['side' => 'front'])
        <span class="nla-flip-hint">Klik untuk memperbesar dan melihat sisi belakang ↗</span>
    </button>
    <dialog class="nla-flip-dialog" data-nla-dialog aria-label="Kartu anggota depan dan belakang">
        <div class="nla-flip-topbar">
            <strong>NU LESMANA · KARTU ANGGOTA</strong>
            <button type="button" data-nla-close aria-label="Tutup kartu">✕</button>
        </div>
        <button type="button" class="nla-flip-surface" data-nla-turn aria-label="Balik kartu">
            <div class="nla-flip-rotor" data-nla-rotor>
                <div class="nla-flip-face nla-flip-face-front">
                    @include('member.components.kia-card', ['side' => 'front'])
                </div>
                <div class="nla-flip-face nla-flip-face-back">
                    @include('member.components.kia-card', ['side' => 'back'])
                </div>
            </div>
        </button>
        <p class="nla-flip-message">Klik kartu untuk membalik antara sisi depan dan belakang.</p>
        <div class="nla-flip-actions">
            <a href="{{ route('member.cetak-kartu') }}">Cetak / PDF</a>
            <a href="{{ route('member.kia') }}">Halaman KIA</a>
            <button type="button" data-nla-close>Tutup</button>
        </div>
    </dialog>
</div>
@once
<style>
.nla-flip-widget{width:100%}.nla-flip-open{display:block;width:100%;border:0;padding:0;background:transparent;cursor:pointer;text-align:left}.nla-flip-hint{font-family:'DM Sans',Arial,sans-serif;display:block;margin-top:12px;color:#63766b;font-weight:650;font-size:12px}.nla-flip-dialog{position:fixed!important;inset:0;width:min(720px,calc(100vw - 24px));max-width:none;max-height:95vh;overflow:auto;border:0;border-radius:22px;padding:20px;background:#f5f4f0;box-shadow:0 30px 90px #0006}.nla-flip-dialog::backdrop{background:#071c14e6;backdrop-filter:blur(6px)}.nla-flip-topbar{display:flex;align-items:center;justify-content:space-between;gap:10px;color:#183c2f;font-size:12px;margin-bottom:15px;letter-spacing:.08em;font-family:'DM Sans',Arial,sans-serif}.nla-flip-topbar button{background:#e1e9e1;border:0;border-radius:50%;width:36px;height:36px;cursor:pointer}.nla-flip-surface{display:block;width:100%;max-width:620px;aspect-ratio:85.6/54;margin:auto;background:transparent;border:0;padding:0;perspective:1600px;cursor:pointer}.nla-flip-rotor{width:100%;height:100%;position:relative;transform-style:preserve-3d;transition:transform .65s cubic-bezier(.2,.7,.2,1)}.nla-flip-rotor.is-turned{transform:rotateY(180deg)}.nla-flip-face{position:absolute;inset:0;backface-visibility:hidden;-webkit-backface-visibility:hidden}.nla-flip-face-back{transform:rotateY(180deg)}.nla-flip-face>.nla-id-card{height:100%}.nla-flip-message{text-align:center;color:#687a6c;font-family:'DM Sans',Arial,sans-serif;font-size:12px;margin:15px 0}.nla-flip-actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:center}.nla-flip-actions a,.nla-flip-actions button{font-family:'DM Sans',Arial,sans-serif;background:#fff;border:1px solid #bfd0c2;border-radius:10px;padding:10px 16px;text-decoration:none;font-size:12px;font-weight:800;color:#183c2f;cursor:pointer}.nla-flip-actions a:first-child{background:#183c2f;color:white}@media(max-width:550px){.nla-flip-dialog{padding:12px}.nla-flip-topbar{font-size:10px}.nla-flip-actions a,.nla-flip-actions button{padding:8px 12px}}@media(prefers-reduced-motion:reduce){.nla-flip-rotor{transition:none}}
</style>
<script>
document.addEventListener('click', function(event){
    const widget=event.target.closest('[data-nla-flip-widget]');
    if(!widget)return;
    const dialog=widget.querySelector('[data-nla-dialog]');
    if(event.target.closest('[data-nla-open]')){dialog.showModal();return;}
    if(event.target.closest('[data-nla-close]')){dialog.close();return;}
    if(event.target.closest('[data-nla-turn]')){widget.querySelector('[data-nla-rotor]').classList.toggle('is-turned');return;}
});
</script>
@endonce

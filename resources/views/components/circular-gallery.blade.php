@props(['items' => collect(), 'heading' => 'Galeri Kegiatan'])
@php
    $galleryItems = collect($items)->filter(fn ($item) => !empty(data_get($item, 'image')))->values();
    $galleryId = 'gallery-' . \Illuminate\Support\Str::random(8);
@endphp
<section id="galeri" class="nu-gallery-section" aria-label="{{ $heading }}">
    <div class="nu-gallery-heading">
        <div><span class="nu-gallery-eyebrow">DOKUMENTASI / NU LESMANA</span><h2>{{ $heading }}</h2><p>Momen kegiatan dan kebersamaan warga Ranting NU Lesmana.</p></div>
        <div class="nu-gallery-controls"><button type="button" data-prev aria-label="Foto sebelumnya">&#8592;</button><button type="button" data-next aria-label="Foto berikutnya">&#8594;</button></div>
    </div>
    @if($galleryItems->isNotEmpty())
    <div class="nu-gallery" id="{{ $galleryId }}" tabindex="0" aria-label="Galeri yang dapat digeser">
        <div class="nu-gallery-track">
            @foreach($galleryItems as $item)
                @php
                    $path = data_get($item, 'image');
                    $src = \Illuminate\Support\Str::startsWith($path, ['http://','https://','/']) ? $path : asset('storage/'.$path);
                @endphp
                <button class="nu-gallery-card" type="button" data-index="{{ $loop->index }}" aria-label="Lihat foto {{ data_get($item, 'title', 'Dokumentasi kegiatan') }}">
                    <img src="{{ $src }}" alt="{{ data_get($item, 'title', 'Dokumentasi kegiatan') }}" loading="lazy" draggable="false">
                    <span>{{ data_get($item, 'title', 'Dokumentasi kegiatan') }}</span>
                </button>
            @endforeach
        </div>
        <p class="nu-gallery-hint">Geser, scroll, atau gunakan tombol panah untuk menjelajah.</p>
    </div>
    @else
        <div class="nu-gallery-empty">Dokumentasi kegiatan akan segera hadir.</div>
    @endif
</section>
@once
<style>
.nu-gallery-section{max-width:1200px;margin:0 auto;padding:70px 20px 84px;color:#1b241f;font-family:'DM Sans',sans-serif}
.nu-gallery-heading{display:flex;align-items:end;justify-content:space-between;gap:18px;margin-bottom:28px}
.nu-gallery-eyebrow{font-size:11px;font-weight:800;letter-spacing:.2em;color:#456254}
.nu-gallery-heading h2{font-size:clamp(2rem,5vw,4rem);line-height:1.08;font-weight:800;letter-spacing:-.045em;margin:10px 0}
.nu-gallery-heading p{font-size:14px;color:#67716b}
.nu-gallery-controls{display:flex;gap:8px}
.nu-gallery-controls button{width:42px;height:42px;border:1px solid #c9d0ca;border-radius:50%;background:#fff;color:#173d30;font-size:20px;transition:background .2s,transform .2s}
.nu-gallery-controls button:hover{background:#e6ece7;transform:translateY(-2px)}
.nu-gallery{position:relative;overflow:hidden;touch-action:pan-y;outline:none;user-select:none}
.nu-gallery-track{position:relative;height:clamp(300px,38vw,470px);perspective:1100px;overflow:hidden}
.nu-gallery-card{position:absolute;top:18px;left:50%;width:clamp(195px,29vw,330px);height:clamp(250px,33vw,390px);border:0;border-radius:20px;overflow:hidden;background:#dfe5df;box-shadow:0 12px 35px #142c1b20;cursor:pointer;transform-origin:center bottom;transition:transform .65s cubic-bezier(.2,.7,.2,1),opacity .45s;will-change:transform}
.nu-gallery-card img{width:100%;height:100%;object-fit:cover;pointer-events:none}
.nu-gallery-card span{position:absolute;bottom:0;left:0;right:0;padding:35px 16px 16px;color:#fff;text-align:left;font-size:13px;font-weight:700;background:linear-gradient(transparent,#0009)}
.nu-gallery-hint{text-align:center;color:#7b827c;font-size:12px;margin:10px 0 0}
.nu-gallery-empty{padding:70px 20px;text-align:center;border:1px dashed #c6cec7;border-radius:20px;color:#657168;background:#ffffff80}
@media(prefers-reduced-motion:reduce){.nu-gallery-card,.nu-gallery-controls button{transition:none!important}}
@media(max-width:600px){.nu-gallery-section{padding:48px 14px}.nu-gallery-heading{align-items:start}.nu-gallery-controls button{width:36px;height:36px}.nu-gallery-track{height:340px}}
</style>
@endonce
@if($galleryItems->isNotEmpty())
<script>
(function(){
 const root=document.getElementById(@json($galleryId));if(!root)return;
 const cards=[...root.querySelectorAll('.nu-gallery-card')];let active=0,startX=null;
 const reduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
 function render(){cards.forEach((card,i)=>{const d=i-active,abs=Math.abs(d);card.style.opacity=abs>3?'0':'1';card.style.pointerEvents=abs>3?'none':'auto';card.style.zIndex=String(50-abs);card.style.transform=`translateX(calc(-50% + ${d*76}%)) translateY(${abs*17}px) rotate(${d*-9}deg) scale(${Math.max(.73,1-abs*.095)})`;card.setAttribute('aria-current',String(d===0));});}
 function move(step){active=Math.max(0,Math.min(cards.length-1,active+step));render();}
 root.parentElement.querySelector('[data-prev]')?.addEventListener('click',()=>move(-1));
 root.parentElement.querySelector('[data-next]')?.addEventListener('click',()=>move(1));
 root.addEventListener('pointerdown',e=>{startX=e.clientX;});
 root.addEventListener('pointerup',e=>{if(startX===null)return;const dx=e.clientX-startX;startX=null;if(Math.abs(dx)>35)move(dx<0?1:-1);});
 root.addEventListener('keydown',e=>{if(e.key==='ArrowRight'){e.preventDefault();move(1);}if(e.key==='ArrowLeft'){e.preventDefault();move(-1);}});
 root.addEventListener('wheel',e=>{if(Math.abs(e.deltaX)>10){e.preventDefault();move(e.deltaX>0?1:-1);}}, {passive:false});
 cards.forEach((card,i)=>card.addEventListener('click',()=>{if(active!==i){active=i;render();}else{const url=card.querySelector('img')?.src;if(url)window.open(url,'_blank','noopener,noreferrer');}}));
 if(reduce)cards.forEach(c=>c.style.transition='none');render();
})();
</script>
@endif

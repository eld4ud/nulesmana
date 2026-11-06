<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Susunan pengurus Badan Otonom NU Lesmana yang diterbitkan oleh pengurus.">
    <title>Struktur Organisasi | NU Lesmana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--org-green:#183C2F;--org-green-light:#2B5944;--org-ivory:#F5F4F0;--org-text:#20382A;--org-muted:#687B6D;--org-border:#DBE2D9;--org-gold:#B69B68}
        *,*::before,*::after{box-sizing:border-box}
        body{margin:0;overflow-x:hidden;background:var(--org-ivory);color:var(--org-text);font-family:'DM Sans',sans-serif;-webkit-font-smoothing:antialiased}
        button,a{font:inherit}button{cursor:pointer}a{color:inherit;text-decoration:none}
        .org-page{padding-top:142px;padding-bottom:100px}
        .org-container{width:min(1240px,calc(100% - 48px));margin-inline:auto}
        .org-kicker{margin:0;color:#6A8772;font-size:11px;font-weight:800;letter-spacing:.18em;text-transform:uppercase}
        .org-intro{display:grid;grid-template-columns:minmax(0,1.45fr) minmax(240px,.55fr);align-items:end;gap:35px;padding-bottom:47px;border-bottom:1px solid var(--org-border)}
        .org-title{font:400 clamp(60px,9vw,124px)/.87 'Bebas Neue',Impact,sans-serif;letter-spacing:.015em;margin:16px 0 0;color:var(--org-green)}
        .org-title span{color:#83A391}
        .org-intro-side{display:flex;flex-direction:column;align-items:flex-start;gap:18px;padding-bottom:6px}
        .org-intro-side p{max-width:325px;margin:0;font-size:14px;line-height:1.85;color:var(--org-muted)}
        .org-intro-side a{font-size:12px;font-weight:800;border-bottom:1px solid #8DAB92;padding-bottom:6px}
        .org-eyebrow{font-size:11px;letter-spacing:.18em;text-transform:uppercase;font-weight:800;color:#668773}
        .org-select{display:flex;gap:9px;overflow-x:auto;scrollbar-width:thin;scrollbar-color:#B0C2B5 transparent;padding:8px 0 20px;margin-top:35px}
        .org-tab{flex-shrink:0;border:1px solid #CCD7CB;border-radius:999px;background:transparent;color:var(--org-green);padding:13px 21px;font-size:12px;font-weight:800;transition:background .2s,color .2s,border-color .2s}
        .org-tab:hover{background:#E5EDE5}.org-tab[aria-selected="true"]{background:var(--org-green);border-color:var(--org-green);color:white}
        .org-tab:focus-visible,a:focus-visible{outline:2px solid #3B7955;outline-offset:3px}
        .org-sheet{background:#FFFFFF;border:1px solid var(--org-border);border-radius:26px;padding:clamp(22px,4vw,52px);box-shadow:0 22px 65px rgba(21,47,29,.035)}
        .org-sheet[hidden]{display:none!important}
        .org-sheet-head{display:flex;align-items:end;justify-content:space-between;gap:20px;padding-bottom:29px;border-bottom:1px solid var(--org-border)}
        .org-sheet-count{display:flex;flex-direction:column;align-items:flex-end;flex-shrink:0}
        .org-sheet-count strong{font:400 54px/.9 'Bebas Neue',Impact,sans-serif;color:var(--org-green)}
        .org-sheet-count span{font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--org-muted);margin-top:8px}
        .org-sheet-title{font-size:clamp(29px,4vw,44px);line-height:1.07;font-weight:700;letter-spacing:-.055em;color:var(--org-green);margin:8px 0 8px}
        .org-sheet-sub{font-size:13px;line-height:1.75;color:var(--org-muted);margin:0}
        .org-pyramid{max-width:1120px;margin:35px auto 6px}
        .org-tier{position:relative;padding-top:13px;margin:0 auto 28px}
        .org-tier:first-child{padding-top:0}
        .org-tier:last-child{margin-bottom:0}
        .org-tier-label{display:flex;align-items:center;gap:13px;margin-bottom:20px;color:#7C9080;font-size:10px;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
        .org-tier-label:before,.org-tier-label:after{content:"";height:1px;background:var(--org-border);flex:1}
        .org-tier-label:before{flex:.16}
        .org-tier-grid{display:flex;flex-wrap:wrap;justify-content:center;gap:18px;position:relative}
        .org-tier-1 .org-tier-grid{max-width:345px;margin:auto}
        .org-tier-2 .org-tier-grid{max-width:800px;margin:auto}
        .org-tier-3 .org-tier-grid{max-width:1080px;margin:auto}
        .org-tier-1 .org-person{width:100%}
        .org-tier-2 .org-person{flex:0 1 calc((100% - 36px)/3);min-width:215px}
        .org-tier-3 .org-person{flex:0 1 calc((100% - 54px)/4);min-width:195px}
        .org-tier:not(:first-child)::before{content:"";display:block;width:2px;height:31px;background:#A9BFB0;margin:-17px auto 16px}
        .org-person{min-width:0;position:relative;background:#F9FAF7;border:1px solid #DEE6DD;border-radius:17px;padding:23px 18px 20px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:8px;transition:transform .25s ease,border-color .25s ease,box-shadow .25s ease}
        .org-person:hover{transform:translateY(-4px);border-color:#9DB9A5;box-shadow:0 13px 28px rgba(19,58,32,.09)}
        .org-tier-1 .org-person{background:var(--org-green);color:white;border-color:var(--org-green);padding:28px 22px 26px;box-shadow:0 14px 32px rgba(24,60,47,.12)}
        .org-avatar{width:90px;height:90px;display:grid;place-items:center;overflow:hidden;border-radius:50%;border:3px solid #DFE7DB;background:#D5E2D5;color:#50735B;font:400 38px 'Bebas Neue',Impact,sans-serif;flex-shrink:0}
        .org-avatar img{width:100%;height:100%;display:block;object-fit:cover;object-position:center 25%}
        .org-tier-1 .org-avatar{width:112px;height:112px;background:#E2ECE1;border-color:#9FB9A7}
        .org-role{font-size:10px;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:#728F7A;margin-top:7px}
        .org-tier-1 .org-role{color:#D2E3D4}
        .org-name{margin:0;font-size:16px;line-height:1.35;letter-spacing:-.025em;font-weight:800;overflow-wrap:anywhere;color:var(--org-green)}
        .org-tier-1 .org-name{font-size:20px;color:white}
        .org-detail{margin:0;font-size:11px;line-height:1.55;color:#718275;overflow-wrap:anywhere}
        .org-tier-1 .org-detail{color:#CCDCD0}
        .org-mark{width:26px;height:1px;background:#B7CDBA;margin-top:5px}
        .org-tier-1 .org-mark{background:#B6D3C1}
        .org-empty{padding:65px 15px;text-align:center;color:var(--org-muted)}
        .org-empty i{font-size:38px;color:#799C81}
        .org-empty h3{font-size:20px;color:var(--org-green);margin:15px 0 9px}
        .org-empty p{font-size:13px;line-height:1.7;max-width:430px;margin:auto}
        .org-foot{display:flex;flex-wrap:wrap;justify-content:space-between;gap:20px;border-top:1px solid var(--org-border);padding-top:24px;margin-top:34px;font-size:11px;line-height:1.7;color:var(--org-muted)}
        .org-foot a{font-weight:800;color:var(--org-green);border-bottom:1px solid #A6BCAE}
        @media(max-width:880px){.org-intro{grid-template-columns:1fr;gap:22px}.org-intro-side{padding-bottom:0}.org-tier-2 .org-person,.org-tier-3 .org-person{flex-basis:calc((100% - 18px)/2);min-width:0}.org-page{padding-top:128px}}
        @media(max-width:560px){.org-page{padding-top:122px;padding-bottom:55px}.org-container{width:calc(100% - 28px)}.org-intro{padding-bottom:26px}.org-title{font-size:clamp(64px,16vw,86px)}.org-select{margin-top:18px;padding-bottom:12px}.org-tab{padding:11px 16px}.org-sheet{border-radius:19px;padding:20px 15px}.org-sheet-head{align-items:start}.org-sheet-count strong{font-size:39px}.org-sheet-count span{font-size:9px;text-align:right}.org-sheet-sub{font-size:12px}.org-pyramid{margin-top:24px}.org-tier-grid{gap:12px}.org-tier-1 .org-tier-grid{max-width:100%}.org-tier-2 .org-person,.org-tier-3 .org-person{flex-basis:100%}.org-person{padding:19px 15px}.org-avatar{width:75px;height:75px}.org-tier-1 .org-avatar{width:95px;height:95px}.org-tier{margin-bottom:22px}}
        @media(prefers-reduced-motion:reduce){.org-person,.org-tab{transition:none!important}.org-person:hover{transform:none}}
    </style>
</head>
<body>
<x-site-navbar />
<main class="org-page">
    <div class="org-container">
        <header class="org-intro">
            <div>
                <p class="org-kicker">Direktori Pengurus / NU Lesmana</p>
                <h1 class="org-title">STRUKTUR <span>&</span><br>KEPENGURUSAN.</h1>
            </div>
            <div class="org-intro-side">
                <p>Kenali pengurus badan otonom melalui susunan jabatan yang tertata. Data ditampilkan sesuai informasi yang dipublikasikan pengurus.</p>
                <a href="{{ route('home') }}"><i class="ph ph-arrow-left" aria-hidden="true"></i> Kembali ke beranda</a>
            </div>
        </header>
        <nav class="org-select" role="tablist" aria-label="Pilih badan otonom">
            @foreach($banoms as $key => $banom)
                <button type="button" id="org-tab-{{ strtolower($key) }}" class="org-tab"
                    role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    aria-controls="org-panel-{{ strtolower($key) }}" tabindex="{{ $loop->first ? '0' : '-1' }}"
                    data-org-tab="{{ strtolower($key) }}">{{ $banom['label'] }}</button>
            @endforeach
        </nav>
        @foreach($banoms as $key => $banom)
            @php
                $rows = $banom['positions'];
                $levels = [
                    1 => $rows->filter(fn($p) => (int) $p->level === 1),
                    2 => $rows->filter(fn($p) => (int) $p->level === 2),
                    3 => $rows->filter(fn($p) => (int) $p->level === 3),
                ];
            @endphp
            <section id="org-panel-{{ strtolower($key) }}" data-org-panel="{{ strtolower($key) }}"
                class="org-sheet" role="tabpanel" aria-labelledby="org-tab-{{ strtolower($key) }}" @if(!$loop->first) hidden @endif>
                <div class="org-sheet-head">
                    <div>
                        <p class="org-eyebrow">Susunan Pengurus / {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }} dari 05</p>
                        <h2 class="org-sheet-title">{{ $banom['label'] }}</h2>
                        <p class="org-sheet-sub">Bagan kepengurusan dari pimpinan hingga bidang dan program.</p>
                    </div>
                    <div class="org-sheet-count"><strong>{{ $banom['count'] }}</strong><span>Anggota ACC</span></div>
                </div>
                @if($rows->count())
                    <div class="org-pyramid">
                        @foreach([1 => 'Pimpinan', 2 => 'Pengurus Inti', 3 => 'Bidang & Program'] as $level => $label)
                            @if($levels[$level]->isNotEmpty())
                                <div class="org-tier org-tier-{{ $level }}">
                                    <div class="org-tier-label">{{ $label }}</div>
                                    <div class="org-tier-grid">
                                        @foreach($levels[$level] as $person)
                                            @php $initials = mb_strtoupper(mb_substr($person->display_name, 0, 1)); @endphp
                                            <article class="org-person">
                                                <div class="org-avatar">
                                                    @if($person->photo_url)
                                                        <img src="{{ $person->photo_url }}" alt="Foto {{ $person->display_name }}" loading="lazy">
                                                    @else
                                                        <span aria-hidden="true">{{ $initials }}</span>
                                                    @endif
                                                </div>
                                                <span class="org-role">{{ $person->role }}</span>
                                                <h3 class="org-name">{{ $person->display_name }}</h3>
                                                @if($person->description)<p class="org-detail">{{ $person->description }}</p>@endif
                                                <span class="org-mark" aria-hidden="true"></span>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="org-empty">
                        <i class="ph ph-users-three" aria-hidden="true"></i>
                        <h3>Struktur belum dipublikasikan</h3>
                        <p>Pengurus belum menerbitkan susunan jabatan untuk badan otonom ini.</p>
                    </div>
                @endif
                <div class="org-foot">
                    <span>Nama dan foto pengurus mengikuti data yang diatur admin. Jumlah ACC dihitung terpisah dari jabatan.</span>
                    <a href="{{ route('home') }}">Kembali ke Nulesmana <i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
                </div>
            </section>
        @endforeach
    </div>
</main>
<script>
(function(){
    const tabs = Array.from(document.querySelectorAll('[data-org-tab]'));
    const panels = Array.from(document.querySelectorAll('[data-org-panel]'));
    function activate(key, focus){
        tabs.forEach(function(tab){
            const selected = tab.dataset.orgTab === key;
            tab.setAttribute('aria-selected', selected ? 'true' : 'false');
            tab.tabIndex = selected ? 0 : -1;
            if(selected && focus) tab.focus();
        });
        panels.forEach(function(panel){panel.hidden = panel.dataset.orgPanel !== key;});
    }
    tabs.forEach(function(tab,index){
        tab.addEventListener('click',function(){activate(tab.dataset.orgTab,false);});
        tab.addEventListener('keydown',function(event){
            if(event.key!=='ArrowLeft' && event.key!=='ArrowRight' && event.key!=='Home' && event.key!=='End')return;
            event.preventDefault();
            let next=index;
            if(event.key==='ArrowLeft')next=(index+tabs.length-1)%tabs.length;
            if(event.key==='ArrowRight')next=(index+1)%tabs.length;
            if(event.key==='Home')next=0;
            if(event.key==='End')next=tabs.length-1;
            activate(tabs[next].dataset.orgTab,true);
        });
    });
})();
</script>
</body>
</html>

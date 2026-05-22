<?php
$file = 'c:/Users/built/Herd/builtech-app/resources/views/welcome.blade.php';
$existing = file_get_contents($file);

// Fix broken asset paths throughout
$existing = str_replace('href="awards.html"', 'href="{{ route(\'awards\') }}"', $existing);
$existing = str_replace('href="services.html"', 'href="{{ route(\'services\') }}"', $existing);
$existing = str_replace('href="track-records.html"', 'href="{{ route(\'projects.index\') }}"', $existing);
$existing = str_replace('href="media.html"', 'href="{{ route(\'media\') }}"', $existing);
$existing = str_replace('href="news.html"', 'href="{{ route(\'news.index\') }}"', $existing);
$existing = str_replace('href="story.html"', 'href="{{ route(\'story\') }}"', $existing);
$existing = str_replace('href="our-people.html"', 'href="{{ route(\'our-people\') }}"', $existing);
$existing = str_replace('href="contact.html"', 'href="{{ route(\'contact\') }}"', $existing);
$existing = str_replace('src="images/', 'src="{{ asset(\'images/', $existing);
$existing = str_replace('.png"', '.png\') }}"', $existing);
$existing = str_replace('.jpg"', '.jpg\') }}"', $existing);
$existing = str_replace('.avif"', '.avif\') }}"', $existing);
// Fix double replacements
$existing = str_replace('asset(\'images/placeholder.jpg\') }}\')', "asset('images/placeholder.jpg') }}", $existing);

$header = <<<'BLADE'
@extends('layouts.app')
@section('title', 'Builtech | Engineering Excellence Since 1996')
@section('meta_description', 'Builtech Project Management - CIDB Grade G7 Engineering & Construction Excellence since 1996.')

@push('styles')
<style>
:root{--off-white:#fcfbf8;--gold:#c5a059;--gold-dark:#a68546;--navy:#1a242f;--text-light:#7f8c8d;--gray-200:#e5e9f0;--transition:all 0.4s cubic-bezier(.165,.84,.44,1);--shadow:0 20px 40px rgba(0,0,0,.06);--shadow-hover:0 30px 60px rgba(197,160,89,.15)}
.section-padding{padding:100px 5% 80px}.bg-white{background:#fff}.bg-off-white{background:#fcfbf8}.container{max-width:1300px;margin:0 auto}.text-center{text-align:center}
@media(max-width:768px){.section-padding{padding:70px 5%}}
.tagline{color:var(--gold);font-weight:700;letter-spacing:3px;text-transform:uppercase;font-size:.85rem;display:block;margin-bottom:12px}
.heading-main{font-family:'Oswald',sans-serif;font-size:clamp(2rem,5vw,3.2rem);color:var(--navy);line-height:1.2;margin:15px 0}
.heading-sub{font-family:'Oswald',sans-serif;font-size:clamp(1.8rem,4vw,2.5rem);color:var(--navy)}
.desc-text{font-size:1.05rem;color:var(--text-light);margin-bottom:20px;line-height:1.8}
.btn-primary{display:inline-block;text-decoration:none;border-radius:30px;padding:1.2rem 3rem;background:var(--gold);color:#fff;font-weight:700;transition:var(--transition);letter-spacing:1px}
.btn-primary:hover{transform:translateY(-3px);background:var(--gold-dark)}
.btn-navy{display:inline-block;text-decoration:none;border-radius:30px;padding:1.2rem 3rem;background:var(--navy);color:#fff!important;font-weight:700;transition:var(--transition);letter-spacing:1px}
.btn-navy:hover{background:var(--gold);transform:translateY(-3px)}
.btn-outline{display:inline-block;text-decoration:none;border-radius:30px;padding:1.2rem 3rem;background:transparent;border:2px solid var(--navy);color:var(--navy);font-weight:700;transition:var(--transition)}
.btn-outline:hover{background:var(--navy);color:#fff;transform:translateY(-3px)}
.link-underline{color:var(--navy);font-weight:700;text-decoration:none;border-bottom:2px solid var(--gold);padding-bottom:5px;transition:var(--transition);font-size:.9rem;letter-spacing:1px}
.link-underline:hover{color:var(--gold)}
.hero{height:100svh;min-height:600px;position:relative;display:flex;align-items:center;justify-content:center;color:#fff;overflow:hidden}
.hero-slider .slide{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transform:scale(1.12);transition:opacity 2.2s ease-in-out,transform 11s linear}
.hero-slider .slide.active{opacity:1;transform:scale(1)}
.hero-overlay{position:absolute;inset:0;background:radial-gradient(circle at center,rgba(26,36,47,.35) 0%,rgba(26,36,47,.85) 100%);z-index:2}
.hero-content{position:relative;z-index:10;text-align:center;width:90%;max-width:1000px;padding:clamp(2.5rem,5vw,4rem);background:rgba(255,255,255,.05);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-radius:20px;border:1px solid rgba(255,255,255,.2);margin:0 auto;box-shadow:0 30px 60px rgba(0,0,0,.3)}
.main-slogan{font-family:'Oswald',sans-serif;font-size:clamp(.9rem,3vw,1.4rem);color:var(--gold);letter-spacing:clamp(3px,1.5vw,9px);text-transform:uppercase;margin-bottom:1.5rem;font-weight:600;display:block}
.hero-content h1{margin:0 auto 1.6rem;width:100%}
.hero-content h1 img{max-width:100%;height:auto;display:block;margin:0 auto;filter:drop-shadow(0 4px 10px rgba(0,0,0,.3))}
.sub-slogan{font-size:clamp(.95rem,2.5vw,1.18rem);opacity:.94;max-width:780px;margin:0 auto;color:#fff;line-height:1.7}
.big-4-section{position:relative;z-index:100;margin-top:-5.5rem;padding:0 5%}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);max-width:1300px;margin:0 auto;background:#fff;box-shadow:var(--shadow);border-radius:12px;overflow:hidden}
@media(max-width:992px){.stats-grid{grid-template-columns:repeat(2,1fr)}.big-4-section{margin-top:-3rem}}
@media(max-width:576px){.stats-grid{grid-template-columns:1fr}}
.stat-item{text-align:center;padding:clamp(2rem,5vw,3.5rem) 1.6rem;border-right:1px solid rgba(0,0,0,.04);text-decoration:none;transition:var(--transition);color:inherit;background:#fff}
.stat-item:hover{background:#fcfbf8;transform:translateY(-5px);box-shadow:0 15px 35px rgba(0,0,0,.08);z-index:2;border-radius:8px}
.stat-label{color:var(--gold);text-transform:uppercase;font-size:.85rem;font-weight:700;letter-spacing:2.2px;display:block;margin-bottom:1rem}
.stat-value{font-family:'Oswald',sans-serif;font-size:clamp(2.5rem,7vw,4rem);color:var(--navy);line-height:1;background:linear-gradient(45deg,#c5a059 30%,#f4eee0 50%,#c5a059 70%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-size:200% auto;animation:shine 3s linear infinite;font-weight:600}
.stat-stars{font-size:clamp(1.8rem,4vw,2.8rem);line-height:1.2;display:inline-block;background:linear-gradient(45deg,#c5a059 30%,#f4eee0 50%,#c5a059 70%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-size:200% auto;animation:shine 3s linear infinite}
@keyframes shine{to{background-position:200% center}}
.stat-desc{color:var(--text-light);font-size:.8rem;text-transform:uppercase;font-weight:600;margin-top:.8rem;display:block;letter-spacing:.5px}
.management-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:60px;align-items:center}
.management-img{width:100%;border-radius:12px;box-shadow:var(--shadow)}
.management-badge{position:absolute;bottom:-20px;left:-20px;background:var(--gold);color:#fff;padding:clamp(20px,5vw,40px);border-radius:12px;box-shadow:0 15px 30px rgba(197,160,89,.3)}
.advantage-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:30px;margin-top:60px}
@media(max-width:768px){.advantage-grid{grid-template-columns:1fr}}
.adv-card{padding:35px 30px;border-bottom:4px solid var(--gold);background:#fff;transition:var(--transition);border-radius:8px;box-shadow:0 8px 25px rgba(0,0,0,.03)}
.adv-card:hover{background:#fcfbf8;transform:translateY(-8px);box-shadow:0 20px 40px rgba(197,160,89,.1)}
.icon-wrapper{width:65px;height:65px;background:rgba(197,160,89,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:20px;transition:var(--transition)}
.adv-card:hover .icon-wrapper,.spec-card:hover .icon-wrapper{transform:scale(1.1) rotate(5deg);background:rgba(197,160,89,.2)}
.icon-wrapper i{color:var(--gold);font-size:1.8rem}
.adv-card h4{font-family:'Oswald',sans-serif;font-size:1.4rem;margin-bottom:15px;color:var(--navy)}
.specs-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px}
.spec-card{background:#fff;padding:40px;border-radius:12px;border:1px solid rgba(0,0,0,.03);transition:var(--transition);box-shadow:0 8px 25px rgba(0,0,0,.04)}
.spec-card:hover{transform:translateY(-10px);box-shadow:0 20px 40px rgba(0,0,0,.08)}
.spec-card h3{font-family:'Oswald',sans-serif;margin-bottom:15px;font-size:1.4rem;color:var(--navy)}
.modern-horizontal-scroll{display:flex;flex-wrap:nowrap;gap:2.5rem;overflow-x:auto;padding:1rem 5% 4rem;scroll-snap-type:x mandatory;-ms-overflow-style:none;scrollbar-width:none;max-width:1400px;margin:0 auto;-webkit-overflow-scrolling:touch}
.modern-horizontal-scroll::-webkit-scrollbar{display:none}
.modern-horizontal-scroll>*{flex:0 0 auto;width:400px;max-width:85vw;scroll-snap-align:start}
.project-card{text-decoration:none;position:relative;height:480px;overflow:hidden;border-radius:16px;display:block;border:1px solid rgba(0,0,0,.05);transition:var(--transition);background:#fff;box-shadow:0 10px 30px rgba(0,0,0,.08)}
.project-card:hover{transform:translateY(-12px);box-shadow:var(--shadow-hover);border-color:rgba(197,160,89,.3)}
.project-card img{width:100%;height:100%;object-fit:cover;transition:1.1s cubic-bezier(.165,.84,.44,1)}
.project-card:hover img{transform:scale(1.1);filter:brightness(.85)}
.project-status-tag{position:absolute;top:1.2rem;right:1.2rem;color:#fff;padding:.5rem 1.2rem;font-size:.72rem;font-weight:700;border-radius:30px;backdrop-filter:blur(8px);letter-spacing:1px;z-index:3;box-shadow:0 4px 15px rgba(0,0,0,.15)}
.project-info{position:absolute;bottom:0;left:0;width:100%;padding:4rem 2rem 2rem;background:linear-gradient(transparent,rgba(26,36,47,.98));color:#fff;transition:.45s}
.swipe-hint{display:none;text-align:center;color:var(--text-light);font-size:.9rem;margin-bottom:20px;font-weight:500}
@media(max-width:768px){.swipe-hint{display:block}}
.all-records-card{background:linear-gradient(135deg,var(--navy) 0%,#2c3e50 100%)!important;color:#fff;padding:4rem 2rem;text-align:center;display:flex;flex-direction:column;justify-content:center;align-items:center;border:1px solid rgba(197,160,89,.3);border-radius:16px;text-decoration:none;box-shadow:0 15px 35px rgba(0,0,0,.15);transition:var(--transition);height:480px}
.all-records-card:hover{transform:translateY(-12px);border-color:var(--gold);box-shadow:var(--shadow-hover)}
.media-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:40px}
.media-card{background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.06);border:1px solid rgba(0,0,0,.04);display:flex;flex-direction:column;transition:var(--transition)}
.media-card:hover{transform:translateY(-10px);box-shadow:0 20px 40px rgba(0,0,0,.12)}
.media-img{width:100%;height:220px;object-fit:cover}
.media-content{padding:25px}
.awards-flex{display:flex;flex-wrap:wrap;justify-content:center;align-items:center;gap:clamp(40px,8vw,100px)}
.award-logo{text-align:center;max-width:160px;filter:grayscale(100%);opacity:.6;transition:var(--transition)}
.award-logo:hover{filter:grayscale(0%);opacity:1;transform:translateY(-5px)}
.award-logo img{height:50px;width:auto;object-fit:contain;margin:0 auto 15px;display:block}
.award-text{font-family:'Oswald',sans-serif;font-size:1rem;color:var(--navy)}
.iso-strip{background:#fff;padding:6rem 0;text-align:center;border-top:1px solid rgba(0,0,0,.03)}
.iso-container{display:grid;grid-template-columns:repeat(3,1fr);gap:2.5rem;max-width:1200px;margin:0 auto;padding:0 5%}
@media(max-width:768px){.iso-container{grid-template-columns:1fr;max-width:400px}}
.iso-card{background:#fff;padding:3.5rem 2.5rem;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.04);transition:var(--transition);border:1px solid rgba(0,0,0,.04)}
.iso-card:hover{transform:translateY(-10px);border-color:rgba(197,160,89,.5);box-shadow:0 20px 40px rgba(197,160,89,.12)}
.iso-header{font-family:'Oswald',sans-serif;font-size:1.6rem;color:var(--navy);margin-bottom:1.5rem}
.iso-img-wrapper{height:100px;display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem}
.iso-img-wrapper img{max-height:80px;object-fit:contain}
.iso-id{font-family:'Oswald',sans-serif;color:var(--gold);margin-bottom:.5rem}
.iso-desc{font-size:.8rem;font-weight:700;color:var(--navy);text-transform:uppercase;letter-spacing:.5px}
.clients-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:30px;max-width:1200px;margin:40px auto 0;align-items:center}
.client-item{font-family:'Oswald',sans-serif;font-size:1.1rem;color:var(--navy);text-transform:uppercase;font-weight:600;transition:var(--transition);padding:20px;border-radius:8px}
.client-item:hover{color:var(--gold);transform:translateY(-5px);background:#fcfbf8;box-shadow:0 8px 25px rgba(0,0,0,.05)}
.govt-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;max-width:1300px;margin:0 auto}
.govt-item{padding:20px;text-align:center;border:1px solid var(--gray-200);border-radius:10px;font-weight:600;color:var(--navy);transition:var(--transition);text-decoration:none;background:#fff;display:flex;align-items:center;justify-content:center}
.govt-item:hover{border-color:var(--gold);background:rgba(197,160,89,.05);transform:translateY(-4px);color:var(--gold-dark);box-shadow:0 12px 30px rgba(0,0,0,.06)}
.team-section{display:flex;flex-wrap:wrap;background:var(--navy)}
.team-img-bg{flex:1 1 50%;min-height:400px;background:url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1200') center/cover no-repeat}
.team-content{flex:1 1 50%;padding:clamp(4rem,8vw,8rem) clamp(2rem,6vw,6rem);display:flex;flex-direction:column;justify-content:center}
.final-cta{background:linear-gradient(135deg,var(--gold) 0%,var(--gold-dark) 100%);padding:100px 5%;text-align:center;position:relative;overflow:hidden}
.cta-bg-icon{position:absolute;top:-50px;left:-50px;font-size:300px;color:rgba(255,255,255,.08);transform:rotate(-15deg);z-index:1}
#backToTop{position:fixed;bottom:2rem;right:2rem;background:var(--gold);color:#fff;width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;opacity:0;visibility:hidden;transition:.4s;z-index:999;box-shadow:0 4px 15px rgba(0,0,0,.2);border:none;outline:none;font-size:1.2rem}
#backToTop.show{opacity:1;visibility:visible}
#backToTop:hover{background:var(--navy);transform:translateY(-3px)}
.reveal{opacity:0;transform:translateY(40px) scale(.98);transition:all .8s cubic-bezier(.25,1,.5,1)}
.reveal.active{opacity:1;transform:translate(0,0) scale(1)}
.reveal-left{transform:translateX(-50px)}.reveal-right{transform:translateX(50px)}
.delay-100{transition-delay:.1s}.delay-200{transition-delay:.2s}.delay-300{transition-delay:.3s}.delay-400{transition-delay:.4s}.delay-500{transition-delay:.5s}
.slider-progress-container{position:absolute;bottom:2rem;width:100%;display:flex;justify-content:center;gap:.8rem;z-index:20;margin:0}
.prog-bar{width:50px;height:4px;background:rgba(255,255,255,.3);border-radius:2px;overflow:hidden}
.prog-bar.active::after{content:'';display:block;height:100%;background:var(--gold);width:0;animation:fill 6s linear forwards}
@keyframes fill{to{width:100%}}
@media(max-width:480px){.hero-content{padding:2rem 1rem;width:92%}.project-card{height:420px}}
</style>
@endpush

@section('content')
<header class="hero">
    <div class="hero-slider">
        <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1920')"></div>
        <div class="slide" style="background-image:url('{{ asset('images/photo-1517089596392-fb9a9033e05b.avif') }}')"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=1920')"></div>
        <div class="slide" style="background-image:url('{{ asset('images/fogging 3.jpg') }}')"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="main-slogan reveal active">CIDB Grade 7 Certified</div>
        <h1 class="reveal active delay-100">
            <img src="{{ asset('images/webuiltolast.png') }}" alt="We Built To Last" />
        </h1>
        <p class="sub-slogan reveal active delay-200">Delivering engineering excellence and unlimited construction capacity for Malaysia's most complex industrial and commercial landmarks.</p>
        <div style="margin-top:35px" class="reveal active delay-300">
            <a href="{{ route('services') }}" class="btn-primary">OUR EXPERTISE</a>
        </div>
    </div>
    <div class="slider-progress-container" id="progContainer"></div>
</header>
BLADE;

// Strip the broken beginning (everything before the first <section or stat block)
// Find where the big-4-section starts
$sectionPos = strpos($existing, '<section class="big-4-section">');
if ($sectionPos === false) {
    // Try to find stat section
    $sectionPos = strpos($existing, 'big-4-section');
}

if ($sectionPos !== false) {
    $body = substr($existing, $sectionPos);
} else {
    // fallback: strip first partial slide divs (lines before big-4)
    $lines = explode("\n", $existing);
    $startLine = 0;
    foreach ($lines as $i => $line) {
        if (strpos($line, 'big-4-section') !== false || strpos($line, 'stat-item') !== false) {
            $startLine = $i;
            break;
        }
    }
    $body = implode("\n", array_slice($lines, $startLine));
}

// Fix remaining asset paths
$body = str_replace('src="images/', "src=\"{{ asset('images/", $body);
// Fix any remaining broken replacements carefully
$body = preg_replace('/src="https:\/\/images\.unsplash/', 'src="https://images.unsplash', $body);

// Fix links
$body = str_replace('href="awards.html"', "href=\"{{ route('awards') }}\"", $body);
$body = str_replace('href="services.html"', "href=\"{{ route('services') }}\"", $body);
$body = str_replace('href="track-records.html"', "href=\"{{ route('projects.index') }}\"", $body);
$body = str_replace('href="media.html"', "href=\"{{ route('media') }}\"", $body);
$body = str_replace('href="news.html"', "href=\"{{ route('news.index') }}\"", $body);
$body = str_replace('href="story.html"', "href=\"{{ route('story') }}\"", $body);
$body = str_replace('href="our-people.html"', "href=\"{{ route('our-people') }}\"", $body);
$body = str_replace('href="contact.html"', "href=\"{{ route('contact') }}\"", $body);

$newContent = $header . "\n" . $body;
file_put_contents($file, $newContent);
echo "Done - file written successfully.\n";
echo "New line count: " . count(file($file)) . "\n";

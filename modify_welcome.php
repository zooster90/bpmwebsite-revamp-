<?php
$content = file_get_contents('c:/Users/built/Herd/builtech-app/resources/views/welcome.blade.php');

$topTarget = '<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />

    <title>Builtech | Engineering Excellence Since 1996</title>

    <link rel="apple-touch-icon" href="images/61da7874-55a9-46d1-b71c-32ddac2a7740.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/61da7874-55a9-46d1-b71c-32ddac2a7740.png">

    <meta name="description" content="Builtech Project Management - Grade G7 Engineering & Construction Excellence since 1996.">
    <meta property="og:title" content="Builtech | Engineering Excellence Since 1996">
    <meta property="og:image" content="images/61da7874-55a9-46d1-b71c-32ddac2a7740.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="theme.css" />
    <link rel="stylesheet" href="index.css" />';

$topReplace = "@extends('layouts.app')\n@section('title', 'Builtech | Engineering Excellence Since 1996')\n@section('description', 'Builtech Project Management - Grade G7 Engineering & Construction Excellence since 1996.')\n\n@section('content')\n@push('styles')";
$content = str_replace($topTarget, $topReplace, $content);

$headTarget = '</head>

<body>

    <div id="nav-placeholder"></div>

    <main>';
$headReplace = '@endpush';
$content = str_replace($headTarget, $headReplace, $content);

$flagshipTarget = '<div class="modern-horizontal-scroll" id="flagshipProjectsWrapper"></div>';
$flagshipReplace = '<div class="modern-horizontal-scroll">
    @foreach($featuredProjects as $idx => $p)
        <a href="{{ route(\'projects.show\', $p->slug) }}" class="project-card reveal delay-100">
            <div class="project-status-tag" style="background: var(--gold)"><i class="fas fa-star" style="margin-right: 4px;"></i> FLAGSHIP</div>
            <img src="{{ $p->cover_image ?? asset(\'images/placeholder.jpg\') }}" alt="{{ $p->name }}" loading="lazy">
            <div class="project-info">
                <p style="color:#c5a059; font-size:0.7rem; letter-spacing:2px; font-weight:700; text-transform:uppercase;">{{ $p->location ?? \'PENANG, MALAYSIA\' }}</p>
                <h4 style="font-family:\'Oswald\', sans-serif; font-size:1.6rem; margin-top:5px;">{{ $p->name }}</h4>
            </div>
        </a>
    @endforeach
</div>';
$content = str_replace($flagshipTarget, $flagshipReplace, $content);

$ongoingTarget = '<div class="modern-horizontal-scroll" id="currentProjectsWrapper"></div>';
$ongoingReplace = '<div class="modern-horizontal-scroll">
    @foreach($ongoingProjects as $idx => $p)
        <a href="{{ route(\'ongoing-projects.show\', $p->slug) }}" class="project-card reveal delay-100">
            <div class="project-status-tag" style="background: #1a242f"><i class="fas fa-hard-hat" style="margin-right: 4px;"></i> ONGOING</div>
            <img src="{{ $p->cover_image ?? asset(\'images/placeholder.jpg\') }}" alt="{{ $p->name }}" loading="lazy">
            <div class="project-info">
                <p style="color:#c5a059; font-size:0.7rem; letter-spacing:2px; font-weight:700; text-transform:uppercase;">{{ $p->location ?? \'PENANG, MALAYSIA\' }}</p>
                <h4 style="font-family:\'Oswald\', sans-serif; font-size:1.6rem; margin-top:5px;">{{ $p->name }}</h4>
            </div>
        </a>
    @endforeach
</div>';
$content = str_replace($ongoingTarget, $ongoingReplace, $content);
$content = str_replace('id="currentProjectsSection" class="bg-off-white" style="padding: 80px 0 60px; display: none;"', 'id="currentProjectsSection" class="bg-off-white" style="padding: 80px 0 60px;"', $content);

$mediaTarget = '<div id="mediaGrid" class="media-grid"></div>';
$mediaReplace = '<div class="media-grid">
    @foreach($latestMedia as $idx => $m)
        <a href="{{ $m->external_url ?? \'#\' }}" target="_blank" class="media-card reveal delay-100" style="text-decoration:none; color:inherit;">
            <img src="{{ $m->publisher_logo ?? asset(\'images/placeholder.jpg\') }}" class="media-img" alt="{{ $m->title }}" loading="lazy">
            <div class="media-content">
                <span class="tagline">{{ $m->publisher ?? \'Media\' }}</span>
                <h3 style="font-family:\'Oswald\', sans-serif; font-size:1.4rem; color:var(--navy); margin:10px 0;">{{ $m->title }}</h3>
                <p style="font-size:0.9rem; color:var(--text-light); margin-bottom:15px;">{{ \Carbon\Carbon::parse($m->published_date)->format(\'M d, Y\') }}</p>
                <span style="font-size:0.85rem; font-weight:700; color:var(--gold); display:flex; align-items:center; gap:8px;">READ ARTICLE <i class="fas fa-arrow-right"></i></span>
            </div>
        </a>
    @endforeach
</div>';
$content = str_replace($mediaTarget, $mediaReplace, $content);
$content = str_replace('id="dynamicMediaSection" style="display: none;"', 'id="dynamicMediaSection"', $content);

$endPos = strpos($content, '</main>');
if ($endPos !== false) {
    $scriptContent = '
    <div id="imageOverlay" onclick="this.style.display=\'none\'"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.9); z-index:99999; justify-content:center; align-items:center; cursor:pointer;"
        aria-label="Close image overlay">
        <img id="overlayImg" src=""
            style="max-width:90%; max-height:90vh; border-radius:8px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);"
            alt="Expanded Media Recognition">
    </div>

@push(\'scripts\')
<script>
    const slides = document.querySelectorAll(\'.hero-slider .slide\');
    const progContainer = document.getElementById(\'progContainer\');
    let currentSlide = 0;
    const slideDuration = 6000;

    slides.forEach((_, i) => {
        const bar = document.createElement(\'div\');
        bar.className = `prog-bar ${i === 0 ? \'active\' : \'\'}`;
        if(progContainer) progContainer.appendChild(bar);
    });
    const bars = document.querySelectorAll(\'.prog-bar\');

    function nextSlide() {
        if(slides.length === 0) return;
        slides[currentSlide].classList.remove(\'active\');
        if(bars[currentSlide]) bars[currentSlide].classList.remove(\'active\');

        currentSlide = (currentSlide + 1) % slides.length;

        slides[currentSlide].classList.add(\'active\');
        if(bars[currentSlide]) bars[currentSlide].classList.add(\'active\');
    }

    if(slides.length > 0) setInterval(nextSlide, slideDuration);

    const counters = document.querySelectorAll(\'.counter\');
    const speed = 200;

    const startCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute(\'data-target\');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    };

    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounters();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => counterObserver.observe(counter));

    const revealElements = document.querySelectorAll(\'.reveal\');
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add(\'active\');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

    revealElements.forEach(el => revealObserver.observe(el));

    function showImage(src) {
        document.getElementById(\'overlayImg\').src = src;
        document.getElementById(\'imageOverlay\').style.display = \'flex\';
    }
</script>
@endpush
@endsection
';
    $content = substr($content, 0, $endPos) . $scriptContent;
}

file_put_contents('c:/Users/built/Herd/builtech-app/resources/views/welcome.blade.php', $content);
echo "Done";

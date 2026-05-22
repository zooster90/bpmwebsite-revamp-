@extends('layouts.app')

@section('title', 'We Built to Last | Engineering Excellence Since 1996')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<main>
    <header class="hero">
        <div class="hero-slider">
            <div class="slide active"
                style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1920')">
            </div>
            <div class="slide" style="background-image: url('{{ asset('/img/images/photo-1517089596392-fb9a9033e05b.avif') }}')"></div>
            <div class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=1920')">
            </div>
            <div class="slide" style="background-image: url('{{ asset('/img/images/fogging%203.jpg') }}')"></div>
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="main-slogan reveal active">CIDB Grade 7 Certified</div>
            <h1 class="reveal active delay-100">
                <img src="{{ asset('/img/images/webuiltolast.png') }}" alt="We Built To Last" />
            </h1>
            <p class="sub-slogan reveal active delay-200">
                Delivering engineering excellence and unlimited construction capacity for Malaysia's most complex
                industrial and commercial landmarks.
            </p>
            <div style="margin-top: 35px" class="reveal active delay-300">
                <a href="{{ url('services') }}" class="btn-primary magnetic-btn">OUR EXPERTISE</a>
            </div>
        </div>
        <div class="slider-progress-container" id="progContainer"></div>
    </header>

    <section class="big-4-section">
        <div class="stats-grid glass-card">
            <div class="stat-item reveal delay-100">
                <img src="{{ asset('/img/images/cidb_logo-768x250.png') }}" style="max-height:45px; margin-bottom:10px; object-fit: contain; filter: brightness(0) invert(1);" alt="CIDB Logo"/>
                <span class="stat-label">CIDB RATING</span>
                <div class="stat-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                        class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span class="stat-desc">GRADE G7</span>
            </div>
            <div class="stat-item reveal delay-200">
                <img src="{{ asset('/img/images/SGS_ISO%209001%20-%20DSM%20Mark_TCL_LR.jpg') }}" style="max-height:45px; margin-bottom:10px; object-fit: contain; border-radius: 4px;" alt="ISO 9001"/>
                <span class="stat-label">Market Presence</span>
                <div class="stat-value"><span class="counter" id="experience-counter" data-target="30">0</span>+
                </div>
                <span class="stat-desc">Years of Excellence</span>
            </div>
            <a href="{{ url('awards') }}" class="stat-item reveal delay-300">
                <img src="{{ asset('/img/images/qlassic.jpg') }}" style="max-height:45px; margin-bottom:10px; object-fit: contain; border-radius: 4px;" alt="QLASSIC Logo"/>
                <span class="stat-label">QLASSIC Quality</span>
                <div class="stat-value"><span class="counter" data-target="82">0</span>%</div>
                <span class="stat-desc">Highest Standards</span>
            </a>
            <a href="{{ url('story') }}" class="stat-item reveal delay-400">
                <img src="{{ asset('/img/images/shassic_logo-removebg-preview.png') }}" style="max-height:45px; margin-bottom:10px; object-fit: contain; filter: brightness(0) invert(1);" alt="SHASSIC Logo"/>
                <span class="stat-label">EHS Compliance</span>
                <div class="stat-value"><span class="counter" data-target="83">0</span>%</div>
                <span class="stat-desc">Safety Excellence</span>
            </a>
        </div>
    </section>

    <section class="section-padding bg-white">
        <div class="container">
            <div class="management-grid">
                <div>
                    <span class="tagline reveal reveal-left">Management Excellence</span>
                    <h2 class="heading-main reveal reveal-left delay-100">Integrated Solutions for a Dynamic World.
                    </h2>
                    <p class="desc-text reveal reveal-left delay-200">Builtech Project Management Sdn. Bhd. stands
                        as a premier CIDB Grade 7 contractor. We manage risks, optimize timelines, and ensure every
                        bolt meets international ISO standards.</p>
                    <p class="desc-text reveal reveal-left delay-300">From design-build phases to turnkey handovers,
                        our methodology is rooted in technical superiority.</p>
                </div>
                <div class="reveal reveal-right delay-200" style="position: relative">
                    <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=1200"
                        class="management-img" alt="Construction Site Coordination" loading="lazy" />
                    <div class="management-badge reveal delay-400 glass-card">
                        <span
                            style="font-family: 'Oswald', sans-serif; font-size: 2.8rem; display: block; line-height: 1;">100+</span>
                        <span
                            style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Successful
                            Handovers</span>
                    </div>
                </div>
            </div>

            <div class="advantage-grid">
                <div class="adv-card reveal delay-100 glass-card">
                    <div class="icon-wrapper"><i class="fas fa-shield-alt"></i></div>
                    <h4>Uncompromising Integrity</h4>
                    <p style="font-size: 0.95rem; color: var(--text-light);">Absolute transparency ensuring
                        stakeholders are protected at every stage.</p>
                </div>
                <div class="adv-card reveal delay-200 glass-card">
                    <div class="icon-wrapper"><i class="fas fa-laptop-code"></i></div>
                    <h4>Technical Innovation</h4>
                    <p style="font-size: 0.95rem; color: var(--text-light);">Utilizing BIM and modern tools to
                        eliminate construction bottlenecks.</p>
                </div>
                <div class="adv-card reveal delay-300 glass-card">
                    <div class="icon-wrapper"><i class="fas fa-user-shield"></i></div>
                    <h4>Safety First Culture</h4>
                    <p style="font-size: 0.95rem; color: var(--text-light);">SHASSIC scores reflect our commitment
                        to ensuring every worker returns home safely.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-off-white">
        <div class="container">
            <div
                style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; flex-wrap: wrap; gap: 1rem;">
                <h2 class="heading-sub reveal reveal-left">CORE SPECIALIZATIONS</h2>
                <a href="{{ url('services') }}" class="link-underline reveal reveal-right">VIEW FULL CAPABILITIES</a>
            </div>
            <div class="specs-grid">
                <div class="spec-card reveal delay-100 glass-card">
                    <div class="icon-wrapper"><i class="fas fa-city"></i></div>
                    <h3>Turnkey Construction</h3>
                    <p style="font-size: 0.95rem; color: var(--text-light)">Design-and-build solutions for
                        residential high-rises and commercial landmarks.</p>
                </div>
                <div class="spec-card reveal delay-200 glass-card">
                    <div class="icon-wrapper"><i class="fas fa-vial"></i></div>
                    <h3>Medical Infrastructure</h3>
                    <p style="font-size: 0.95rem; color: var(--text-light)">Specialized engineering for hospitals
                        and healthcare extensions.</p>
                </div>
                <div class="spec-card reveal delay-300 glass-card">
                    <div class="icon-wrapper"><i class="fas fa-hard-hat"></i></div>
                    <h3>Civil & Infrastructure</h3>
                    <p style="font-size: 0.95rem; color: var(--text-light)">Earthworks and complex engineering for
                        public and private sectors.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white" style="padding: 100px 0 60px;">
        <div class="container text-center" style="margin-bottom: 30px; padding: 0 5%;">
            <span class="tagline reveal delay-100">Our Masterpieces</span>
            <h2 class="heading-main reveal delay-200">Flagship Developments</h2>
        </div>

        <div class="swipe-hint reveal delay-300"><i class="fas fa-arrows-alt-h"></i> Swipe to explore projects</div>

        <div class="modern-horizontal-scroll" id="flagshipProjectsWrapper">
            @if(isset($featuredProjects) && count($featuredProjects) > 0)
                @foreach($featuredProjects as $project)
                <a href="{{ $project['detail_page'] }}" class="project-card reveal">
                    <img src="{{ $project['cover_image'] }}" alt="{{ $project['name'] }}" loading="lazy" />
                    <div class="project-info">
                        <span class="project-cat">{{ $project['category'] }}</span>
                        <h3>{{ $project['name'] }}</h3>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $project['location'] }}</p>
                    </div>
                </a>
                @endforeach
            @else
                <p style="text-align:center; padding: 40px; color:var(--text-light); width:100%;">Archiving records...</p>
            @endif
        </div>

        <div class="text-center reveal delay-400" style="margin-top: 30px; padding: 0 5%;">
            <a href="{{ url('track-records') }}" class="btn-outline magnetic-btn">
                VIEW MORE PROJECTS <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
            </a>
        </div>
    </section>

    <!-- ── AFFILIATED REGULATORY BODIES ── -->
    <section class="section-padding" style="background-color: #fcfaf8;">
        <div class="container text-center">
            
            <div class="reveal" style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
                <span style="width: 4px; height: 4px; border-radius: 50%; background-color: var(--color-gold);"></span>
                <span style="width: 14px; height: 14px; border-radius: 50%; border: 1px solid var(--color-gold);"></span>
            </div>
            
            <h2 class="reveal" style="font-family: var(--font-heading); color: #6b7280; font-size: 1.25rem; letter-spacing: 0.1em; margin-bottom: 3.5rem; text-transform: uppercase; font-weight: 800;">Affiliated Regulatory Bodies</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16 px-4 md:px-0">
                
                <!-- CIDB Malaysia -->
                <a href="https://www.cidb.gov.my/" target="_blank" class="bg-white rounded-[1rem] shadow-sm p-6 flex flex-col items-center justify-center border border-stone-100 reveal delay-100 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="h-16 flex items-center justify-center w-full mb-4">
                        <img src="{{ asset('/img/images/cidb_logo-768x250.png') }}" class="max-h-12 max-w-[80%] object-contain filter grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="CIDB Malaysia" onerror="this.style.display='none'">
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-navy uppercase">CIDB Malaysia</span>
                </a>
                
                <!-- JKR Malaysia -->
                <a href="https://www.jkr.gov.my/" target="_blank" class="bg-white rounded-[1rem] shadow-sm p-8 flex flex-col items-center justify-center border border-stone-100 reveal delay-200 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="h-16 flex items-center justify-center w-full mb-4">
                        <img src="{{ asset('/img/images/jkr_logo.png') }}" class="max-h-12 max-w-[80%] object-contain filter grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="JKR Malaysia">
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-navy uppercase">JKR Malaysia</span>
                </a>
                
                <!-- MBPP Penang -->
                <a href="https://www.mbpp.gov.my/" target="_blank" class="bg-white rounded-[1rem] shadow-sm p-8 flex flex-col items-center justify-center border border-stone-100 reveal delay-300 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="h-16 flex items-center justify-center w-full mb-4">
                        <img src="{{ asset('/img/images/mbpp_logo.png') }}" class="max-h-12 max-w-[80%] object-contain filter grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="MBPP Penang">
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-navy uppercase">MBPP Penang</span>
                </a>
                
                <!-- MBSP Penang -->
                <a href="https://www.mbsp.gov.my/" target="_blank" class="bg-white rounded-[1rem] shadow-sm p-8 flex flex-col items-center justify-center border border-stone-100 reveal delay-400 hover:shadow-md transition-all hover:-translate-y-1 group">
                    <div class="h-16 flex items-center justify-center w-full mb-4">
                        <img src="{{ asset('/img/images/mbsp_logo.png') }}" class="max-h-12 max-w-[80%] object-contain filter grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="MBSP Penang">
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-navy uppercase">MBSP Penang</span>
                </a>

            </div>

        </div>
    </section>

    @include('partials.category-sectors')

    <section class="section-padding bg-white" id="dynamicMediaSection">
        <div class="container">
            <div
                style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 60px; flex-wrap: wrap; gap: 1.5rem;">
                <div>
                    <p class="tagline reveal reveal-left">VALIDATED BY AUTHORITY</p>
                    <h2 class="heading-sub reveal reveal-left delay-100">MEDIA RECOGNITION</h2>
                </div>
                <a href="{{ url('media') }}" class="link-underline reveal reveal-right delay-200">VIEW FULL MEDIA
                    ARCHIVE</a>
            </div>
            <div id="mediaGrid" class="media-grid">
                @if(isset($pressCoverage) && count($pressCoverage) > 0)
                    @foreach($pressCoverage as $media)
                    <a href="{{ $media['external_url'] ?: '#' }}" class="media-card reveal" target="_blank">
                        <div class="media-img-wrapper">
                            <img src="{{ $media['display_image'] }}" alt="{{ $media['headline'] }}" loading="lazy" />
                        </div>
                        <div class="media-content">
                            <span class="media-date">{{ $media['published_date'] }}</span>
                            <h4>{{ $media['headline'] }}</h4>
                            <p>{{ Str::limit($media['excerpt'], 80) }}</p>
                        </div>
                    </a>
                    @endforeach
                @else
                    <!-- Fallback Placeholder Data to ensure Media Records are displayed -->
                    <a href="{{ url('media') }}" class="media-card reveal">
                        <div class="media-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=800" alt="Placeholder" loading="lazy" />
                        </div>
                        <div class="media-content">
                            <span class="media-date">{{ now()->subDays(5)->format('d M Y') }}</span>
                            <h4>Builtech Achieves New Heights in Engineering</h4>
                            <p>Continuing the legacy of excellence and quality across national infrastructure development projects.</p>
                        </div>
                    </a>
                    <a href="{{ url('media') }}" class="media-card reveal delay-100">
                        <div class="media-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=800" alt="Placeholder" loading="lazy" />
                        </div>
                        <div class="media-content">
                            <span class="media-date">{{ now()->subDays(12)->format('d M Y') }}</span>
                            <h4>Awarded Best CIDB G7 Contractor Recognition</h4>
                            <p>Industry recognition for unwavering commitment to SHASSIC safety guidelines and high-quality project delivery.</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <section class="iso-strip">
        <h2 class="heading-sub reveal" style="margin-bottom: 50px;">Accredited Management Excellence</h2>
        <div class="iso-container">
            <div class="iso-card reveal delay-100 glass-card">
                <h3 class="iso-header">ISO 9001:2015</h3>
                <div class="iso-img-wrapper"><img src="{{ asset('/img/images/SGS_ISO%209001%20-%20DSM%20Mark_TCL_LR.jpg') }}"
                        alt="ISO 9001 Operational Quality Certification" loading="lazy" /></div>
                <h4 class="iso-id">MY10/00630.01</h4>
                <p class="iso-desc">Operational Quality</p>
            </div>
            <div class="iso-card reveal delay-200 glass-card">
                <h3 class="iso-header">ISO 45001:2018</h3>
                <div class="iso-img-wrapper"><img src="{{ asset('/img/images/SGS_ISO%2045001%20DSM%20Mark_TCL_LR.jpg') }}"
                        alt="ISO 45001 Safety Management Certification" loading="lazy" /></div>
                <h4 class="iso-id">MY15/01790.01</h4>
                <p class="iso-desc">Safety Management</p>
            </div>
            <div class="iso-card reveal delay-300 glass-card">
                <h3 class="iso-header">ISO 14001:2015</h3>
                <div class="iso-img-wrapper"><img src="{{ asset('/img/images/ISO_14001_Latest.jpg') }}"
                        alt="ISO 14001 Eco-Conscious Building Certification" loading="lazy" /></div>
                <h4 class="iso-id">6071254/E</h4>
                <p class="iso-desc">Eco-Conscious Building</p>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="team-img-bg"></div>
        <div class="team-content">
            <span class="tagline reveal">Team Unity</span>
            <h2 class="heading-main reveal delay-100" style="color: white; margin-bottom: 25px;">Our People, Our
                Pride.</h2>
            <p class="desc-text reveal delay-200" style="color: #cbd5e1; margin-bottom: 40px;">
                We believe in building a legacy not just through structures, but through the development of our
                community and the continuous growth of our expert team.
            </p>
            <div>
                <a href="{{ url('our-people') }}" class="btn-primary reveal delay-300 magnetic-btn">MEET THE TEAM</a>
            </div>
        </div>
    </section>

    <section class="final-cta">
        <div class="cta-bg-icon"><i class="fas fa-hard-hat"></i></div>
        <div style="max-width: 800px; margin: 0 auto; position: relative; z-index: 2;">
            <h2 class="heading-main reveal" style="color: white; margin-bottom: 20px;">Ready To Build Your Next
                Landmark?</h2>
            <p class="desc-text reveal delay-100"
                style="color: white; font-size: 1.15rem; margin-bottom: 40px; opacity: 0.95;">
                Partner with Builtech for unparalleled engineering precision, transparent project management, and
                uncompromised safety standards.
            </p>
            <a href="{{ url('contact') }}" class="btn-navy reveal delay-200 magnetic-btn">CONTACT OUR EXPERTS</a>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    // Intersection Observer for Reveal animations
    const observerReveal = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.15 });

    document.addEventListener("DOMContentLoaded", () => {
        const foundingYear = 1996;
        const currentYear = new Date().getFullYear();
        const yearsOfExcellence = currentYear - foundingYear;

        const expCounter = document.getElementById('experience-counter');
        if (expCounter) expCounter.setAttribute('data-target', yearsOfExcellence);

        document.querySelectorAll('.reveal').forEach(el => observerReveal.observe(el));

        // Hero Slider Logic
        let curSlide = 0;
        const slides = document.querySelectorAll(".slide");
        const prog = document.getElementById("progContainer");
        if (slides.length > 0 && prog) {
            slides.forEach((_, i) => {
                let b = document.createElement("div");
                b.className = "prog-bar" + (i === 0 ? " active" : "");
                prog.appendChild(b);
            });
            setInterval(() => {
                slides[curSlide].classList.remove("active");
                prog.children[curSlide].classList.remove("active");
                curSlide = (curSlide + 1) % slides.length;
                slides[curSlide].classList.add("active");
                prog.children[curSlide].classList.add("active");
            }, 6000);
        }

        // Counter Animation
        const observerCounter = new IntersectionObserver((entries, observerInstance) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    const target = +e.target.dataset.target;
                    if (!isNaN(target)) {
                        let c = 0;
                        const anim = () => {
                            c += target / 50;
                            if (c < target) {
                                e.target.innerText = Math.floor(c);
                                requestAnimationFrame(anim);
                            } else {
                                e.target.innerText = target;
                            }
                        };
                        anim();
                    }
                    observerInstance.unobserve(e.target);
                }
            });
        });
        document.querySelectorAll(".counter").forEach(c => observerCounter.observe(c));
    });
</script>
@endpush

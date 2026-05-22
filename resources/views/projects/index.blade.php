@extends('layouts.app')

@section('title', 'Track Records | Master Portfolio | Builtech Official')

@section('meta')
    <meta name="description" content="Explore Builtech's verified portfolio of high-quality construction projects. Documenting a legacy of structural integrity.">
@endsection

@push('styles')
<style>
    /* ============================================================
       BUILTECH ELITE - PROJECTS INDEX (100% REPLICA)
       ============================================================ */
    
    .main-header { 
        padding-top: 180px; 
        padding-bottom: 120px;
        background: var(--navy);
        position: relative; 
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    .main-header::before {
        content: ''; 
        position: absolute; 
        inset: 0;
        background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070') center/cover no-repeat;
        opacity: 0.15;
        filter: grayscale(100%);
    }
    .main-header::after {
        content: ''; 
        position: absolute; 
        inset: 0;
        background: linear-gradient(135deg, rgba(10,31,56,0.95) 0%, rgba(22,46,74,0.8) 100%);
    }

    .glass-stats {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 40px;
    }

    .filter-bar {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        padding: 8px;
        margin: -50px auto 60px;
        max-width: 1150px;
        position: relative;
        z-index: 30;
        border: 1px solid rgba(197, 160, 89, 0.1);
    }

    .custom-select {
        appearance: none;
        background: transparent;
        border: none;
        width: 100%;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--navy);
        padding: 12px 40px 12px 16px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23c5a059' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 14px;
        cursor: pointer;
        letter-spacing: 0.5px;
    }

    /* Project Card */
    .project-card { 
        position: relative;
        height: 480px;
        border-radius: 24px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: var(--transition-premium);
        cursor: pointer;
    }
    .project-image-container { width: 100%; height: 100%; position: relative; overflow: hidden; }
    .project-image { width: 100%; height: 100%; object-fit: cover; transition: transform 1.2s cubic-bezier(0.2, 0, 0.2, 1), opacity 0.5s ease; opacity: 0.9; }
    .project-info-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 31, 56, 0.98) 0%, rgba(10, 31, 56, 0.4) 60%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        opacity: 0;
        transform: translateY(20px);
        transition: var(--transition-premium);
        z-index: 10;
    }
    .project-card:hover .project-info-overlay { opacity: 1; transform: translateY(0); }
    .project-card:hover .project-image { transform: scale(1.1); opacity: 0.7; }
    .project-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(10,31,56,0.18); }

    .year-badge {
        position: absolute;
        top: 25px;
        right: 25px;
        background: var(--white);
        color: var(--navy);
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        z-index: 20;
        font-family: 'Oswald', sans-serif;
        transition: 0.3s ease;
    }
    .project-card:hover .year-badge { background: var(--gold); color: white; }

    .status-pill {
        margin-top: 15px;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(5px);
        text-transform: uppercase;
    }
    .pill-completed { background: rgba(134, 239, 172, 0.15); color: #86efac; border: 1px solid rgba(134,239,172,0.3); }
    .pill-ongoing   { background: rgba(253, 224, 71, 0.15); color: #fde047; border: 1px solid rgba(253,224,71,0.3); }
</style>
@endpush

@section('content')
<main>
    <header class="main-header">
        <div class="container relative z-10">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-16">
                <div class="lg:w-1/2 text-center lg:text-left reveal">
                    <div class="inline-flex items-center gap-4 mb-8 justify-center lg:justify-start">
                        <span class="h-1 w-12 bg-[var(--gold)]"></span>
                        <span class="tagline" style="color: var(--gold); margin-bottom: 0;">Established 1996</span>
                    </div>
                    <h1 class="heading-main" style="color: white; font-size: clamp(3.5rem, 6vw, 6rem); line-height: 1;">
                        PROJECT<br><span style="color: var(--gold);">RECORDS</span>
                    </h1>
                    <p class="desc-text" style="color: rgba(255,255,255,0.7); max-width: 500px; margin: 2rem 0;">
                        Documenting a legacy of structural integrity, engineering precision, and a commitment to excellence in the Malaysian construction landscape.
                    </p>
                </div>

                <div class="lg:w-auto reveal stagger-2">
                    <div class="glass-stats flex flex-col sm:flex-row items-center gap-8 sm:gap-16">
                        <div class="text-center">
                            <div class="text-7xl font-oswald font-bold" style="color: var(--gold);">{{ $projects->count() }}</div>
                            <p class="tagline" style="font-size: 0.6rem; color: rgba(255,255,255,0.4);">Master Portfolio</p>
                        </div>
                        <div class="h-32 w-px bg-white/10 hidden sm:block"></div>
                        <div class="grid grid-cols-1 gap-y-4">
                            <div class="flex items-center gap-4">
                                <span class="text-3xl font-oswald font-bold text-white">{{ $projects->where('status', 'Completed')->count() }}</span>
                                <p class="tagline" style="font-size: 0.6rem; color: #86efac; margin-bottom: 0;">Completed</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-3xl font-oswald font-bold text-white">{{ $projects->where('status', 'Ongoing')->count() }}</span>
                                <p class="tagline" style="font-size: 0.6rem; color: #fde047; margin-bottom: 0;">Ongoing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section-padding" style="background: var(--off-white); padding-bottom: 120px;">
        <div class="container">
            <!-- Filter Bar (Visual Mockup for now, but fully styled) -->
            <div class="filter-bar reveal">
                <div class="grid grid-cols-1 md:grid-cols-12 items-center">
                    <div class="md:col-span-4 flex items-center gap-4 px-8 py-5 border-b md:border-b-0 md:border-r border-gray-100">
                        <i class="fas fa-search" style="color: var(--gold);"></i>
                        <input type="text" placeholder="Search projects..." class="w-full bg-transparent outline-none font-semibold text-sm">
                    </div>
                    <div class="md:col-span-4 flex items-center px-6 py-2 border-b md:border-b-0 md:border-r border-gray-100">
                        <select class="custom-select">
                            <option value="all">ALL PROJECT CATEGORIES</option>
                            <option>INDUSTRIAL</option>
                            <option>COMMERCIAL</option>
                            <option>HEALTHCARE</option>
                        </select>
                    </div>
                    <div class="md:col-span-4 flex items-center px-6 py-2">
                        <select class="custom-select">
                            <option value="all">ALL PROJECT STATUS</option>
                            <option>COMPLETED</option>
                            <option>ONGOING</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($projects as $index => $project)
                <div class="reveal stagger-{{ ($index % 3) + 1 }}">
                    <div class="project-card" onclick="window.location.href='{{ route('projects.show', $project->slug) }}'">
                        <div class="project-image-container">
                            @php
                                $coverImg = $project->getFirstMediaUrl('cover_image') ?: ($project->image_url ?: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=800');
                            @endphp
                            <img src="{{ $coverImg }}" class="project-image" alt="{{ $project->name }}">
                            <div class="year-badge">{{ $project->completion_year ?? 'Legacy' }}</div>
                            <div class="project-info-overlay">
                                <span class="tagline" style="color: var(--gold); margin-bottom: 0.5rem; font-size: 0.65rem;">{{ $project->category?->name ?? 'Specialist' }}</span>
                                <h3 style="font-family: Oswald, sans-serif; font-size: 1.75rem; color: white; margin-bottom: 10px;">{{ $project->name }}</h3>
                                <div class="desc-text" style="color: rgba(255,255,255,0.8); font-size: 0.8rem; margin-bottom: 15px;">
                                    <i class="fas fa-map-marker-alt" style="color: var(--gold); margin-right: 5px;"></i> {{ $project->location }}
                                </div>
                                <div class="status-pill {{ strtolower($project->status) == 'completed' ? 'pill-completed' : 'pill-ongoing' }}">
                                    <i class="fas fa-circle" style="font-size: 6px;"></i> {{ strtoupper($project->status) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-20 flex justify-center reveal">
                {{ $projects->links('vendor.pagination.simple-tailwind') }}
            </div>
        </div>
    </section>
</main>
@endsection

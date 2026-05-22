@extends('layouts.app')

@section('title', 'Corporate Journal | Builtech Project Management')

@section('content')
<div class="bt-wrapper bg-[#FBFBFA]">
    <!-- Page Hero -->
    <section class="relative overflow-hidden" style="padding: 200px 5% 160px; background: linear-gradient(180deg, #090e1a 0%, #151d33 100%);">
        <div class="absolute inset-0" style="background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000') center/cover no-repeat; opacity: 0.18; filter: grayscale(0.5) contrast(1.1);"></div>
        
        <!-- Nature-inspired soft feathered fade transition at bottom -->
        <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-[#FBFBFA] via-[#FBFBFA]/40 to-transparent z-10 pointer-events-none"></div>

        <div class="bt-container relative z-10 reveal">
            <div class="max-w-4xl">
                <span class="inline-block bg-gold/15 border border-gold/35 text-[#f2cf92] px-6 py-2 rounded-full font-heading text-xs font-extrabold uppercase tracking-[0.3em] mb-6 backdrop-blur-md" style="color: #f2cf92 !important;">
                    <i class="fas fa-newspaper mr-2"></i>The Builtech Journal
                </span>
                <h1 style="font-family: 'Oswald', sans-serif; font-size: clamp(3.2rem, 8vw, 6rem); font-weight: 800; color: #ffffff; line-height: 1.05; margin-bottom: 1.5rem; text-transform: uppercase; text-shadow: 0 4px 20px rgba(0,0,0,0.65);">
                    Corporate <br><span style="color: #f2cf92 !important; text-shadow: 0 4px 25px rgba(242, 207, 146, 0.3);">Journal.</span>
                </h1>
                <p style="font-size: 1.15rem; color: rgba(255, 255, 255, 0.92) !important; line-height: 1.85; max-width: 640px; text-shadow: 0 2px 12px rgba(0,0,0,0.6); font-weight: 500;">
                    Documenting the technical precision, project milestones, and industry innovations that define Malaysia's engineering excellence.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Feed Section (Naturally overlapping the feathered hero fade for organic flow) -->
    <section class="bt-section pb-48" style="margin-top: -100px; padding-top: 0; position: relative; z-index: 30;">
        <div class="bt-container">
            <div class="flex flex-col lg:flex-row gap-20">
                
                <!-- Main Feed (Left) -->
                <div class="flex-1 space-y-24">
                    @if(isset($articles) && $articles->count() > 0)
                        @php $featured = $articles->first(); @endphp
                        
                        <!-- Premium Redesigned Featured Card (Pristine legibility and organic layout) -->
                        <article class="reveal group bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden transition-all duration-500 hover:translate-y-[-8px] hover:shadow-[0_20px_50px_rgba(10,25,47,0.12)]">
                            <!-- Image Container -->
                            <a href="{{ route('news.show', $featured->slug) }}" class="block relative aspect-[4/3] md:aspect-[21/9] overflow-hidden">
                                <img src="{{ $featured->display_image ?? 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1200' }}" 
                                     class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-105">
                                <div class="absolute inset-0 bg-navy/5 group-hover:bg-navy/15 transition-colors duration-500"></div>
                                <div class="absolute top-6 left-6 z-20">
                                    <span class="bg-gold text-white text-[10px] font-extrabold uppercase tracking-widest px-4 py-2 rounded-sm shadow-md">
                                        {{ $featured->category?->name ?? 'Featured Story' }}
                                    </span>
                                </div>
                            </a>
                            
                            <!-- Text content container (Off-white structure for flawless reading) -->
                            <div class="p-8 md:p-10 bg-white">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.25rem;">
                                    <span style="font-size: 0.72rem; font-weight: 800; color: var(--gold); text-transform: uppercase; letter-spacing: 0.12em;">{{ $featured->category?->name ?? 'Featured' }}</span>
                                    <span style="width: 4px; height: 4px; background: #e2e8f0; border-radius: 50%; display: block;"></span>
                                    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">{{ $featured->published_date ? \Carbon\Carbon::parse($featured->published_date)->format('d M Y') : $featured->created_at->format('d M Y') }}</span>
                                </div>
                                
                                <h2 style="font-family: 'Oswald', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; color: var(--navy); margin-bottom: 1.25rem; line-height: 1.25;" class="group-hover:text-gold transition-colors duration-300">
                                    <a href="{{ route('news.show', $featured->slug) }}">{{ $featured->title }}</a>
                                </h2>
                                
                                <p style="font-size: 1.05rem; color: var(--text-body); line-height: 1.85; margin-bottom: 2rem;" class="line-clamp-3">
                                    {{ Str::limit(strip_tags($featured->excerpt ?? $featured->content), 250) }}
                                </p>
                                
                                <a href="{{ route('news.show', $featured->slug) }}" style="font-size: 0.8rem; font-weight: 800; color: var(--navy); text-transform: uppercase; letter-spacing: 0.25em; display: inline-flex; align-items: center; gap: 8px; border-bottom: 2px solid var(--gold); padding-bottom: 4px;" class="hover:text-gold hover:border-gold transition-colors">
                                    Read Full Article <i class="fa-solid fa-arrow-right text-xs" style="color: var(--gold); margin-left: 2px;"></i>
                                </a>
                            </div>
                        </article>

                        <!-- Staggered Secondary Feed -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                            @foreach($articles->skip(1) as $article)
                                <article class="reveal group" data-delay="{{ ($loop->index % 2) * 200 }}">
                                    <a href="{{ route('news.show', $article->slug) }}" class="block aspect-[4/3] overflow-hidden rounded-xl mb-6 relative">
                                        <img src="{{ $article->display_image ?? 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=800' }}" 
                                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 grayscale group-hover:grayscale-0">
                                        <div class="absolute top-3 right-3">
                                            <span style="font-size: 0.72rem; font-weight: 800; background: rgba(255,255,255,0.95); color: var(--navy); padding: 4px 12px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.1em;">{{ $article->published_date ? \Carbon\Carbon::parse($article->published_date)->format('M Y') : $article->created_at->format('M Y') }}</span>
                                        </div>
                                    </a>
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.75rem;">
                                            <span style="font-size: 0.72rem; font-weight: 800; color: var(--gold); text-transform: uppercase; letter-spacing: 0.12em;">{{ $article->category?->name ?? 'Update' }}</span>
                                            <span style="width: 4px; height: 4px; background: #d1d5db; border-radius: 50%; display: block;"></span>
                                            <span style="font-size: 0.82rem; color: var(--text-muted);">{{ $article->published_date ? \Carbon\Carbon::parse($article->published_date)->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                        </div>
                                        <h3 style="font-family: 'Oswald', sans-serif; font-size: 1.4rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; line-height: 1.2;">
                                            <a href="{{ route('news.show', $article->slug) }}" class="group-hover:text-gold transition-colors">{{ $article->title }}</a>
                                        </h3>
                                        <a href="{{ route('news.show', $article->slug) }}" style="font-size: 0.78rem; font-weight: 800; color: var(--navy); text-transform: uppercase; letter-spacing: 0.2em; display: flex; align-items: center; gap: 8px;" class="hover:text-gold transition-colors">
                                            Read More <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: var(--gold);"></i>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pt-24 reveal">
                            {{ $articles->appends(request()->query())->links() }}
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-40 bg-white rounded-sm border border-gray-50 reveal">
                            <i class="fa-solid fa-newspaper text-6xl text-gray-100 mb-8"></i>
                            <h3 class="text-3xl font-bold text-navy">Archive is currently pending updates.</h3>
                            <p class="text-gray-400 mt-4 max-w-sm mx-auto">We are constantly working on groundbreaking projects. Check back soon for the latest stories.</p>
                        </div>
                    @endif
                </div>

                <!-- Premium Sidebar (Right) -->
                <aside class="w-full lg:w-96 space-y-12">
                    
                    <!-- Search Widget -->
                    <div class="bg-white border border-gray-100 p-8 rounded-xl reveal">
                        <h4 style="font-size: 0.72rem; font-weight: 800; color: var(--navy); text-transform: uppercase; letter-spacing: 0.3em; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">Search Articles</h4>
                        <form action="{{ route('news.index') }}" method="GET" class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Type to search..." 
                                   class="w-full bg-off-white border-none p-5 rounded-sm focus:ring-1 focus:ring-gold outline-none text-sm font-light">
                            <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2 text-gold">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Topics Navigation -->
                    <div class="bg-white border border-gray-100 p-8 rounded-xl reveal">
                        <h4 style="font-size: 0.72rem; font-weight: 800; color: var(--navy); text-transform: uppercase; letter-spacing: 0.3em; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">Journal Topics</h4>
                        <nav class="space-y-6">
                            <a href="{{ route('news.index') }}" 
                               class="flex items-center justify-between text-sm group {{ !request('category') ? 'text-navy font-black' : 'text-gray-400 hover:text-navy' }}">
                                <span class="flex items-center gap-4">
                                    <span class="w-2 h-2 rounded-full {{ !request('category') ? 'bg-gold shadow-[0_0_10px_rgba(197,160,89,0.5)]' : 'bg-gray-100' }} transition-all"></span>
                                    Full Archive
                                </span>
                                <span class="text-[10px] font-bold opacity-30 group-hover:opacity-100 transition-opacity">01</span>
                            </a>
                            @php
                                $topicMap = [
                                    'Company News' => '02',
                                    'Project Updates' => '03',
                                    'Industry Insights' => '04',
                                    'Awards & Recognition' => '05',
                                    'CSR & Community' => '06'
                                ];
                            @endphp
                            @foreach($topicMap as $label => $num)
                                <a href="{{ route('news.index', ['category' => $label]) }}" 
                                   class="flex items-center justify-between text-sm group {{ request('category') == $label ? 'text-navy font-black' : 'text-gray-400 hover:text-navy' }}">
                                    <span class="flex items-center gap-4">
                                        <span class="w-2 h-2 rounded-full {{ request('category') == $label ? 'bg-gold shadow-[0_0_10px_rgba(197,160,89,0.5)]' : 'bg-gray-100 group-hover:bg-gold/40' }} transition-all"></span>
                                        {{ $label }}
                                    </span>
                                    <span class="text-[10px] font-bold opacity-30 group-hover:opacity-100 transition-opacity">{{ $num }}</span>
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <!-- Interactive Partner CTA -->
                    <div class="bg-navy p-12 rounded-sm shadow-2xl reveal relative overflow-hidden group">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-gold/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                        <div class="relative z-10 text-center">
                            <div class="w-16 h-16 bg-white/5 border border-white/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:border-gold/50 transition-colors">
                                <i class="fa-solid fa-briefcase text-2xl text-gold"></i>
                            </div>
                            <h4 style="font-family: 'Oswald', sans-serif; font-size: 1.8rem; font-weight: 700; color: white; margin-bottom: 1rem; line-height: 1.2;">Start Your <br><span style="color: var(--gold);">Legacy.</span></h4>
                            <p style="font-size: 0.95rem; color: rgba(255,255,255,0.65); margin-bottom: 2rem; line-height: 1.75;">Partner with Malaysia's Grade G7 leader on your next landmark project.</p>
                            <a href="{{ route('contact') }}" class="btn-primary" style="width: 100%; justify-content: center;">Consult Our Engineers</a>
                            <div style="margin-top: 1.5rem; font-size: 0.72rem; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.3em; font-weight: 800;">Established 1996</div>
                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </section>
</div>
@endsection

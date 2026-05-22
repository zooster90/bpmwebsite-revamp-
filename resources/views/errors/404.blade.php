<x-layout>
    <x-slot:title>404 | Project Entry Not Found | Builtech</x-slot:title>

    <div class="bg-navy min-h-screen flex items-center justify-center relative overflow-hidden text-center p-6">
        <div class="absolute inset-0 z-0 opacity-10 select-none pointer-events-none">
            <div class="text-[50vh] font-black text-white leading-none">404</div>
        </div>

        <div class="relative z-10 max-w-xl">
            <span class="text-gold font-black uppercase tracking-[0.6em] text-[10px] mb-8 block">Structural Error</span>
            <h1 class="text-5xl md:text-7xl font-black font-heading text-white mb-12 tracking-tighter leading-none">Entry Not Archived.</h1>
            <p class="text-stone-400 mb-16 text-lg font-light leading-relaxed">
                The requested blueprint or project record does not exist in our corporate database. It may have been relocated to the Master Archive.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="/" class="btn-premium bg-gold text-white hover:bg-gold-light shadow-2xl shadow-gold/20 !px-12">
                    Global Base &rarr;
                </a>
                <a href="/projects" class="btn-premium bg-white/5 border border-white/20 text-white hover:bg-white/10 !px-12">
                    Master Portfolio
                </a>
            </div>
        </div>

        {{-- Professional Detail --}}
        <div class="absolute bottom-12 right-12 hidden md:block">
            <img src="/img/webuiltolast.png" alt="Slogan" class="h-6 w-auto opacity-10 invert brightness-200">
        </div>
    </div>
</x-layout>

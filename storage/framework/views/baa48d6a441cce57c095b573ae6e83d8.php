<style>
.frontend-shortcuts-container {
    border-radius: 0.75rem;
    background-color: #ffffff;
    padding: 1.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
}
.dark .frontend-shortcuts-container {
    background-color: #1f2937;
    border-color: #374151;
}
.frontend-shortcuts-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1rem;
}
.dark .frontend-shortcuts-title {
    color: #9ca3af;
}
.frontend-shortcuts-grid {
    display: grid !important;
    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    gap: 0.75rem !important;
}
@media (min-width: 768px) {
    .frontend-shortcuts-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    }
}
@media (min-width: 1024px) {
    .frontend-shortcuts-grid {
        grid-template-columns: repeat(8, minmax(0, 1fr)) !important;
    }
}
.frontend-shortcut-card {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.5rem !important;
    padding: 0.75rem !important;
    background-color: #f9fafb !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 0.5rem !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
}
.dark .frontend-shortcut-card {
    background-color: #111827 !important;
    border-color: #374151 !important;
}
.frontend-shortcut-card:hover {
    background-color: #fdfaf2 !important; /* Gold Tint */
    border-color: #d97706 !important; /* Gold border */
}
.dark .frontend-shortcut-card:hover {
    background-color: rgba(217, 119, 6, 0.15) !important;
    border-color: #fbbf24 !important;
}
.frontend-shortcut-icon {
    width: 20px !important;
    height: 20px !important;
    color: #6b7280 !important;
    transition: color 0.2s ease !important;
}
.dark .frontend-shortcut-icon {
    color: #9ca3af !important;
}
.frontend-shortcut-card:hover .frontend-shortcut-icon {
    color: #d97706 !important;
}
.dark .frontend-shortcut-card:hover .frontend-shortcut-icon {
    color: #fbbf24 !important;
}
.frontend-shortcut-label {
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    color: #4b5563 !important;
    transition: color 0.2s ease !important;
}
.dark .frontend-shortcut-label {
    color: #d1d5db !important;
}
.frontend-shortcut-card:hover .frontend-shortcut-label {
    color: #b45309 !important;
}
.dark .frontend-shortcut-card:hover .frontend-shortcut-label {
    color: #fbbf24 !important;
}
</style>

<div class="frontend-shortcuts-container">
    <h3 class="frontend-shortcuts-title">Visit Website</h3>
    <div class="frontend-shortcuts-grid">

        
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
            <span class="frontend-shortcut-label">Home</span>
        </a>

        
        <a href="<?php echo e(route('projects.index')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
            <span class="frontend-shortcut-label">Projects</span>
        </a>

        
        <a href="<?php echo e(route('news.index')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>
            <span class="frontend-shortcut-label">News</span>
        </a>

        
        <a href="<?php echo e(route('awards')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" /></svg>
            <span class="frontend-shortcut-label">Awards</span>
        </a>

        
        <a href="<?php echo e(route('media')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>
            <span class="frontend-shortcut-label">Media</span>
        </a>

        
        <a href="<?php echo e(route('culture')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" /></svg>
            <span class="frontend-shortcut-label">Culture</span>
        </a>

        
        <a href="<?php echo e(route('careers')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" /></svg>
            <span class="frontend-shortcut-label">Careers</span>
        </a>

        
        <a href="<?php echo e(route('contact')); ?>" target="_blank" class="frontend-shortcut-card">
            <svg class="frontend-shortcut-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
            <span class="frontend-shortcut-label">Contact</span>
        </a>

    </div>
</div><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/filament/widgets/frontend-shortcuts.blade.php ENDPATH**/ ?>
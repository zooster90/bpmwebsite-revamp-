<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap');

    /* =====================================================
       BUILTECH ADMIN — CLEAN ENTERPRISE UI
       Design: Senior Developer Designer Refinement
    ===================================================== */

    :root {
        /* ── Warm Cream + Gold Palette ── */
        --bt-navy:        #292524;   /* warm stone-800 */
        --bt-gold:        #c5a059;
        --bt-gold-hover:  #b08d47;
        --bt-gold-light:  #f5edd9;  /* warm gold tint */
        --bt-bg:          #f7f5f2;  /* warm cream — the page background */
        --bt-card:        #fdfcfb;  /* warm white cards */
        --bt-sidebar:     #fffef9;  /* very warm sidebar white */
        --bt-border:      #e8e3db;  /* warm stone border */
        --bt-border-soft: #f0ebe3;  /* even softer divider */
        --bt-text:        #1c1917;  /* stone-950 warm near-black */
        --bt-muted:       #78716c;  /* stone-500 warm grey */
        --bt-radius:      14px;
        --bt-shadow:      0 2px 10px rgba(40, 30, 20, 0.05);
        --bt-shadow-lg:   0 8px 28px rgba(40, 30, 20, 0.08);
        --bt-transition:  all 0.22s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* Tighter widget gap for bento feel */
    .fi-wi { gap: 16px !important; }
    .fi-page-main > .fi-page-content { padding-top: 1.5rem !important; }

    @media (max-width: 1024px) {
        .bt-bento { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 640px) {
        .bt-bento { grid-template-columns: 1fr !important; }
    }

    body, html {
        background-color: var(--bt-bg) !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        -webkit-font-smoothing: antialiased;
        color: var(--bt-text) !important;
    }

    .fi-main, .fi-body {
        background-color: var(--bt-bg) !important;
    }

    /* ── Side-to-Side Content ────────────────────────────── */
    .fi-main-ctn {
        padding: 2rem !important;
    }

    /* ── SIDEBAR — Warm Cream Sidebar ────────── */
    .fi-sidebar {
        background: var(--bt-sidebar) !important;
        border-right: 1px solid var(--bt-border) !important;
        box-shadow: 2px 0 16px rgba(40, 30, 20, 0.04) !important;
    }

    .fi-sidebar-header {
        background: transparent !important;
        padding: 24px 20px !important;
        border-bottom: 1px solid var(--bt-border) !important;
    }

    /* Custom Navigation Item Styling */
    .fi-sidebar-item-button {
        border-radius: 10px !important;
        margin: 4px 12px !important;
        padding: 10px 16px !important;
        background: transparent !important;
        transition: var(--bt-transition) !important;
    }
    
    .fi-sidebar-item-label {
        font-weight: 600 !important;
        color: var(--bt-muted) !important;
        font-size: 0.9rem !important;
        transition: var(--bt-transition) !important;
    }

    .fi-sidebar-item-icon {
        color: var(--bt-muted) !important;
        transition: var(--bt-transition) !important;
    }

    .fi-sidebar-item-button:hover {
        background: var(--bt-gold-light) !important;
    }

    .fi-sidebar-item-button:hover .fi-sidebar-item-label,
    .fi-sidebar-item-button:hover .fi-sidebar-item-icon {
        color: var(--bt-text) !important;
    }

    /* Active State Enhancement */
    .fi-active > .fi-sidebar-item-btn,
    .fi-sidebar-item-active > .fi-sidebar-item-button {
        background: rgba(197, 160, 89, 0.08) !important;
    }

    .fi-active .fi-sidebar-item-label, 
    .fi-active .fi-sidebar-item-icon {
        color: var(--bt-gold) !important;
        font-weight: 700 !important;
    }

    /* ── TOPBAR ───────────────────────────────────── */
    .fi-topbar {
        background: rgba(253, 252, 251, 0.92) !important;
        backdrop-filter: blur(14px) !important;
        border-bottom: 1px solid var(--bt-border) !important;
        box-shadow: 0 1px 0 rgba(40, 30, 20, 0.06) !important;
    }

    /* ── MODERN CARD SYSTEMS ────────────────────────────── */
    .fi-ta-ctn, .fi-wi-stats-overview-stat, .fi-section, .fi-fo-ctn, .fi-in-ctn {
        background: var(--bt-card) !important;
        border-radius: var(--bt-radius) !important;
        border: 1px solid var(--bt-border) !important;
        box-shadow: var(--bt-shadow) !important;
        transition: var(--bt-transition) !important;
    }

    .fi-ta-ctn:hover, .fi-section:hover, .fi-in-ctn:hover {
        box-shadow: var(--bt-shadow-lg) !important;
    }

    /* Stats Styling */
    .fi-wi-stats-overview-stat {
        padding: 24px !important;
    }
    
    .fi-wi-stats-overview-stat-label {
        font-weight: 600 !important;
        color: var(--bt-muted) !important;
        font-size: 0.85rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    .fi-wi-stats-overview-stat-value {
        font-weight: 800 !important;
        color: var(--bt-text) !important;
    }

    /* ── TABLES ────────────────────── */
    .fi-ta-header-cell {
        background: var(--bt-gold-light) !important;
        padding: 14px 20px !important;
        color: var(--bt-muted) !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        font-size: 0.72rem !important;
        letter-spacing: 0.06em !important;
        border-bottom: 1px solid var(--bt-border) !important;
    }

    .fi-ta-row {
        transition: var(--bt-transition) !important;
    }

    .fi-ta-row:hover {
        background: var(--bt-gold-light) !important;
    }

    .fi-ta-cell {
        padding: 14px 20px !important;
        color: var(--bt-text) !important;
        border-bottom: 1px solid var(--bt-border-soft) !important;
    }

    /* ── BUTTONS ──────────────────────────── */
    .fi-btn {
        border-radius: 8px !important;
        font-weight: 600 !important;
        box-shadow: none !important;
    }

    .fi-btn-color-primary {
        background: var(--bt-gold) !important;
        color: white !important;
    }

    .fi-btn-color-primary:hover {
        background: var(--bt-gold-hover) !important;
    }

    /* Forms */
    .fi-input-wrapper {
        border-radius: 8px !important;
        border: 1px solid var(--bt-border) !important;
        box-shadow: none !important;
    }

    .fi-input-wrapper:focus-within {
        border-color: var(--bt-gold) !important;
        box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.15) !important;
    }

    .fi-fo-field-wrp-label {
        font-weight: 600 !important;
        color: var(--bt-text) !important;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb {
        background: #d6cfc5;
        border-radius: 6px;
    }
    ::-webkit-scrollbar-thumb:hover { background: var(--bt-gold); }

    /* Theme Switcher Hiding */
    .fi-theme-switcher { display: none !important; }

    /* Headings */
    .fi-header-heading {
        font-weight: 800 !important;
        color: var(--bt-text) !important;
    }

    /* ── EMPTY STATE SVG FIX ─────────────────────────────
       Filament's empty-state illustration uses fill:currentColor.
       Inheriting dark body text makes the whole SVG solid black.
       Reset it to a soft grey so it renders correctly.
    ─────────────────────────────────────────────────────── */
    .fi-ta-empty-state-icon,
    .fi-ta-empty-state-icon svg,
    .fi-ta-empty-state svg,
    .fi-empty-state svg,
    .fi-empty-state-icon svg {
        color: #d6cfc5 !important;
        fill: #d6cfc5 !important;
    }

    /* Prevent any rogue img / svg inside widgets going huge */
    .fi-wi img, .fi-wi svg:not(.fi-icon) {
        max-width: 100% !important;
        max-height: 200px !important;
    }

    /* ── DIRECT FIX FOR FILAMENT FILE UPLOAD IMAGE EDITOR ── */
    
    /* Ensure the editor modal backdrop and window stay centered and never overflow screen */
    .fi-fo-file-upload-editor {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: fixed !important;
        inset: 0 !important;
        z-index: 9999 !important;
        padding: 1.5rem !important;
        background-color: rgba(15, 23, 42, 0.75) !important; /* Premium dark glass overlay */
        backdrop-filter: blur(8px) !important;
    }

    /* 🔥 Prevent !important from overriding Alpine.js hide logic */
    .fi-fo-file-upload-editor[style*="display: none"],
    .fi-fo-file-upload-editor[x-cloak] {
        display: none !important;
    }

    .fi-fo-file-upload-editor-window {
        display: flex !important;
        flex-direction: row !important; /* Force side-by-side on desktop */
        width: 80vw !important;
        max-width: 1050px !important;
        height: 72vh !important;
        max-height: 620px !important;
        background-color: #0f172a !important; /* Dark studio mode background */
        border-radius: 1.25rem !important;
        overflow: hidden !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5) !important;
    }

    /* Constrain the image section so it can't explode horizontally or vertically */
    .fi-fo-file-upload-editor-image-ctn {
        flex: 1 1 0% !important;
        min-width: 0 !important; /* Critical to prevent flexbox content blowout */
        height: 100% !important;
        background-color: #020617 !important; /* Pure black backdrop for studio editing */
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: relative !important;
        padding: 1rem !important;
    }

    .fi-fo-file-upload-editor-image-ctn img {
        max-width: 100% !important;
        max-height: 100% !important;
        border-radius: 8px !important;
    }

    .cropper-container {
        max-width: 100% !important;
        max-height: 100% !important;
    }

    /* Make sure the control panel sidebar is ALWAYS locked to the right side of the screen */
    .fi-fo-file-upload-editor-control-panel {
        width: 320px !important;
        min-width: 320px !important;
        max-width: 320px !important;
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        border-left: 1px solid rgba(255, 255, 255, 0.1) !important;
        background-color: #0f172a !important; /* Dark studio panel */
        flex-shrink: 0 !important; /* Prevent it from shrinking */
    }

    .fi-fo-file-upload-editor-control-panel-main {
        flex: 1 1 0% !important;
        overflow-y: auto !important;
        padding: 1.5rem !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 1.25rem !important;
    }

    /* Premium style for coordinate inputs inside dark panel */
    .fi-fo-file-upload-editor-control-panel-main label {
        color: #94a3b8 !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    .fi-fo-file-upload-editor-control-panel-main .fi-input-wrapper {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        border-radius: 8px !important;
        color: #f8fafc !important;
        transition: all 0.2s ease !important;
    }

    .fi-fo-file-upload-editor-control-panel-main .fi-input-wrapper:focus-within {
        border-color: #c5a059 !important; /* Gold border accent on focus */
        box-shadow: 0 0 0 1px #c5a059 !important;
    }

    .fi-fo-file-upload-editor-control-panel-main .fi-input-wrapper input {
        color: #f8fafc !important;
    }

    /* Dark mode title text for Aspect Ratio */
    .fi-fo-file-upload-editor-control-panel-group-title {
        color: #94a3b8 !important;
        font-size: 0.72rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        margin-bottom: 0.5rem !important;
    }

    /* Action buttons (Cropping tools, aspect ratio buttons) */
    .fi-fo-file-upload-editor-control-panel-main .fi-btn {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        color: #cbd5e1 !important;
        border-radius: 8px !important;
        transition: all 0.2s !important;
    }

    .fi-fo-file-upload-editor-control-panel-main .fi-btn:hover {
        background-color: #334155 !important;
        color: #fff !important;
    }

    .fi-fo-file-upload-editor-control-panel-main .fi-btn.fi-active {
        background-color: #c5a059 !important;
        border-color: #c5a059 !important;
        color: #0f172a !important;
        font-weight: 700 !important;
    }

    /* Footer area with primary action buttons */
    .fi-fo-file-upload-editor-control-panel-footer {
        padding: 1.25rem 1.5rem !important;
        border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        background-color: #020617 !important;
        display: flex !important;
        gap: 0.75rem !important;
        justify-content: flex-end !important;
        flex-shrink: 0 !important;
    }

    /* Cancel Button (Clean outline) */
    .fi-fo-file-upload-editor-control-panel-footer button:nth-child(1) {
        background: transparent !important;
        border: 1.5px solid #475569 !important;
        color: #cbd5e1 !important;
        padding: 0.5rem 1.25rem !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        transition: all 0.2s !important;
    }

    .fi-fo-file-upload-editor-control-panel-footer button:nth-child(1):hover {
        border-color: #94a3b8 !important;
        color: #fff !important;
        background-color: rgba(255, 255, 255, 0.05) !important;
    }

    /* Reset Button (Clean Danger Red) */
    .fi-fo-file-upload-editor-control-panel-footer .fi-fo-file-upload-editor-control-panel-reset-action {
        background-color: #ef4444 !important;
        color: #fff !important;
        padding: 0.5rem 1.25rem !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        border: none !important;
        transition: all 0.2s !important;
    }

    .fi-fo-file-upload-editor-control-panel-footer .fi-fo-file-upload-editor-control-panel-reset-action:hover {
        background-color: #dc2626 !important;
        box-shadow: 0 0 12px rgba(239, 68, 68, 0.4) !important;
    }

    /* Save Button (Gold Theme matching Builtech) */
    .fi-fo-file-upload-editor-control-panel-footer button[class*="success"] {
        background-color: #c5a059 !important;
        color: #0f172a !important;
        padding: 0.5rem 1.5rem !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        border: none !important;
        transition: all 0.2s !important;
    }

    .fi-fo-file-upload-editor-control-panel-footer button[class*="success"]:hover {
        background-color: #d4af37 !important;
        box-shadow: 0 0 15px rgba(197, 160, 89, 0.4) !important;
    }

    /* ── MOBILE RESPONSIVE ADAPTATION ── */
    @media (max-width: 768px) {
        .fi-fo-file-upload-editor {
            padding: 0.5rem !important;
        }

        .fi-fo-file-upload-editor-window {
            flex-direction: column !important; /* Stack vertically on small screens */
            width: 100vw !important;
            height: 98vh !important;
            max-height: none !important;
            border-radius: 0.75rem !important;
        }

        .fi-fo-file-upload-editor-image-ctn {
            height: 50% !important;
            flex: none !important;
        }

        .fi-fo-file-upload-editor-control-panel {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            height: 50% !important;
            border-left: none !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .fi-fo-file-upload-editor-control-panel-main {
            padding: 1rem !important;
            gap: 1rem !important;
        }

        .fi-fo-file-upload-editor-control-panel-footer {
            padding: 1rem !important;
        }
    }

    /* ── PREMIUM CINEMATIC LOGIN PAGE OVERRIDES ─────────── */
    .fi-simple-layout {
        background: radial-gradient(circle at 10% 20%, rgba(247, 245, 242, 1) 0%, rgba(232, 227, 219, 0.7) 100%) !important;
        position: relative;
        overflow: hidden;
    }

    /* Adding subtle premium gold glow points behind the login card */
    .fi-simple-layout::before {
        content: "";
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(197, 160, 89, 0.15) 0%, transparent 65%);
        top: -200px;
        left: -100px;
        pointer-events: none;
        z-index: 0;
    }
    
    .fi-simple-layout::after {
        content: "";
        position: absolute;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(41, 37, 36, 0.04) 0%, transparent 70%);
        bottom: -300px;
        right: -100px;
        pointer-events: none;
        z-index: 0;
    }

    .fi-simple-main-ctn {
        position: relative;
        z-index: 10;
    }

    .fi-simple-main {
        background: rgba(253, 252, 251, 0.95) !important;
        backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(197, 160, 89, 0.25) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(40, 30, 20, 0.12) !important;
        padding: 40px !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease !important;
    }

    .fi-simple-main:hover {
        box-shadow: 0 24px 48px rgba(197, 160, 89, 0.15) !important;
        transform: translateY(-2px);
    }

    /* Beautiful corporate logo styling on login */
    .fi-simple-header {
        margin-bottom: 28px !important;
    }

    .fi-simple-header img {
        filter: drop-shadow(0 4px 12px rgba(40, 30, 20, 0.08)) !important;
        transition: transform 0.3s ease !important;
    }

    .fi-simple-header img:hover {
        transform: scale(1.03);
    }

    .fi-simple-header h1 {
        font-family: 'DM Serif Display', serif !important;
        font-size: 1.75rem !important;
        font-weight: 700 !important;
        color: var(--bt-navy) !important;
        margin-top: 16px !important;
        letter-spacing: -0.5px !important;
    }

    .fi-simple-header p {
        color: var(--bt-muted) !important;
        font-weight: 500 !important;
        font-size: 0.875rem !important;
    }
</style>
<script>
(function() {
    // 1. Function to dynamically load scripts
    function loadScript(src) {
        return new Promise((resolve, reject) => {
            if (window.heic2any) {
                resolve();
                return;
            }
            const script = document.createElement('script');
            script.src = src;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    // 2. Compress and resize images using HTML5 Canvas (runs locally, very fast)
    function compressAndResizeImage(file, maxDimension = 2000, quality = 0.85) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    let width = img.width;
                    let height = img.height;
                    
                    // Downscale if image dimensions exceed maxDimension
                    if (width > maxDimension || height > maxDimension) {
                        if (width > height) {
                            height = Math.round((height * maxDimension) / width);
                            width = maxDimension;
                        } else {
                            width = Math.round((width * maxDimension) / height);
                            height = maxDimension;
                        }
                    }
                    
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    canvas.toBlob((blob) => {
                        if (blob) {
                            // Convert extension to .jpg
                            const newName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                            const compressedFile = new File([blob], newName, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            resolve(compressedFile);
                        } else {
                            resolve(file);
                        }
                    }, 'image/jpeg', quality);
                };
                img.onerror = () => resolve(file);
                img.src = e.target.result;
            };
            reader.onerror = () => resolve(file);
            reader.readAsDataURL(file);
        });
    }

    // 3. Convert HEIC/HEIF files to JPEG using heic2any
    function convertHeic(file) {
        console.log('Converting HEIC image to JPEG: ' + file.name);
        
        return loadScript('/js/heic2any.min.js')
            .then(() => {
                return window.heic2any({
                    blob: file,
                    toType: 'image/jpeg',
                    quality: 0.85
                });
            })
            .then((resultBlob) => {
                const blob = Array.isArray(resultBlob) ? resultBlob[0] : resultBlob;
                const newName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                const convertedFile = new File([blob], newName, { type: 'image/jpeg' });
                
                // After conversion, compress and resize the image
                return compressAndResizeImage(convertedFile);
            })
            .catch((err) => {
                console.error('HEIC conversion failed, falling back to original file:', err);
                return file;
            });
    }

    // 4. Intercept FilePond instances to hook into beforeAddFile
    let filePondInstance = window.FilePond;
    function interceptFilePond(fp) {
        if (!fp || fp.isIntercepted) return;
        fp.isIntercepted = true;
        
        const originalCreate = fp.create;
        fp.create = function(element, options) {
            options = options || {};
            
            // Bypass accepted types validation to allow HEIC files to be dropped/selected
            if (options.acceptedFileTypes) {
                if (Array.isArray(options.acceptedFileTypes)) {
                    if (!options.acceptedFileTypes.includes('image/heic')) {
                        options.acceptedFileTypes.push('image/heic', '.heic', 'image/heif', '.heif');
                    }
                } else if (typeof options.acceptedFileTypes === 'string') {
                    if (!options.acceptedFileTypes.includes('heic')) {
                        options.acceptedFileTypes += ', image/heic, .heic, image/heif, .heif';
                    }
                }
            }
            
            // Bypass max file size validation temporarily during adding (we will compress it before saving)
            if (options.maxFileSize) {
                options.maxFileSize = '200MB'; // Temporarily allow large files
            }
            
            // Hook into beforeAddFile callback
            const originalBeforeAddFile = options.beforeAddFile;
            options.beforeAddFile = function(fileItem) {
                const file = fileItem.file;
                if (!file) return true;
                
                const extension = file.name.split('.').pop().toLowerCase();
                const isHeic = extension === 'heic' || extension === 'heif' || file.type === 'image/heic' || file.type === 'image/heif';
                
                if (isHeic) {
                    return convertHeic(file);
                } else if (file.type.startsWith('image/') && file.size > 1.5 * 1024 * 1024) {
                    // Auto-compress JPEGs/PNGs larger than 1.5MB to save storage and optimize page load
                    console.log('Compressing large image: ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + 'MB)');
                    return compressAndResizeImage(file);
                }
                
                if (originalBeforeAddFile) {
                    return originalBeforeAddFile(fileItem);
                }
                return true;
            };
            
            return originalCreate.call(fp, element, options);
        };
        console.log('FilePond image auto-conversion & HEIC engine successfully hooked!');
    }
    
    function addBackButton() {
        const heading = document.querySelector('h1.fi-header-heading');
        if (!heading) return;
        
        const url = window.location.href;
        const isSubPage = url.includes('/create') || /\/\d+(\/edit)?$/.test(url) || url.includes('/edit');
        
        if (!isSubPage) return;
        if (document.querySelector('.bt-back-btn')) return; // Already exists
        
        const backBtn = document.createElement('button');
        backBtn.className = 'bt-back-btn flex items-center justify-center p-2 rounded-xl transition-all duration-200 mr-3 shadow-sm';
        backBtn.style.backgroundColor = 'var(--bt-gold-light)';
        backBtn.style.color = 'var(--bt-gold)';
        backBtn.style.border = 'none';
        backBtn.style.cursor = 'pointer';
        backBtn.style.width = '36px';
        backBtn.style.height = '36px';
        backBtn.style.flexShrink = '0';
        backBtn.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path>
            </svg>
        `;
        backBtn.title = "Go Back";
        
        // Hover effects
        backBtn.addEventListener('mouseenter', () => {
            backBtn.style.backgroundColor = 'var(--bt-gold)';
            backBtn.style.color = '#ffffff';
            backBtn.style.transform = 'translateX(-2px)';
        });
        backBtn.addEventListener('mouseleave', () => {
            backBtn.style.backgroundColor = 'var(--bt-gold-light)';
            backBtn.style.color = 'var(--bt-gold)';
            backBtn.style.transform = 'none';
        });
        
        backBtn.addEventListener('click', () => {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                const indexUrl = url.replace(/\/create$/, '').replace(/\/\d+(\/edit)?$/, '').replace(/\/edit$/, '');
                window.location.href = indexUrl;
            }
        });
        
        const parent = heading.parentElement;
        if (parent) {
            parent.style.display = 'flex';
            parent.style.flexDirection = 'row';
            parent.style.alignItems = 'center';
            parent.insertBefore(backBtn, heading);
        }
    }

    // Set up interceptor via getter/setter on window
    Object.defineProperty(window, 'FilePond', {
        get: function() {
            return filePondInstance;
        },
        set: function(val) {
            filePondInstance = val;
            interceptFilePond(filePondInstance);
        },
        configurable: true
    });
    
    if (window.FilePond) {
        interceptFilePond(window.FilePond);
    }
})();

document.addEventListener('DOMContentLoaded', function () {
    // Elegant Page Transitions
    const main = document.querySelector('.fi-main');
    if (main) {
        main.style.opacity = '0';
        main.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        main.style.transform = 'translateY(10px)';
        setTimeout(() => {
            main.style.opacity = '1';
            main.style.transform = 'translateY(0)';
        }, 50);
    }

    // Initialize back button
    addBackButton();

    // Observe changes to the DOM (for Livewire re-renders)
    const observer = new MutationObserver(() => {
        addBackButton();
    });
    observer.observe(document.body, { childList: true, subtree: true });
});
</script>
<?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/filament/custom-css.blade.php ENDPATH**/ ?>
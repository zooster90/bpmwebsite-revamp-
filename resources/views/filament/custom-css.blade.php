<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap');

    /* ═══════════════════════════════════════════════════════════════
       BUILTECH ADMIN — 2026 HIGH-END ENTERPRISE UI
       Senior Developer + World-Class UX/UI Design System
    ═══════════════════════════════════════════════════════════════ */

    :root {
        --bt-navy:        #292524;
        --bt-gold:        #c5a059;
        --bt-gold-hover:  #b08d47;
        --bt-gold-light:  #f5edd9;
        --bt-gold-glow:   rgba(197, 160, 89, 0.18);
        --bt-bg:          #f7f5f2;
        --bt-card:        #fdfcfb;
        --bt-sidebar:     #fffef9;
        --bt-border:      #e8e3db;
        --bt-border-soft: #f0ebe3;
        --bt-text:        #1c1917;
        --bt-muted:       #78716c;
        --bt-radius:      14px;
        --bt-shadow:      0 2px 10px rgba(40, 30, 20, 0.05);
        --bt-shadow-lg:   0 8px 28px rgba(40, 30, 20, 0.10);
        --bt-transition:  all 0.22s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* ── BASE ── */
    body, html {
        background-color: var(--bt-bg) !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        -webkit-font-smoothing: antialiased;
        color: var(--bt-text) !important;
    }
    .fi-main, .fi-body { background-color: var(--bt-bg) !important; }
    .fi-main-ctn { padding: 1.5rem 2rem !important; }
    .fi-wi { gap: 16px !important; }
    .fi-page-main > .fi-page-content { padding-top: 1.25rem !important; }

    /* ══════════════════════════════════════════
       TOPBAR — Elevated, Glass, Always Sticky
    ══════════════════════════════════════════ */
    .fi-topbar {
        background: rgba(253, 252, 251, 0.96) !important;
        backdrop-filter: blur(20px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
        border-bottom: 1px solid var(--bt-border) !important;
        box-shadow: 0 1px 12px rgba(40, 30, 20, 0.07) !important;
        position: sticky !important;
        top: 0 !important;
        z-index: 50 !important;
    }

    /* Removed custom sidebar toggle CSS to prevent logo overlap */

    /* ══════════════════════════════════════════
       SIDEBAR — Premium Refined v2
       - Gold left-bar accent on active item
       - Refined group headers (small uppercase)
       - Subtle slide-right on hover
       - Polished badge + custom scrollbar
    ══════════════════════════════════════════ */
    .fi-sidebar {
        background: var(--bt-sidebar) !important;
        border-right: 1px solid var(--bt-border) !important;
        box-shadow: 2px 0 24px rgba(40, 30, 20, 0.05) !important;
    }
    .fi-sidebar-header {
        background: transparent !important;
        padding: 24px 20px !important;
        border-bottom: 1px solid var(--bt-border) !important;
        margin-bottom: 4px !important;
    }

    /* Section group headers ("Recognition", "Project Portfolio", etc.) */
    .fi-sidebar-group-label,
    .fi-sidebar-nav-group-label,
    .fi-sidebar-group > .fi-sidebar-group-button {
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        color: var(--bt-muted) !important;
        padding: 14px 22px 6px !important;
        margin-top: 6px !important;
        opacity: 0.85 !important;
    }
    .fi-sidebar-group-collapse-button {
        transition: transform 0.2s ease !important;
    }

    /* Sidebar items */
    .fi-sidebar-item-button {
        border-radius: 10px !important;
        margin: 2px 12px !important;
        padding: 10px 14px !important;
        background: transparent !important;
        transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative !important;
        overflow: hidden !important;
    }
    .fi-sidebar-item-label {
        font-weight: 500 !important;
        color: var(--bt-text) !important;
        font-size: 0.875rem !important;
        transition: var(--bt-transition) !important;
    }
    .fi-sidebar-item-icon {
        color: var(--bt-muted) !important;
        transition: var(--bt-transition) !important;
        width: 20px !important;
        height: 20px !important;
    }

    /* Hover */
    .fi-sidebar-item-button:hover {
        background: var(--bt-gold-light) !important;
        transform: translateX(2px);
    }
    .fi-sidebar-item-button:hover .fi-sidebar-item-label,
    .fi-sidebar-item-button:hover .fi-sidebar-item-icon {
        color: var(--bt-gold) !important;
    }

    /* Active state — gold left bar + tinted bg gradient */
    .fi-active > .fi-sidebar-item-button,
    .fi-sidebar-item-active > .fi-sidebar-item-button,
    .fi-active > .fi-sidebar-item-btn {
        background: linear-gradient(90deg, rgba(197,160,89,0.14) 0%, rgba(197,160,89,0.04) 100%) !important;
    }
    .fi-active > .fi-sidebar-item-button::before,
    .fi-sidebar-item-active > .fi-sidebar-item-button::before {
        content: '';
        position: absolute;
        left: 0;
        top: 8px;
        bottom: 8px;
        width: 3px;
        background: var(--bt-gold);
        border-radius: 0 3px 3px 0;
    }
    .fi-active .fi-sidebar-item-label,
    .fi-active .fi-sidebar-item-icon {
        color: var(--bt-gold) !important;
        font-weight: 600 !important;
    }

    /* Badge (e.g. Contact Enquiries count) */
    .fi-sidebar-item-badge,
    .fi-sidebar .fi-badge {
        background: var(--bt-gold) !important;
        color: #fff !important;
        font-weight: 700 !important;
        border-radius: 999px !important;
        padding: 2px 9px !important;
        font-size: 0.7rem !important;
        line-height: 1.2 !important;
        box-shadow: 0 2px 6px rgba(197, 160, 89, 0.25) !important;
    }

    /* Refined scrollbar — only appears on hover */
    .fi-sidebar-nav::-webkit-scrollbar { width: 6px; }
    .fi-sidebar-nav::-webkit-scrollbar-track { background: transparent; }
    .fi-sidebar-nav::-webkit-scrollbar-thumb {
        background: transparent;
        border-radius: 3px;
        transition: background 0.2s;
    }
    .fi-sidebar-nav:hover::-webkit-scrollbar-thumb {
        background: rgba(197, 160, 89, 0.3);
    }
    .fi-sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: rgba(197, 160, 89, 0.5);
    }

    /* ═══════════════════════════════════════════════════════════════
       TABLES — THE BIGGEST UX FIX
       Problem: Action buttons (Edit/Delete) require scrolling right.
       Fix: Sticky last column, always-visible actions, no wrapping.
    ═══════════════════════════════════════════════════════════════ */

    .fi-ta-ctn {
        background: var(--bt-card) !important;
        border-radius: var(--bt-radius) !important;
        border: 1px solid var(--bt-border) !important;
        box-shadow: 0 10px 40px rgba(40,30,20,0.06) !important;
        overflow: hidden !important;
    }

    /* Floating Search & Filters Toolbar */
    .fi-ta-header-toolbar {
        padding: 20px 24px !important;
        background: #fdfbf8 !important;
        border-bottom: 1px solid rgba(232, 227, 219, 0.8) !important;
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
    }
    
    /* ── Search Input ── */
    .fi-ta-search-field .fi-input-wrapper {
        border-radius: 99px !important;
        padding: 2px 14px !important;
        background: #ffffff !important;
        border: 1px solid rgba(197, 160, 89, 0.25) !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02), 0 2px 8px rgba(40,30,20,0.03) !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        min-width: 280px !important;
    }
    .fi-ta-search-field .fi-input-wrapper:focus-within {
        border-color: var(--bt-gold) !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.01), 0 4px 16px rgba(197, 160, 89, 0.15) !important;
        transform: translateY(-1px) !important;
    }
    .fi-ta-search-field input {
        font-weight: 500 !important;
        color: var(--bt-navy) !important;
        letter-spacing: 0.01em !important;
    }

    /* ── Filter Section & Dropdowns ── */
    .fi-ta-filters {
        background: white !important;
        border-radius: 16px !important;
        border: 1px solid rgba(232, 227, 219, 0.7) !important;
        box-shadow: 0 10px 30px rgba(40,30,20,0.05) !important;
        padding: 18px 24px !important;
    }
    .fi-ta-filters-header {
        border-bottom: 1px dashed rgba(232, 227, 219, 0.8) !important;
        padding-bottom: 12px !important;
        margin-bottom: 16px !important;
    }
    .fi-ta-filters-heading {
        font-weight: 800 !important;
        color: var(--bt-navy) !important;
        font-size: 1.1rem !important;
        letter-spacing: -0.01em !important;
    }

    /* Reset Button */
    .fi-ta-filters .fi-btn[color="danger"], .fi-ta-filters .fi-btn-color-danger {
        background: transparent !important;
        border: 1px solid rgba(220, 38, 38, 0.2) !important;
        color: #dc2626 !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }
    .fi-ta-filters .fi-btn[color="danger"]:hover {
        background: rgba(220, 38, 38, 0.05) !important;
        border-color: #dc2626 !important;
    }

    /* Apply Filters Button */
    .fi-ta-filters .fi-btn-color-primary, .fi-ta-filters .fi-btn[type="submit"] {
        background: linear-gradient(135deg, var(--bt-gold) 0%, var(--bt-gold-hover) 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(197, 160, 89, 0.25) !important;
        transition: all 0.2s ease !important;
        padding: 8px 20px !important;
    }
    .fi-ta-filters .fi-btn[type="submit"]:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 16px rgba(197, 160, 89, 0.35) !important;
    }

    /* Filter Form Inputs */
    .fi-ta-filters .fi-input-wrapper {
        border-radius: 10px !important;
        background: #fdfcf9 !important;
        border-color: rgba(197, 160, 89, 0.2) !important;
    }
    .fi-ta-filters .fi-fo-field-wrp-label {
        color: var(--bt-muted) !important;
        font-weight: 600 !important;
        font-size: 0.8rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
    }

    /* Enable horizontal scroll so content columns compress gracefully */
    .fi-ta-wrap,
    .fi-ta-ctn > div,
    [class*="overflow-x"] {
        overflow-x: auto !important;
    }

    /* ── STICKY GLASSMORPHISM TABLE HEADER ── */
    .fi-ta-header-cell {
        background: rgba(247, 243, 235, 0.85) !important;
        backdrop-filter: blur(12px) !important;
        position: sticky !important;
        top: 0 !important;
        z-index: 10 !important;
        padding: 14px 18px !important;
        color: var(--bt-navy) !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        font-size: 0.72rem !important;
        letter-spacing: 0.08em !important;
        border-bottom: 1px solid var(--bt-border) !important;
        white-space: nowrap !important;
        box-shadow: 0 4px 12px rgba(40,30,20,0.02) !important;
    }

    /* Row cells */
    .fi-ta-row { 
        transition: all 0.25s ease !important; 
        border-left: 3px solid transparent !important;
    }
    .fi-ta-row:hover { 
        background: rgba(197, 160, 89, 0.04) !important; 
        border-left: 3px solid var(--bt-gold) !important;
    }
    .fi-ta-cell {
        padding: 14px 18px !important;
        color: var(--bt-text) !important;
        border-bottom: 1px solid var(--bt-border-soft) !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
    }

    /* Image Avatars inside tables */
    .fi-ta-image {
        border-radius: 50% !important;
        box-shadow: 0 2px 8px rgba(40,30,20,0.1) !important;
        border: 2px solid white !important;
        transition: transform 0.2s ease !important;
    }
    .fi-ta-row:hover .fi-ta-image {
        transform: scale(1.1) !important;
        border-color: var(--bt-gold-light) !important;
    }

    /* ─── STICKY ACTIONS COLUMN ─── */
    /* The last <td>/<th> in every row is pinned to the right edge */
    .fi-ta-row > td:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 5 !important;
        background: var(--bt-card) !important;
        box-shadow: -6px 0 16px rgba(40,30,20,0.04) !important;
        border-left: 1px dashed var(--bt-border-soft) !important;
    }
    .fi-ta-row:hover > td:last-child {
        background: #faf8f5 !important;
    }
    .fi-ta-header-cell:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 6 !important;
        background: var(--bt-gold-light) !important;
        box-shadow: -4px 0 12px rgba(40,30,20,0.06) !important;
        border-left: 1px solid var(--bt-border) !important;
    }

    /* ─── ROW ACTION BUTTONS: Edit / Delete / View ─── */
    /* Force horizontal layout, no wrapping, always readable */
    .fi-ta-row-actions {
        display: inline-flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 4px !important;
        flex-wrap: nowrap !important;
    }

    /* Action links/buttons base style */
    .fi-link, .fi-ac-action-lnk {
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        padding: 5px 11px !important;
        border-radius: 7px !important;
        font-size: 0.77rem !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        transition: all 0.16s ease !important;
        white-space: nowrap !important;
        border: 1.5px solid transparent !important;
        letter-spacing: 0.01em !important;
    }

    /* Edit — blue pill */
    .fi-link[class*="primary"], .fi-color-primary.fi-link,
    .fi-ac-action-lnk[class*="primary"] {
        color: #2563eb !important;
        background: rgba(37,99,235,0.08) !important;
        border-color: rgba(37,99,235,0.2) !important;
    }
    .fi-link[class*="primary"]:hover, .fi-ac-action-lnk[class*="primary"]:hover {
        background: #2563eb !important; color: white !important; border-color: #2563eb !important;
        box-shadow: 0 3px 10px rgba(37,99,235,0.28) !important;
    }

    /* Delete — red pill */
    .fi-link[class*="danger"], .fi-color-danger.fi-link,
    .fi-ac-action-lnk[class*="danger"] {
        color: #dc2626 !important;
        background: rgba(220,38,38,0.07) !important;
        border-color: rgba(220,38,38,0.2) !important;
    }
    .fi-link[class*="danger"]:hover, .fi-ac-action-lnk[class*="danger"]:hover {
        background: #dc2626 !important; color: white !important; border-color: #dc2626 !important;
        box-shadow: 0 3px 10px rgba(220,38,38,0.28) !important;
    }

    /* View/Other — gold pill */
    .fi-link[class*="gray"], .fi-color-gray.fi-link,
    .fi-ac-action-lnk[class*="gray"],
    .fi-link:not([class*="primary"]):not([class*="danger"]):not([class*="warning"]) {
        color: var(--bt-gold-hover) !important;
        background: var(--bt-gold-light) !important;
        border-color: rgba(197,160,89,0.3) !important;
    }

    /* ══════════════════════════════════════════
       GLOBAL LAYOUT — Premium Studio Background
    ══════════════════════════════════════════ */
    .fi-layout {
        background: radial-gradient(circle at top left, #fdfbf8 0%, #f4efe6 100%) !important;
    }
    .fi-main {
        background: transparent !important;
    }

    /* ══════════════════════════════════════════
       PAGE HEADER — Clean, Spacious, Hierarchical
    ══════════════════════════════════════════ */
    .fi-header {
        padding: 2rem 0 1.5rem !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: space-between !important;
        gap: 16px !important;
    }
    .fi-header-heading {
        font-weight: 900 !important;
        color: var(--bt-navy) !important;
        font-size: clamp(1.8rem, 3vw, 2.2rem) !important;
        line-height: 1.1 !important;
        letter-spacing: -0.03em !important;
    }

    /* JS-injected back button */
    .bt-back-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 36px !important;
        padding: 0 14px !important;
        gap: 6px !important;
        flex-shrink: 0 !important;
        border-radius: 10px !important;
        background: var(--bt-gold-light) !important;
        border: 1.5px solid rgba(197,160,89,0.35) !important;
        color: var(--bt-gold-hover) !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 2px 6px rgba(197,160,89,0.12) !important;
    }
    .bt-back-label {
        font-size: 0.82rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.02em !important;
    }
    .bt-back-btn:hover {
        background: var(--bt-gold) !important;
        color: white !important;
        transform: translateX(-2px) !important;
        box-shadow: 0 4px 16px rgba(197,160,89,0.32) !important;
    }

    /* ══════════════════════════════════════════
       CARDS & SECTIONS
    ══════════════════════════════════════════ */
    .fi-wi-stats-overview-stat, .fi-section, .fi-fo-ctn, .fi-in-ctn {
        background: var(--bt-card) !important;
        border-radius: var(--bt-radius) !important;
        border: 1px solid var(--bt-border) !important;
        box-shadow: var(--bt-shadow) !important;
        transition: var(--bt-transition) !important;
    }
    .fi-section:hover, .fi-in-ctn:hover { box-shadow: var(--bt-shadow-lg) !important; }
    .fi-wi-stats-overview-stat { padding: 22px !important; }
    .fi-wi-stats-overview-stat-label {
        font-weight: 600 !important; color: var(--bt-muted) !important;
        font-size: 0.8rem !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;
    }
    .fi-wi-stats-overview-stat-value { font-weight: 800 !important; color: var(--bt-text) !important; }

    /* ── BUTTONS ── */
    .fi-btn { border-radius: 9px !important; font-weight: 700 !important; box-shadow: none !important; transition: all 0.2s ease !important; }
    .fi-btn-color-primary { background: var(--bt-gold) !important; color: white !important; }
    .fi-btn-color-primary:hover {
        background: var(--bt-gold-hover) !important;
        box-shadow: 0 4px 16px rgba(197,160,89,0.35) !important;
        transform: translateY(-1px) !important;
    }

    /* ── FORMS ── */
    .fi-input-wrapper {
        border-radius: 8px !important; border: 1.5px solid var(--bt-border) !important;
        box-shadow: none !important; background: white !important; transition: all 0.2s ease !important;
    }
    .fi-input-wrapper:focus-within {
        border-color: var(--bt-gold) !important;
        box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.15) !important;
    }
    .fi-fo-field-wrp-label { font-weight: 700 !important; color: var(--bt-text) !important; font-size: 0.875rem !important; }

    /* ── BADGES ── */
    .fi-badge { font-weight: 700 !important; letter-spacing: 0.03em !important; border-radius: 6px !important; font-size: 0.7rem !important; }

    /* ── PAGINATION ── */
    .fi-pagination { padding: 12px 18px !important; background: var(--bt-card) !important; border-top: 1px solid var(--bt-border-soft) !important; }
    .fi-pagination-item-btn { border-radius: 8px !important; font-weight: 600 !important; }
    .fi-pagination-item-btn[aria-current="page"] { background: var(--bt-gold) !important; color: white !important; }

    /* ── GROUP HEADERS (Year dividers like 2024, 2025) ── */
    .fi-ta-header-cell[colspan] {
        background: linear-gradient(90deg, rgba(197,160,89,0.09) 0%, transparent 80%) !important;
        font-size: 0.82rem !important; font-weight: 800 !important; color: var(--bt-text) !important;
        text-transform: none !important; letter-spacing: 0 !important; padding: 9px 18px !important;
    }

    /* ══════════════════════════════════════════
       NOTIFICATIONS & MODALS (Confirmations)
    ══════════════════════════════════════════ */
    .fi-modal-window {
        border-radius: 24px !important; 
        border: 1px solid rgba(255,255,255,0.8) !important;
        box-shadow: 0 40px 100px rgba(40,30,20,0.18) !important; 
        overflow: hidden !important;
        background: rgba(253, 252, 251, 0.95) !important;
        backdrop-filter: blur(20px) !important;
        transform: scale(0.95);
        animation: modalScaleIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
    }
    @keyframes modalScaleIn {
        to { transform: scale(1); }
    }
    .fi-modal-close-btn { transition: all 0.2s ease !important; }
    .fi-modal-close-btn:hover { background: rgba(0,0,0,0.05) !important; color: var(--bt-text) !important; }
    
    /* Toast Notifications */
    .fi-no-notification { 
        border-radius: 16px !important; 
        border: 1px solid var(--bt-border) !important; 
        box-shadow: 0 12px 40px rgba(40,30,20,0.12) !important; 
        background: rgba(255,255,255,0.95) !important;
        backdrop-filter: blur(12px) !important;
    }
    .fi-no-notification.fi-color-success { border-left: 4px solid #10b981 !important; }
    .fi-no-notification.fi-color-danger { border-left: 4px solid #ef4444 !important; }

    /* ══════════════════════════════════════════
       UPLOAD IMAGE PART (FilePond Dropzone)
    ══════════════════════════════════════════ */
    .filepond--root {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }
    .filepond--panel-root {
        background-color: transparent !important;
        border: 2px dashed var(--bt-border) !important;
        border-radius: 16px !important;
        transition: all 0.3s ease !important;
    }
    .filepond--drop-label {
        color: var(--bt-muted) !important;
        font-weight: 600 !important;
    }
    .filepond--drop-label label { cursor: pointer !important; }
    .filepond--root:hover .filepond--panel-root {
        border-color: var(--bt-gold) !important;
        background-color: rgba(197, 160, 89, 0.04) !important;
    }
    .filepond--item-panel {
        background-color: var(--bt-navy) !important;
        border-radius: 12px !important;
    }
    .filepond--image-preview-wrapper {
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    /* ══════════════════════════════════════════
       UPLOAD RECORD PART (Forms & Inputs)
    ══════════════════════════════════════════ */
    .fi-fo-component-ctn {
        transition: all 0.2s ease !important;
    }
    .fi-section {
        background: var(--bt-card) !important;
        border: 1px solid rgba(232, 227, 219, 0.6) !important;
        border-radius: 20px !important;
        box-shadow: 0 4px 20px rgba(40,30,20,0.03) !important;
    }
    .fi-section-header-heading {
        font-size: 1.1rem !important;
        font-weight: 800 !important;
        color: var(--bt-navy) !important;
        letter-spacing: -0.01em !important;
    }
    .fi-input-wrapper {
        border-radius: 12px !important; 
        border: 1.5px solid var(--bt-border) !important;
        background: #ffffff !important; 
        transition: all 0.2s ease !important;
        padding: 2px !important;
    }
    .fi-input-wrapper:focus-within {
        border-color: var(--bt-gold) !important;
        box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.12) !important;
        transform: translateY(-1px) !important;
    }
    .fi-fo-field-wrp-label { 
        font-weight: 700 !important; 
        color: var(--bt-navy) !important; 
        font-size: 0.85rem !important; 
        margin-bottom: 6px !important;
    }
    .fi-input {
        color: var(--bt-text) !important;
        font-weight: 500 !important;
    }
</style>

<script>
(function () {
    'use strict';

    /* ════════════════════════════════════════════════════
       BUILTECH ADMIN — 2026 UX Intelligence Layer
       1. HEIC image auto-conversion + compression
       2. Smart Back Button (clearly separate from Menu)
       3. Sidebar Menu toggle label (never confused w/ Back)
       4. Row action buttons always forced visible
       5. Smooth page enter animation
    ════════════════════════════════════════════════════ */

    // ── 1. Image Engine Removed (Caused FilePond crash) ──────────────
    // We will let Filament's native FileUpload handle image processing
    // to prevent Alpine.js crashes.

    // ── 2. Smart Back Button ─────────────────────────
    // Renders a labeled "← Back to List" pill directly above the page <h1>.
    // Placement: in the breadcrumb/header zone, NOT the topbar.
    // This is COMPLETELY separate from the sidebar ☰ toggle.
    function addBackButton() {
        if (document.querySelector('.bt-back-btn')) return;
        var url = window.location.href;
        var isSubPage = url.includes('/create') || /\/\d+(?:\/edit)?$/.test(url);
        if (!isSubPage) return;

        // Find the page heading text itself
        var heading = document.querySelector('h1.fi-header-heading, h1[class*="fi-header"]');
        if (!heading) return;

        // Build the Back pill: arrow icon + "Back to List" label
        var btn = document.createElement('button');
        btn.className = 'bt-back-btn';
        btn.setAttribute('aria-label', 'Back to list');
        btn.title = 'Back to list';
        btn.innerHTML = [
            '<svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke-width="2.8" stroke="currentColor">',
            '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>',
            '</svg>',
            '<span class="bt-back-label">Back to List</span>'
        ].join('');

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (window.history.length > 1) { window.history.back(); }
            else {
                var base = url.replace(/\/create$/, '').replace(/\/\d+(?:\/edit)?$/, '');
                window.location.href = base;
            }
        });

        // Safe insertion: Place it INSIDE the <h1>, right before the text.
        // This completely avoids breaking Filament's responsive header layout.
        heading.style.display = 'inline-flex';
        heading.style.alignItems = 'center';
        heading.style.gap = '16px';
        heading.insertBefore(btn, heading.firstChild);
    }

    // ── 3. Style sidebar toggle as distinct "hamburger" ──────
    // Permanently marks it as the menu icon with a tooltip.
    // The user will NEVER mistake it for the Back button because:
    //   - It lives in the TOP LEFT corner of the topbar
    //   - It shows 3 horizontal lines (☰ hamburger icon)
    //   - It shows a "Menu" tooltip on hover
    //   - The Back button lives in the PAGE CONTENT area beside the h1
    function labelMenuToggle() {
        var topbarStart = document.querySelector('.fi-topbar-start');
        if (!topbarStart) return;
        topbarStart.querySelectorAll('button').forEach(function (btn) {
            if (btn.dataset.btMenuDone) return;
            btn.dataset.btMenuDone = '1';
            btn.title = 'Expand / Collapse menu';
            btn.setAttribute('aria-label', 'Toggle navigation menu');
        });
    }

    // ── 4. Force action cells to always be visible ──
    // Ensures Edit / Delete / View never get hidden by overflow.
    function fixActionCells() {
        var rows = document.querySelectorAll('.fi-ta-row');
        rows.forEach(function (row) {
            var cells = row.querySelectorAll('td');
            if (!cells.length) return;
            var last = cells[cells.length - 1];
            last.style.whiteSpace = 'nowrap';
            last.style.minWidth = 'fit-content';
            last.querySelectorAll('a, button').forEach(function (el) {
                el.style.whiteSpace = 'nowrap';
                el.style.display = 'inline-flex';
                el.style.alignItems = 'center';
            });
        });
    }

    // ── 5. Smooth page enter animation ──────────────
    function pageAnimation() {
        var main = document.querySelector('.fi-main');
        if (main && !main.dataset.btAnimated) {
            main.dataset.btAnimated = '1';
            main.style.opacity = '0';
            main.style.transform = 'translateY(8px)';
            main.style.transition = 'opacity 0.38s ease, transform 0.38s ease';
            requestAnimationFrame(function () {
                main.style.opacity = '1';
                main.style.transform = 'translateY(0)';
            });
        }
    }

    // ── Run all ──────────────────────────────────────
    function runAll() {
        addBackButton();
        labelMenuToggle();
        fixActionCells();
    }

    document.addEventListener('DOMContentLoaded', function () {
        pageAnimation();
        runAll();
    });

    // Re-run after Livewire navigation (SPA mode)
    document.addEventListener('livewire:navigated', runAll);
    document.addEventListener('livewire:load', runAll);

    // Watch for dynamic DOM changes (Livewire re-renders)
    var observer = new MutationObserver(function () { runAll(); });
    document.addEventListener('DOMContentLoaded', function () {
        observer.observe(document.body, { childList: true, subtree: true });
    });

})();
</script>

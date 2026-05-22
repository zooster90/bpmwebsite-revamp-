@extends('layouts.app')

@section('title', 'Builtech Enterprise Admin | Premium Portal')

@section('styles')
<style>
    /* --- PREMIUM ENTERPRISE COLOR PALETTE & VARIABLES --- */
    :root {
        --brand-gold: #D4AF37;
        --brand-gold-hover: #B8962E;
        --brand-gold-light: #FDFBF7;
        --brand-gold-alpha: rgba(212, 175, 55, 0.15);
        
        --bg-main: #F1F5F9;
        --bg-card: #FFFFFF;
        
        --sidebar-bg: #020617;
        --sidebar-hover: #1E293B;
        --sidebar-active-bg: rgba(212, 175, 55, 0.1);
        --sidebar-border: #1E293B;
        
        --text-main: #334155; 
        --text-heading: #0F172A;
        --text-muted: #64748B; 
        
        --border-color: #E2E8F0;
        --border-focus: #CBD5E1;
        
        --success: #059669;
        --success-bg: #ECFDF5;
        --danger: #DC2626;
        --danger-bg: #FEF2F2;
        --warning: #D97706; 
        --warning-bg: #FFFBEB;
        --info: #2563EB;
        --info-bg: #EFF6FF;
        
        --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        --shadow-modal: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        --font-body: 'Inter', sans-serif;
        --font-heading: 'Plus Jakarta Sans', sans-serif;
    }
    
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body { 
        font-family: var(--font-body); 
        background: var(--bg-main); 
        color: var(--text-main); 
        display: flex; 
        min-height: 100vh; 
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-size: 0.925rem;
    }

    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: var(--bg-main); }
    ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    
    h1, h2, h3, h4, h5, h6 { 
        color: var(--text-heading); 
        font-family: var(--font-heading); 
        font-weight: 700; 
        letter-spacing: -0.01em; 
    }
    
    /* --- ENTERPRISE SIDEBAR --- */
    .sidebar { 
        width: 260px; 
        background: var(--sidebar-bg); 
        color: #fff; 
        position: fixed; 
        height: 100vh; 
        overflow-y: auto; 
        transition: transform var(--transition); 
        z-index: 10001; 
        border-right: 1px solid var(--sidebar-border);
        display: flex; 
        flex-direction: column; 
    }

    .sidebar::-webkit-scrollbar { display: none; }
    .sidebar { -ms-overflow-style: none; scrollbar-width: none; }

    .sidebar-header { 
        padding: 1.5rem; text-align: left; position: sticky; top: 0; 
        background: var(--sidebar-bg); z-index: 10; border-bottom: 1px solid var(--sidebar-border); 
        display: flex; align-items: center; gap: 12px; 
    }
    .sidebar-logo {
        width: 40px; height: 40px; border-radius: 10px; object-fit: contain; background: #fff; box-shadow: 0 4px 10px rgba(212, 175, 55, 0.2);
    }
    .sidebar-header .logo-placeholder { 
        width: 40px; height: 40px; background: linear-gradient(135deg, var(--brand-gold), #A68A2C); 
        border-radius: 10px; display: flex; align-items: center; justify-content: center; 
        font-weight: bold; font-family: 'Playfair Display', serif; font-size: 1.25rem; color: #111;
        box-shadow: 0 4px 10px rgba(212, 175, 55, 0.2);
    }
    .sidebar-header h2 { font-size: 1.2rem; color: #fff; font-family: var(--font-heading); font-weight: 800; margin: 0; }
    .sidebar-header p { color: #94A3B8; font-size: 0.7rem; margin-top: 2px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
    
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(2, 6, 23, 0.6);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 10000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }
    .mobile-close-btn {
        display: none;
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.5rem;
        cursor: pointer;
        margin-left: auto;
        transition: var(--transition);
    }
    .mobile-close-btn:hover {
        color: var(--danger);
    }

    .sidebar-menu { padding: 1.5rem 1rem; flex: 1; display: flex; flex-direction: column; gap: 4px; }
    .sidebar-menu-label { color: #475569; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin: 1rem 0 0.5rem 0.75rem; }
    .sidebar-menu a { 
        display: flex; align-items: center; padding: 0.75rem 1rem; color: #94A3B8; 
        text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: var(--transition); 
        border-radius: var(--radius-sm); border: 1px solid transparent; 
    }
    .sidebar-menu a:hover { background: var(--sidebar-hover); color: #fff; }
    .sidebar-menu a.active { 
        background: var(--sidebar-active-bg); color: var(--brand-gold); 
        font-weight: 600; border-color: rgba(212, 175, 55, 0.2); 
    }
    .sidebar-menu i { width: 20px; font-size: 1rem; margin-right: 12px; text-align: center; }
    .sidebar-menu a:hover i { color: #fff; }
    .sidebar-menu a.active i { color: var(--brand-gold); }
    
    /* --- MAIN CONTENT & STICKY NAV --- */
    .main-wrapper {
        margin-left: 260px;
        width: calc(100% - 260px);
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        transition: margin-left var(--transition);
    }

    .admin-nav { 
        background: rgba(255, 255, 255, 0.8); 
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 1rem 2rem; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        border-bottom: 1px solid var(--border-color); 
        position: sticky; 
        top: 0; 
        z-index: 10000; 
    }

    .sidebar-toggle-btn { display: none; background: none; border: none; font-size: 1.25rem; color: var(--text-heading); cursor: pointer; transition: color 0.2s; }
    .sidebar-toggle-btn:hover { color: var(--brand-gold); }
    
    .nav-actions { display: flex; align-items: center; gap: 1rem; }
    
    .btn-icon-nav {
        background: #fff; border: 1px solid var(--border-color); width: 38px; height: 38px; 
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        color: var(--text-muted); cursor: pointer; transition: var(--transition);
        box-shadow: var(--shadow-xs);
    }
    .btn-icon-nav:hover { background: var(--bg-main); color: var(--text-heading); border-color: var(--border-focus); transform: translateY(-1px);}

    .user-greeting { font-weight: 500; color: var(--text-heading); font-size: 0.9rem; display: flex; align-items: center; gap: 0.8rem; border-left: 1px solid var(--border-color); padding-left: 1rem; margin-left: 0.5rem; }
    .logout-btn { color: var(--danger); background: none; border: none; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: var(--transition); padding: 0.5rem; border-radius: var(--radius-sm);}
    .logout-btn:hover { background: var(--danger-bg); }
    
    .page-content { padding: 2rem; flex: 1 0 auto; max-width: 1600px; margin: 0 auto; width: 100%; position: relative;}
    
    .page { display: none; opacity: 0; animation: none; }
    .page.active { display: block; opacity: 1; animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* --- HEADERS & DASHBOARD BANNER --- */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h1 { font-size: 1.75rem; margin-bottom: 0.2rem; color: var(--text-heading); }
    .helper-text { display: block; font-size: 0.9rem; color: var(--text-muted); font-weight: 400; line-height: 1.5;}
    
    .dashboard-banner {
        background: linear-gradient(135deg, var(--sidebar-bg) 0%, #1E293B 100%);
        color: white;
        padding: 2.5rem;
        border-radius: var(--radius-md);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .dashboard-banner::after {
        content: ''; position: absolute; right: 0; top: 0; width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,0.1));
        z-index: 1;
    }
    .dashboard-banner::before {
        content: '\f085'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: -20px; bottom: -40px; font-size: 12rem; color: rgba(255,255,255,0.03); z-index: 0; transform: rotate(-15deg);
    }
    .dashboard-banner h1 { color: white; font-size: 2rem; margin-bottom: 0.5rem; position: relative; z-index: 2;}
    .dashboard-banner p { color: #94A3B8; font-size: 1rem; max-width: 600px; position: relative; z-index: 2; font-weight: 400; }
    .dashboard-date { text-align: right; position: relative; z-index: 2; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 2.5rem;}
    .dashboard-date strong { display: block; font-size: 2.25rem; color: var(--brand-gold); line-height: 1; font-family: var(--font-heading);}
    .dashboard-date span { color: #CBD5E1; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-top: 0.5rem; display: block;}
    
    /* --- ALERTS & CONTROLS --- */
    .info-alert { background: var(--info-bg); color: #1E40AF; padding: 1rem 1.25rem; border-radius: var(--radius-sm); font-size: 0.9rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.75rem; border: 1px solid #BFDBFE; line-height: 1.5;}
    .info-alert i { font-size: 1.1rem; color: var(--info); margin-top: 2px;}
    
    .control-bar { background: var(--bg-card); padding: 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); margin-bottom: 1.5rem; display:flex; flex-wrap:wrap; gap:1rem; align-items:center; box-shadow: var(--shadow-sm); }
    .control-input, .control-select { 
        padding: 0.65rem 1rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); 
        font-size: 0.9rem; font-family: inherit; background: #F8FAFC; transition: var(--transition); color: var(--text-heading); outline: none; 
    }
    .control-input { flex: 1; min-width: 250px; }
    .control-select { min-width: 180px; cursor: pointer; }
    .control-input:focus, .control-select:focus { background: #fff; border-color: var(--brand-gold); box-shadow: 0 0 0 3px var(--brand-gold-alpha); }
    
    /* --- BUTTONS --- */
    .add-btn { background: var(--sidebar-bg); color: #fff; border: 1px solid transparent; padding: 0.65rem 1.25rem; border-radius: var(--radius-sm); font-family: inherit; font-size: 0.9rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; transition: var(--transition); box-shadow: var(--shadow-sm); }
    .add-btn:hover { background: var(--sidebar-hover); transform: translateY(-1px); box-shadow: var(--shadow-md); }
    .add-btn.gold { background: var(--brand-gold); color: #fff; }
    .add-btn.gold:hover { background: var(--brand-gold-hover); }
    
    .btn-edit, .btn-delete, .btn-view { padding: 0.4rem 0.8rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); cursor: pointer; font-weight: 600; font-size: 0.8rem; font-family: inherit; transition: var(--transition); display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; background: #fff; color: var(--text-main); }
    .btn-edit:hover { border-color: var(--info); color: var(--info); background: var(--info-bg); }
    .btn-delete:hover:not(:disabled) { border-color: var(--danger); color: var(--danger); background: var(--danger-bg); }
    .btn-view:hover { border-color: var(--brand-gold); color: var(--brand-gold-hover); background: var(--brand-gold-light); }
    
    /* --- DATA ROWS (Replacing Bulky Cards) --- */
    .year-group { margin-bottom: 2rem; }
    .year-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; background: transparent; border-bottom: 2px solid var(--border-color); cursor: pointer; user-select: none; transition: var(--transition); margin-bottom: 1rem; }
    .year-header:hover { border-color: var(--border-focus); }
    .year-header h3 { margin: 0; font-size: 1.1rem; display: flex; align-items: center; gap: 1rem; color: var(--text-heading); font-family: var(--font-heading);}
    .year-header .toggle-icon { transition: transform 0.3s ease; color: var(--text-muted); font-size: 1rem; }
    .year-content { transition: all 0.3s ease; display: flex; flex-direction: column; gap: 0.75rem;}
    .year-group.collapsed .year-content { display: none; }
    .year-group.collapsed .toggle-icon { transform: rotate(180deg); }

    .item-row { 
        background: var(--bg-card); 
        padding: 1rem; 
        border-radius: var(--radius-sm); 
        box-shadow: var(--shadow-sm); 
        border: 1px solid var(--border-color); 
        border-left: 4px solid var(--border-color); 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        transition: var(--transition); 
        gap: 1.5rem; 
    }
    .item-row:hover { border-color: var(--border-focus); box-shadow: var(--shadow-md); transform: translateY(-1px); z-index: 2;}
    
    .list-item-content { display:flex; gap: 1.25rem; flex:1; align-items:center; }
    
    .list-thumbnail { 
        width: 80px; height: 60px; border-radius: 4px; object-fit: cover; border: 1px solid rgba(0,0,0,0.05); 
        cursor: zoom-in; flex-shrink: 0; background-color: var(--bg-main);
    }
    .empty-thumbnail { width: 80px; height: 60px; border-radius: 4px; background: #F8FAFC; border: 1px dashed #CBD5E1; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #94A3B8; font-size: 1.25rem; }
    
    .item-info { flex: 1; min-width: 0; } /* min-width 0 allows text truncation */
    .item-info h4 { font-size: 1.05rem; color: var(--text-heading); margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 0.5rem;}
    .item-info p { font-size: 0.85rem; color: var(--text-muted); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 0.5rem;}
    
    .actions { display: flex; gap: 0.5rem; flex-shrink: 0;}
    
    .badge { font-size: 0.7rem; font-weight: 700; padding: 0.25rem 0.6rem; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge.solid { background: var(--sidebar-bg); color: #fff; }
    .badge.success { background: var(--success-bg); color: var(--success); }
    .badge.danger { background: var(--danger-bg); color: var(--danger); }
    .badge.warning { background: var(--warning-bg); color: var(--warning); }
    .badge.info { background: var(--info-bg); color: var(--info); }
    .badge.gold { background: var(--brand-gold-light); color: var(--brand-gold-hover); border: 1px solid var(--brand-gold); }
    
    /* --- MODALS --- */
    .modal { display: none; position: fixed; inset: 0; background: rgba(2, 6, 23, 0.6); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 20000; opacity: 0; transition: opacity 0.2s ease; padding: 1rem; }
    .modal.show { display: flex; opacity: 1; }
    .modal-content { 
        background: #fff; width: min(100%, 800px); border-radius: var(--radius-md); 
        display: flex; flex-direction: column; max-height: 90vh; 
        box-shadow: var(--shadow-modal); transform: scale(0.98); 
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1); 
    }
    .modal.show .modal-content { transform: scale(1); }
    
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color); background: #fff; border-radius: var(--radius-md) var(--radius-md) 0 0; flex-shrink: 0;}
    .modal-header h2 { font-size: 1.4rem; margin: 0; color: var(--text-heading); }
    .modal-close { background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted); transition: var(--transition); display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; }
    .modal-close:hover { background: var(--danger-bg); color: var(--danger); }
    
    .modal-form { display: flex; flex-direction: column; flex: 1; min-height: 0; overflow: hidden; }
    .modal-body { padding: 2rem; overflow-y: auto; flex: 1; min-height: 0; }
    .modal-actions { display: flex; justify-content: flex-end; gap: 0.75rem; padding: 1.25rem 2rem; border-top: 1px solid var(--border-color); background: #F8FAFC; border-radius: 0 0 var(--radius-md) var(--radius-md); flex-shrink: 0;}

    /* Form Fields */
    .form-row { display: flex; gap: 1.5rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
    .form-row .form-group { margin-bottom: 0; }
    .form-group.half { flex: 1; min-width: 200px; }
    .form-group { margin-bottom: 1.25rem; width: 100%; }
    .form-group label { display: block; font-weight: 600; font-size: 0.85rem; color: var(--text-heading); margin-bottom: 0.5rem; }
    .form-group label .required { color: var(--danger); font-weight: bold; margin-left: 2px; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.95rem; font-family: inherit; background: #fff; transition: var(--transition); color: var(--text-heading); line-height: 1.5; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--brand-gold); box-shadow: 0 0 0 3px var(--brand-gold-alpha); }
    .form-group input[readonly], .form-group textarea[readonly] { background: #F8FAFC; color: var(--text-muted); cursor: not-allowed; }
    
    .settings-panel { background: #F8FAFC; padding: 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); margin-bottom: 1.5rem; }
    .settings-panel h4 { font-size: 1rem; color: var(--text-heading); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .settings-panel .toggle-row { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius-sm); cursor: pointer; transition: var(--transition); margin-top: 0.75rem; }
    .settings-panel .toggle-row:hover { border-color: var(--border-focus); }
    .settings-panel .toggle-row input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--brand-gold); cursor: pointer; margin: 0;}
    .settings-panel .toggle-row span { font-size: 0.9rem; color: var(--text-heading); }

    .save-btn { background: var(--sidebar-bg); color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: var(--transition); display: flex; align-items: center; gap: 0.5rem; }
    .save-btn:hover:not(:disabled) { background: var(--brand-gold); }
    .save-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .cancel-btn { background: #fff; border: 1px solid var(--border-focus); color: var(--text-main); padding: 0.75rem 1.5rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: var(--transition); }
    .cancel-btn:hover { background: #F1F5F9; color: var(--text-heading); }
    
    /* --- UPLOAD COMPONENTS --- */
    .drag-area { border: 2px dashed var(--border-focus); border-radius: var(--radius-sm); padding: 2rem; text-align: center; cursor: pointer; background: #F8FAFC; transition: var(--transition); margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center;}
    .drag-area:hover, .drag-area.drag-over { background: var(--brand-gold-light); border-color: var(--brand-gold); }
    .drag-area i { font-size: 2rem; color: #94A3B8; margin-bottom: 1rem; transition: var(--transition); }
    .drag-area:hover i { color: var(--brand-gold); transform: scale(1.1); }
    
    .preview-container { display: flex; flex-wrap: wrap; gap: 1rem; min-height: 10px; padding: 10px 0; border-radius: var(--radius-sm); }
    .preview-box { position: relative; width: 100px; height: 100px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); overflow: hidden; background: #fff; cursor: grab; box-shadow: var(--shadow-xs); transition: var(--transition);}
    .preview-box .img-wrapper { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #F1F5F9; }
    .preview-box .img-wrapper img { max-width: 100%; max-height: 100%; object-fit: cover; pointer-events: auto; cursor: zoom-in; }
    .preview-box:hover { border-color: var(--brand-gold); transform: translateY(-2px);}
    .small-image-fix .img-wrapper img { object-fit: contain !important; padding: 8px; }
    .remove-btn { position: absolute; top: 4px; right: 4px; background: rgba(220, 38, 38, 0.9); color: white; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 12px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: var(--transition);}
    .remove-btn:hover { background: #991B1B; transform: scale(1.1);}
    
    /* --- TOASTS & DASHBOARD STATS --- */
    .toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 100000; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
    .toast { background: white; border-left: 4px solid var(--success); padding: 1rem 1.25rem; box-shadow: var(--shadow-lg); border-radius: var(--radius-sm); display: flex; align-items: center; gap: 12px; font-weight: 600; font-size: 0.9rem; color: var(--text-heading); animation: slideIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; pointer-events: auto; border: 1px solid var(--border-color); border-left-width: 4px; min-width: 250px;}
    .toast.error { border-left-color: var(--danger); }
    .toast.info { border-left-color: var(--info); }
    .toast i { font-size: 1.2rem; }
    .toast.success i { color: var(--success); }
    .toast.error i { color: var(--danger); }
    .toast.info i { color: var(--info); }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
    .dashboard-content-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem; }
    .stats-header { font-size: 1.15rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; color: var(--text-heading); }
    .stats-header i { color: var(--brand-gold); }
    .dashboard-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
    
    .stat-card { background: #fff; padding: 1.5rem; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; transition: var(--transition); }
    .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); border-color: var(--border-focus); }
    .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--text-heading); line-height: 1; margin-bottom: 0.5rem; z-index: 2; position: relative; font-family: var(--font-heading);}
    .stat-card p { color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0; z-index: 2; position: relative; }
    .stat-icon-bg { position: absolute; right: -10px; bottom: -15px; font-size: 5rem; color: #F8FAFC; z-index: 1; transform: rotate(-10deg); transition: var(--transition); }
    .stat-card:hover .stat-icon-bg { transform: rotate(0) scale(1.05); color: #F1F5F9;}
    
    .action-grid { display: grid; grid-template-columns: 1fr; gap: 1rem; }
    .action-card { background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 1.25rem; cursor: pointer; transition: var(--transition); display: flex; align-items: center; gap: 1rem; color: var(--text-heading); box-shadow: var(--shadow-sm); }
    .action-card:hover { border-color: var(--brand-gold); background: var(--brand-gold-light); transform: translateY(-2px); }
    .action-card i { font-size: 1.5rem; color: var(--brand-gold); background: #fff; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--brand-gold-alpha); }
    .action-card span { font-weight: 700; font-size: 1rem; display: block; }
    .action-card p { font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem; }
    
    .loading-spinner { text-align: center; padding: 4rem 1rem; color: var(--text-muted); }
    .loading-spinner i { font-size: 2.5rem; color: #CBD5E1; margin-bottom: 1rem; animation: spin 1s linear infinite; }
    @keyframes spin { 100% { transform: rotate(360deg); } }
    
    .highlight-item { animation: pulseSuccess 2s ease-out forwards !important; }
    @keyframes pulseSuccess {
        0% { background: #FEF9C3; border-color: var(--brand-gold); }
        100% { background: var(--bg-card); border-color: var(--border-color); }
    }

    /* Icon Picker Modal Styles */
    .icon-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); gap: 10px; margin-top: 1rem; max-height: 400px; overflow-y: auto; padding: 4px;}
    .icon-item { background: #F8FAFC; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 15px 10px; text-align: center; cursor: pointer; transition: var(--transition); color: var(--text-main); font-size: 1.5rem;}
    .icon-item:hover { background: var(--brand-gold-light); border-color: var(--brand-gold); color: var(--brand-gold); transform: translateY(-2px);}
    .icon-item span { display: block; font-size: 0.65rem; margin-top: 8px; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}

    /* Bulk Selection UI Enhancements */
    .select-mode-active .bulk-cb { display: block !important; }
    .select-mode-active .action-btn { display: none !important; }
    .select-mode-active .item-row { cursor: pointer; }
    .select-mode-active .item-row:hover { border-color: var(--danger); box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2); }
    .bulk-cb { width: 20px; height: 20px; margin-right: 1.25rem; accent-color: var(--danger); cursor: pointer; flex-shrink: 0;}

    @media (max-width: 1024px) {
        .sidebar { transform: translateX(-100%); z-index: 10001; }
        .sidebar.open { transform: translateX(0); box-shadow: var(--shadow-modal); }
        .main-wrapper { margin-left: 0; width: 100%; }
        .sidebar-toggle-btn { display: block; }
        .dashboard-content-layout { grid-template-columns: 1fr; }
        .dashboard-banner { flex-direction: column; align-items: flex-start; gap: 1.5rem; padding: 1.5rem;}
        .dashboard-date { text-align: left; border-left: none; padding-left: 0; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem; width: 100%;}
        .mobile-close-btn { display: block; }
        .sidebar-header { padding-right: 1.5rem; }
    }
    
    @media (max-width: 768px) {
        .form-row { flex-direction: column; gap: 0; }
        .form-group.half { width: 100%; }
        .dashboard-grid { grid-template-columns: 1fr; }
        .item-row { flex-direction: column; align-items: flex-start; padding: 1.25rem; }
        .list-item-content { flex-direction: column; align-items: stretch; width: 100%; gap: 1rem; }
        .list-thumbnail, .empty-thumbnail { width: 100%; height: 150px; }
        .actions { width: 100%; justify-content: stretch; margin-top: 1rem; border-top: 1px solid var(--border-color); padding-top: 1rem;}
        .actions button { flex: 1; justify-content: center; }
        .modal-body { padding: 1.5rem; }
        .control-bar { flex-direction: column; align-items: stretch;}
        
        /* Mobile specific fixes for Selection UI */
        .select-mode-active .list-item-content { flex-direction: row; align-items: center; }
    }
  </style>
@endsection

@section('content')

  <div id="securityGateOverlay" style="position:fixed; inset:0; background:var(--sidebar-bg); z-index:999999; display:flex; flex-direction:column; align-items:center; justify-content:center; color:white;">
      <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 3rem; color: var(--brand-gold); margin-bottom: 1.5rem;" aria-hidden="true"></i>
      <h2 style="font-family: var(--font-heading); font-weight: 700; color: white; font-size: 1.25rem; letter-spacing: 1px;">Authenticating Securely...</h2>
  </div>

  <script>
  async function checkSecurityGate() {
        const SUPABASE_URL = 'https://guvifomiadxehmtrqrfu.supabase.co';
        const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imd1dmlmb21pYWR4ZWhtdHJxcmZ1Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzMxMDc1MjUsImV4cCI6MjA4ODY4MzUyNX0.8gy3oPTSwPXCZHAi0FbmpjkIrHQuZmWd_TE-h-L0gD8'; 
        
        if (typeof supabase === 'undefined') {
            window.location.href = 'login.html';
            return;
        }
        
        window.supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_ANON_KEY);
        const gateClient = window.supabaseClient;
        
        gateClient.auth.onAuthStateChange((event, session) => {
            if (event === 'SIGNED_OUT' || !session) {
                sessionStorage.clear();
                window.location.href = 'login.html';
            }
        });

        try {
            const { data: { session }, error: authError } = await gateClient.auth.getSession();

            if (authError || !session) {
                sessionStorage.clear();
                window.location.href = 'login.html';
                return;
            }

            const { data: userRole, error: roleError } = await gateClient
                .from('user_roles')
                .select('role')
                .eq('user_id', session.user.id)
                .maybeSingle();

            if (roleError || !userRole || userRole.role !== 'admin') {
                alert("Access Denied: You do not have administrator privileges.");
                await gateClient.auth.signOut();
                sessionStorage.clear();
                window.location.href = 'login.html';
                return;
            }

            sessionStorage.setItem('builtech_auth', 'true');
            sessionStorage.setItem('builtech_user', JSON.stringify(session.user));
            
            document.getElementById('securityGateOverlay').style.display = 'none';
            document.getElementById('userGreeting').textContent = session.user.email.split('@')[0];
            console.log("%c[Security] Administrator Access Granted", "color: #059669; font-weight: bold;");

        } catch (err) {
            console.error("Security Gate Error:", err);
            window.location.href = 'login.html';
        }
    }
    checkSecurityGate();
  </script>

  <div id="toastContainer" class="toast-container"></div>
    
  <div id="lightboxModal" style="display:none; position:fixed; z-index:1000000; inset:0; background:rgba(2, 6, 23, 0.9); backdrop-filter:blur(8px); align-items:center; justify-content:center; flex-direction:column; opacity: 0; transition: opacity 0.2s ease;">
      <button onclick="closeLightbox()" style="position:absolute; top:20px; right:30px; background:rgba(255,255,255,0.1); border-radius:50%; width:40px; height:40px; border:none; color:white; font-size:1.5rem; cursor:pointer; z-index: 10; transition: background 0.2s;"><i class="fas fa-times"></i></button>
      <img id="lightboxImg" src="" style="max-width:90%; max-height:85vh; border-radius:8px; box-shadow:var(--shadow-modal); object-fit:contain; border: 1px solid rgba(255,255,255,0.1); background: #fff;" alt="Lightbox image">
  </div>
  
  <div id="customConfirmModal" class="modal" style="z-index: 9999999;">
      <div class="modal-content" style="max-width: 400px; text-align: center; padding: 2.5rem 2rem;">
          <div style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"><i class="fas fa-exclamation-triangle"></i></div>
          <h2 id="confirmTitle" style="margin-bottom: 0.5rem; font-size: 1.4rem;">Are you sure?</h2>
          <p id="confirmMessage" style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem; line-height: 1.5;">This action cannot be undone.</p>
          <div style="display: flex; gap: 1rem; justify-content: center;">
              <button id="confirmCancelBtn" class="cancel-btn" style="flex: 1;">Cancel</button>
              <button id="confirmActionBtn" class="save-btn" style="flex: 1; background: var(--danger); justify-content: center;"><i class="fas fa-trash"></i> Delete</button>
          </div>
      </div>
  </div>

  <div id="sidebarOverlay" class="sidebar-overlay"></div>

  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('/img/images/61da7874-55a9-46d1-b71c-32ddac2a7740.png') }}" alt="Logo" class="sidebar-logo">
      <div>
        <h2>We Built to Last</h2>
        <p>Enterprise Portal</p>
      </div>
      <button id="mobileSidebarClose" class="mobile-close-btn" aria-label="Close Sidebar"><i class="fas fa-times"></i></button>
    </div>
    <nav class="sidebar-menu">
      <div class="sidebar-menu-label">Overview</div>
      <a href="#" class="active" data-page="dashboard"><i class="fas fa-home"></i> Dashboard</a>
      
      <div class="sidebar-menu-label">Portfolio</div>
      <a href="#" data-page="projects"><i class="fas fa-building"></i> All Projects</a>
      <a href="#" data-page="current-projects"><i class="fas fa-star" style="color: var(--brand-gold);"></i> Flagship / Featured</a>
      
      <div class="sidebar-menu-label">Company</div>
      <a href="#" data-page="awards"><i class="fas fa-trophy"></i> Awards</a>
      <a href="#" data-page="certifications"><i class="fas fa-certificate"></i> Certifications</a>
      <a href="#" data-page="news"><i class="fas fa-newspaper"></i> News</a>
      <a href="#" data-page="press"><i class="fas fa-bullhorn"></i> Media Recognition</a>
      <a href="#" data-page="culture"><i class="fas fa-users"></i> Culture Events</a>
      <a href="#" data-page="careers"><i class="fas fa-briefcase"></i> Job Openings</a>
      
      <div class="sidebar-menu-label">Communications</div>
      <a href="#" data-page="inquiries"><i class="fas fa-envelope"></i> Active Inquiries</a>
      <a href="#" data-page="archived-inquiries"><i class="fas fa-archive"></i> Archived Inquiries</a>
    </nav>
  </aside>
  
  <main class="main-wrapper">
    <nav class="admin-nav">
      <div style="display:flex; align-items:center; gap:1rem">
        <button id="sidebarToggle" class="sidebar-toggle-btn"><i class="fas fa-bars"></i></button>
        <button class="btn-icon-nav" onclick="window.openIconModal()" title="Icon Library Helper"><i class="fas fa-icons"></i></button>
      </div>
      <div class="nav-actions">
        <a href="{{ url('/') }}" target="_blank" style="color:var(--text-main); text-decoration:none; font-weight:600; font-size: 0.85rem; border: 1px solid var(--border-color); padding: 0.5rem 1rem; border-radius: 20px; display: flex; align-items: center; gap: 0.5rem; transition: var(--transition);">
          <i class="fas fa-external-link-alt" style="color:var(--info);"></i> Live Site
        </a>
        <div style="width: 1px; height: 24px; background: var(--border-color); margin: 0 0.5rem;"></div>
        <div class="user-greeting">
            <div style="display: flex; flex-direction: column; line-height: 1.2; text-align: right;">
                <span id="userGreeting" style="font-weight: 700; font-size: 0.9rem;">Admin</span>
                <span style="font-size: 0.75rem; color: var(--text-muted);">System Administrator</span>
            </div>
            <i class="fas fa-user-circle" style="font-size: 2rem; color: #CBD5E1; margin-left: 8px;"></i> 
        </div>
        <button class="logout-btn" id="logoutButton" title="Sign Out"><i class="fas fa-sign-out-alt"></i></button>
      </div>
    </nav>
    
    <div class="page-content" id="mainContent">
      <div id="accessDenied" style="display:none; text-align: center; padding: 6rem 1rem;">
        <i class="fas fa-lock" style="font-size: 4rem; color: var(--danger); margin-bottom: 1.5rem;"></i>
        <h2 style="margin-bottom:1rem; font-size: 2rem;">Access Denied</h2>
        <p style="font-size:1rem; color:var(--text-muted); margin-bottom:2rem">You do not have administrative privileges to view this dashboard.</p>
        <button class="add-btn gold" id="accessDeniedLogout">Return to Login</button>
      </div>
      
      <div id="page-dashboard" class="page active">
        <div class="dashboard-banner">
            <div style="position: relative; z-index: 2;">
                <h1>Enterprise Control Center</h1>
                <p id="currentDateDisplay">System is fully operational.</p>
            </div>
            <div class="dashboard-date">
                <strong id="bannerDay">--</strong>
                <span id="bannerMonthYear">--</span>
            </div>
        </div>
        <div class="dashboard-content-layout">
            <div>
                <h3 class="stats-header"><i class="fas fa-chart-pie"></i> Performance Overview</h3>
                <div class="dashboard-grid">
                  <div class="stat-card">
                    <i class="fas fa-building stat-icon-bg"></i>
                    <div class="stat-number" id="totalProjects">0</div>
                    <p>Total Projects</p>
                  </div>
                  <div class="stat-card" style="border-left: 4px solid var(--success);">
                    <i class="fas fa-hard-hat stat-icon-bg"></i>
                    <div class="stat-number" style="color: var(--success);" id="ongoingProjects">0</div>
                    <p>Ongoing</p>
                  </div>
                  <div class="stat-card" style="border-left: 4px solid var(--info);">
                    <i class="fas fa-clock stat-icon-bg"></i>
                    <div class="stat-number" style="color: var(--info);" id="upcomingProjects">0</div>
                    <p>Upcoming</p>
                  </div>
                  <div class="stat-card" style="border-left: 4px solid var(--brand-gold);">
                    <i class="fas fa-trophy stat-icon-bg"></i>
                    <div class="stat-number" id="totalAwards">0</div>
                    <p>Total Awards</p>
                  </div>
                </div>
            </div>
            <div>
                <h3 class="stats-header"><i class="fas fa-bolt"></i> Quick Actions</h3>
                <div class="action-grid">
                  <div class="action-card" id="btnNewProject">
                      <i class="fas fa-folder-plus"></i>
                      <div>
                          <span>New Project</span>
                          <p>Add a construction record</p>
                      </div>
                  </div>
                  <div class="action-card" id="btnNewAward">
                      <i class="fas fa-award"></i>
                      <div>
                          <span>Add Award</span>
                          <p>Log a new achievement</p>
                      </div>
                  </div>
                  <div class="action-card" id="btnNewNews">
                      <i class="fas fa-newspaper"></i>
                      <div>
                          <span>Post News</span>
                          <p>Publish an announcement</p>
                      </div>
                  </div>
                  <div class="action-card" id="btnNewCulture">
                      <i class="fas fa-camera-retro"></i>
                      <div>
                          <span>Log Event</span>
                          <p>Add to company culture</p>
                      </div>
                  </div>
                </div>
            </div>
        </div>
      </div>

      <div id="page-projects" class="page">
        <div class="page-header">
            <div>
                <h1>Project Track Records</h1>
                <p class="helper-text">Manage all past and present construction projects here.</p>
            </div>
            <button class="add-btn gold" id="btnAddProjectPage"><i class="fas fa-plus"></i> Create Project</button>
        </div>
        <div class="info-alert">
            <i class="fas fa-lightbulb"></i>
            <div>Projects marked as "Completed" appear in your past projects portfolio. To highlight a project on the Main Homepage slider, edit it and check the <b>Flagship / Featured</b> settings.</div>
        </div>
        <div class="control-bar" style="flex-wrap: wrap; gap: 0.75rem;">
          <input type="text" id="projectSearch" class="control-input" oninput="debounceLoadProjects()" placeholder="Search projects by title or location..." style="flex: 2; min-width: 200px;" />
          <select id="projectCategoryFilter" class="control-select" onchange="loadProjects()" style="flex: 1; min-width: 180px;">
            <option value="">All Categories</option>
            <option value="High Rise">High Rise</option>
            <option value="Hospital">Hospital</option>
            <option value="Hotel">Hotel</option>
            <option value="Factory (Industrial Building Works)">Factory (Industrial Building Works)</option>
            <option value="Terrace, Semi-D &amp; Bungalow">Terrace, Semi-D &amp; Bungalow</option>
            <option value="Commercial Building">Commercial Building</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Civil &amp; Infrastructural Works">Civil &amp; Infrastructural Works</option>
            <option value="Government Building">Government Building</option>
            <option value="School">School</option>
            <option value="Sewerage Treatment Plant">Sewerage Treatment Plant</option>
            <option value="Pipes Laying &amp; Sewer Line">Pipes Laying &amp; Sewer Line</option>
            <option value="Interior Design, Furniture &amp; Renovation Works">Interior Design, Furniture &amp; Renovation Works</option>
            <option value="Landscaping Works">Landscaping Works</option>
            <option value="Pumping Station">Pumping Station</option>
            <option value="Mechanical &amp; Electrical Works">Mechanical &amp; Electrical Works</option>
          </select>
          <select id="projectStatusFilter" class="control-select" onchange="loadProjects()" style="flex: 1; min-width: 140px;">
            <option value="">All Statuses</option>
            <option value="Completed">Completed</option>
            <option value="Ongoing">Ongoing</option>
            <option value="Upcoming">Upcoming</option>
          </select>
        </div>
        <div id="projectList" class="list-container"></div>
      </div>

      <div id="page-awards" class="page">
        <div class="page-header">
            <div>
                <h1>Awards & Achievements</h1>
                <p class="helper-text">Add your company's awards and certificates.</p>
            </div>
            <button class="add-btn gold" id="btnAddAwardPage"><i class="fas fa-plus"></i> Add Award</button>
        </div>
        <div class="control-bar">
          <input type="text" id="awardSearch" class="control-input" oninput="debounceLoadAwards()" placeholder="Search awards..." />
        </div>
        <div id="awardList" class="list-container"></div>
      </div>

      <div id="page-news" class="page">
        <div class="page-header">
            <div>
                <h1>News & Updates</h1>
                <p class="helper-text">Post company announcements, project updates, and milestones.</p>
            </div>
            <button class="add-btn gold" id="btnAddNewsPage"><i class="fas fa-plus"></i> Post News</button>
        </div>
        
        <div class="control-bar" style="display: flex; justify-content: space-between; align-items: center;">
          <div style="display: flex; gap: 1rem; flex: 1;">
            <input type="text" id="newsSearch" class="control-input" oninput="debounceLoadNews()" placeholder="Search news titles..." style="max-width: 400px;"/>
            <select id="newsCategoryFilter" class="control-select" onchange="loadNews()">
                <option value="">All Categories</option>
                <option value="General">General</option>
                <option value="Milestone">Milestone</option>
                <option value="Project">Project Update</option>
                <option value="Award">Award</option>
                <option value="CSR">CSR Activity</option>
                <option value="Team">Team Activity</option>
            </select>
          </div>
          <button id="toggleSelectNewsBtn" class="cancel-btn" onclick="toggleNewsSelectMode()"><i class="fas fa-check-square"></i> Select Records</button>
        </div>
        
        <div id="newsBulkActions" style="display:none; margin-bottom: 1.5rem; background: var(--danger-bg); padding: 1rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--danger); justify-content: space-between; align-items: center; box-shadow: var(--shadow-sm);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <input type="checkbox" id="selectAllNewsCb" style="width: 20px; height: 20px; accent-color: var(--danger); cursor: pointer;" onchange="toggleSelectAllNews(this)">
                <label for="selectAllNewsCb" style="font-weight: 600; cursor: pointer; color: var(--danger);">Select All</label>
                <span id="newsSelectedCount" style="color: var(--danger); font-weight: 600; border-left: 2px solid rgba(220, 38, 38, 0.3); padding-left: 1rem; margin-left: 0.5rem;">0 records selected</span>
            </div>
            <div>
                <button class="cancel-btn" style="border-color: transparent; background: transparent; color: var(--text-muted); margin-right: 0.5rem;" onclick="toggleNewsSelectMode()">Cancel</button>
                <button class="save-btn" style="background: var(--danger); border: none;" onclick="bulkDeleteNews()"><i class="fas fa-trash"></i> Delete Selected</button>
            </div>
        </div>
        
        <div id="newsList" class="list-container"></div>
      </div>

      <div id="page-press" class="page">
        <div class="page-header">
            <div>
                <h1>Media Recognition</h1>
                <p class="helper-text">Manage newspaper and media features.</p>
            </div>
            <button class="add-btn gold" id="btnAddPressPage"><i class="fas fa-plus"></i> Add Media Clipping</button>
        </div>
        <div class="info-alert">
            <i class="fas fa-star" style="color: var(--warning);"></i>
            <div>If you select "Feature on Homepage", this press clipping will be displayed prominently on the main page.</div>
        </div>
        <div class="control-bar">
          <input type="text" id="pressSearch" class="control-input" oninput="debounceLoadPress()" placeholder="Search publications or headlines..." />
        </div>
        <div id="press-list" class="list-container"></div>
      </div>

      <div id="page-culture" class="page">
        <div class="page-header">
            <div>
                <h1>Culture Events</h1>
                <p class="helper-text">Company trips, festive dinners, and team building activities.</p>
            </div>
            <button class="add-btn gold" id="btnAddCulturePage"><i class="fas fa-plus"></i> Add Event</button>
        </div>
        <div class="control-bar">
          <input type="text" id="cultureSearch" class="control-input" oninput="debounceLoadCulture()" placeholder="Search event name..." />
          <select id="cultureYearFilter" class="control-select" onchange="loadCulture()">
            <option value="">All Years</option>
          </select>
          <select id="cultureTypeFilter" class="control-select" onchange="loadCulture()">
            <option value="">All Categories</option>
            <option value="festive">Festive</option>
            <option value="csr">CSR</option>
            <option value="tb">Team Building</option>
            <option value="trip">Company Trips</option>
            <option value="work">Work / Milestone</option>
            <option value="training">Training</option>
            <option value="intern">Intern</option>
            <option value="sponsor">Sponsorship</option>
          </select>
        </div>
        <div id="cultureList" class="list-container"></div>
        <div id="cultureEmpty" style="text-align:center; padding:4rem 0; color:var(--text-muted); display:none; background: var(--bg-card); border-radius: var(--radius-sm); border: 2px dashed #CBD5E1;">
          <h3 style="font-size: 1.2rem; font-weight: 500;">No events found</h3>
        </div>
      </div>

      <div id="page-certifications" class="page">
        <div class="page-header">
            <div>
                <h1>Certifications</h1>
                <p class="helper-text">Manage technical certifications like CIDB, SHASSIC, and GBI.</p>
            </div>
        </div>
        <div class="control-bar" style="justify-content: flex-start; gap: 0.75rem;">
          <button class="add-btn" onclick="CertificationManager.create('cidb_star_ratings')" style="background: #fff; color: var(--text-heading); border: 1px solid var(--border-color);"><i class="fas fa-plus" style="color: var(--brand-gold);"></i> CIDB Rating</button>
          <button class="add-btn" onclick="CertificationManager.create('shassic_scores')" style="background: #fff; color: var(--text-heading); border: 1px solid var(--border-color);"><i class="fas fa-plus" style="color: var(--success);"></i> SHASSIC Score</button>
          <button class="add-btn" onclick="CertificationManager.create('gbi_facilitator_certificates')" style="background: #fff; color: var(--text-heading); border: 1px solid var(--border-color);"><i class="fas fa-plus" style="color: var(--success);"></i> GBI Cert</button>
          <button class="add-btn" onclick="CertificationManager.create('qlassic_conquas_scores')" style="background: #fff; color: var(--text-heading); border: 1px solid var(--border-color);"><i class="fas fa-plus" style="color: var(--info);"></i> QLASSIC/CONQUAS</button>
        </div>
        <div id="certificationsList"></div>
      </div>

      <div id="page-inquiries" class="page">
        <div class="page-header">
            <div>
                <h1>Customer Inquiries</h1>
                <p class="helper-text">Messages sent from the website contact form appear here.</p>
            </div>
        </div>
        <div class="info-alert">
            <i class="fas fa-bell"></i>
            <div>A red badge on the sidebar indicates unread/new inquiries. Once you follow up, change the status to "Archived" to keep this list clean.</div>
        </div>
        <div class="control-bar">
          <input type="text" id="inquirySearch" class="control-input" oninput="debounceLoadInquiries()" placeholder="Search names or emails..." />
        </div>
        <div id="inquiryList" class="list-container"></div>
      </div>

      <div id="page-archived-inquiries" class="page">
        <div class="page-header">
            <div>
                <h1>Archived Inquiries</h1>
                <p class="helper-text">Old or completed messages that have been saved for history.</p>
            </div>
        </div>
        <div class="control-bar">
          <input type="text" id="archivedInquirySearch" class="control-input" oninput="debounceLoadArchivedInquiries()" placeholder="Search archived names or emails..." />
        </div>
        <div id="archivedInquiryList" class="list-container"></div>
      </div>

      <div id="page-current-projects" class="page">
        <div class="page-header">
            <div>
                <h1>Featured / Flagship Projects</h1>
                <p class="helper-text">Select which VIP projects show up directly on the main home screen slider.</p>
            </div>
            <button class="add-btn gold" id="btnAddCurrentProjectPage"><i class="fas fa-star"></i> Feature a Project</button>
        </div>
        <div class="info-alert">
            <i class="fas fa-info-circle"></i>
            <div>Changes made here will directly affect the very first slider users see on your public homepage.</div>
        </div>
        <div id="currentProjectList" class="list-container"></div>
      </div>

      <div id="page-careers" class="page">
        <div class="page-header">
            <div>
                <h1>Job Openings</h1>
                <p class="helper-text">Manage what jobs are currently available for hiring.</p>
            </div>
            <button class="add-btn gold" id="btnAddCareerPage"><i class="fas fa-plus"></i> Add Job Position</button>
        </div>
        <div id="careerList" class="list-container"></div>
      </div>
      
    </div>
    
    <button id="globalFab" class="add-btn gold" style="display:none; position:fixed; bottom:2rem; right:2rem; border-radius: 50px; padding: 1rem 1.5rem; box-shadow: var(--shadow-lg); z-index: 999;"><i class="fas fa-plus"></i> Add Record</button>

  </main>

  <div id="iconPickerModal" class="modal">
      <div class="modal-content" style="max-width: 500px;">
          <div class="modal-header">
              <h2><i class="fas fa-icons" style="color:var(--brand-gold);"></i> Icon Library</h2>
              <button type="button" class="modal-close" onclick="hideModal('iconPickerModal')">&times;</button>
          </div>
          <div class="modal-body">
              <p class="helper-text" style="margin-bottom: 1rem;">Click any icon below to copy its code, then paste it directly into title or description fields (like Awards).</p>
              <div class="icon-grid" id="iconGridContainer">
                  </div>
          </div>
      </div>
  </div>

  <div id="projectModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 id="projectModalTitle">New Project</h2>
        <button type="button" class="modal-close" onclick="closeProjectModal()" aria-label="Close">&times;</button>
      </div>
      <form id="projectForm" class="modal-form">
        <div class="modal-body">
            <input type="hidden" id="pId" />
            
            <div class="settings-panel" style="background: #FFFBEB; border-color: #FDE68A;">
                <h4 style="color: #B45309;"><i class="fas fa-star"></i> Homepage Display Settings</h4>
                <p class="helper-text" style="margin-top: 0; margin-bottom: 1rem; color: #92400E;">Turn these on to push this specific project to the public homepage.</p>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <label class="toggle-row" style="flex: 1; margin-top: 0; border-color: #FCD34D;">
                        <input type="checkbox" id="pIsCurrent" />
                        <span>Show in <b>"Current Projects"</b> list</span>
                    </label>
                    <label class="toggle-row" style="flex: 1; margin-top: 0; border-color: #FCD34D;">
                        <input type="checkbox" id="pIsFlagship" />
                        <span>Set as <b>"Flagship Slider"</b></span>
                    </label>
                </div>
            </div>

            <div class="form-row">
            <div class="form-group half">
                <label>Year <span class="required">*</span></label>
                <input type="number" id="pYear" required placeholder="YYYY" min="1990" max="2100" />
            </div>
            <div class="form-group half">
                <label>Status <span class="required">*</span></label>
                <select id="pStatus" required>
                <option value="">-- Select Status --</option>
                <option value="Completed">Completed</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Upcoming">Upcoming</option>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label>Project Title <span class="required">*</span></label>
            <input type="text" id="pTitle" required placeholder="Official Project Name" />
            </div>
            <div class="form-group">
            <label>Location <span class="required">*</span></label>
            <input type="text" id="pLoc" required placeholder="City, State" />
            </div>
            <div class="form-group">
            <label>Category <span class="required">*</span></label>
            <select id="pCat" required>
                <option value="">-- Select Category --</option>
                <option value="High Rise">High Rise</option>
                <option value="Hospital">Hospital</option>
                <option value="Hotel">Hotel</option>
                <option value="Factory (Industrial Building Works)">Factory (Industrial Building Works)</option>
                <option value="Terrace, Semi-D &amp; Bungalow">Terrace, Semi-D &amp; Bungalow</option>
                <option value="Commercial Building">Commercial Building</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Civil &amp; Infrastructural Works">Civil &amp; Infrastructural Works</option>
                <option value="Government Building">Government Building</option>
                <option value="School">School</option>
                <option value="Sewerage Treatment Plant">Sewerage Treatment Plant</option>
                <option value="Pipes Laying &amp; Sewer Line">Pipes Laying &amp; Sewer Line</option>
                <option value="Interior Design, Furniture &amp; Renovation Works">Interior Design, Furniture &amp; Renovation Works</option>
                <option value="Landscaping Works">Landscaping Works</option>
                <option value="Pumping Station">Pumping Station</option>
                <option value="Mechanical &amp; Electrical Works">Mechanical &amp; Electrical Works</option>
            </select>
            </div>
            <div class="form-group">
            <label>Award / Certification <button type="button" onclick="window.openIconModal()" style="background:none; border:none; color:var(--info); font-size:0.8rem; cursor:pointer; margin-left: 10px;"><i class="fas fa-search"></i> Find Icon</button></label>
            <input type="text" id="pAward" placeholder="e.g. <i class='fas fa-star'></i> CIDB Award 2024" />
            </div>
            <div class="form-group">
            <label>Scope / Description</label>
            <textarea id="pScope" rows="4" placeholder="Brief project overview, scope of work..."></textarea>
            </div>
            
            <div class="settings-panel">
            <h4><i class="fas fa-link" style="color: var(--text-muted);"></i> Detail Page Template</h4>
            <p class="helper-text" style="margin-top:0; margin-bottom: 1rem;">Upload a custom HTML file or provide a web link manually.</p>
            <div style="display:flex; gap:1rem; align-items:center;">
                <input type="file" id="pHtmlFile" accept=".html" class="control-input" style="flex:1;" />
                <span style="font-weight:700; color:var(--text-muted); font-size:0.85rem;">OR</span>
                <input type="url" id="pDetailManualUrl" class="control-input" style="flex:1;" placeholder="https://... (Manual Link)" />
            </div>
            <div id="pHtmlLink" style="display:none; margin-top: 1rem; font-weight: 600; font-size: 0.85rem;"></div>
            </div>

            <div class="form-group">
            <label>Project Images</label>
            <div class="drag-area" id="projectDragArea">
                <i class="fas fa-cloud-upload-alt"></i>
                <div style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.4rem;">Click or drag multiple images here</div>
                <small class="helper-text">Drag photos left or right to rearrange order. JPG, PNG, or HEIC supported.</small>
            </div>
            <input type="file" id="pImgFile" multiple accept="image/*,.heic,.heif" style="display:none" />
            <div id="projectPreviewContainer" class="preview-container"></div>
            </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-btn" onclick="closeProjectModal()">Cancel</button>
          <button type="submit" class="save-btn" id="saveProjectBtn"><i class="fas fa-save"></i> Save Record</button>
        </div>
      </form>
    </div>
  </div>

  <div id="awardModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h2 id="awardModalTitle">New Award</h2>
        <button type="button" class="modal-close" onclick="closeAwardModal()">&times;</button>
      </div>
      <form id="awardForm" class="modal-form">
        <div class="modal-body">
            <input type="hidden" id="aId" />
            <div class="form-row">
                <div class="form-group half">
                    <label>Year <span class="required">*</span></label>
                    <input type="number" id="aYear" required placeholder="YYYY" min="1990" max="2100" />
                </div>
                <div class="form-group half">
                    <label>Issuer / Organization</label>
                    <input type="text" id="aIssuer" placeholder="e.g. CIDB" />
                </div>
            </div>
            <div class="form-group">
                <label>Title <span class="required">*</span> <button type="button" onclick="window.openIconModal()" style="background:none; border:none; color:var(--info); font-size:0.8rem; cursor:pointer; margin-left: 10px;"><i class="fas fa-search"></i> Find Icon</button></label>
                <input type="text" id="aTitle" required placeholder="e.g. <i class='fas fa-trophy'></i> Best Construction Company" />
            </div>
            <div class="form-group">
            <label>Description</label>
            <textarea id="aDesc" rows="4" placeholder="Award criteria and significance..."></textarea>
            </div>
            <div class="form-group">
            <label>Award Certificate / Image</label>
            <div class="drag-area" id="awardDragArea">
                <i class="fas fa-image"></i>
                <div style="font-weight: 600; font-size: 1.1rem;">Click or drag to upload</div>
            </div>
            <input type="file" id="aImgFile" accept="image/*,.heic,.heif,application/pdf" style="display:none" />
            <div id="awardPreviewContainer" class="preview-container"></div>
            </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-btn" onclick="closeAwardModal()">Cancel</button>
          <button type="submit" class="save-btn" id="saveAwardBtn"><i class="fas fa-save"></i> Save Record</button>
        </div>
      </form>
    </div>
  </div>

  <div id="pressModal" class="modal">
    <div class="modal-content" style="max-width: 650px;">
        <div class="modal-header">
            <h2 id="pressModalTitle">New Media Recognition</h2>
            <button type="button" class="modal-close" onclick="closePressModal()">&times;</button>
        </div>
        <form id="pressForm" class="modal-form">
            <div class="modal-body">
                <input type="hidden" id="pressId" />
                <div class="form-group">
                    <label>Publication / Source <span class="required">*</span></label>
                    <input type="text" id="pressPublication" required placeholder="e.g. The Star, Bernama" />
                </div>
                <div class="form-group">
                    <label>Headline <span class="required">*</span></label>
                    <input type="text" id="pressTitle" required placeholder="Headline of the article" />
                </div>
                <div class="form-row">
                    <div class="form-group half">
                        <label>Date <span class="required">*</span></label>
                        <input type="date" id="pressDate" required />
                    </div>
                    <div class="form-group half">
                        <label>Visibility</label>
                        <select id="pressIsFeatured">
                            <option value="false">Standard Archive</option>
                            <option value="true">Feature on Homepage</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Brief Summary / Quote</label>
                    <textarea id="pressSummary" rows="4" placeholder="Key excerpt..."></textarea>
                </div>
                <div class="form-group">
                    <label>Article Link</label>
                    <input type="url" id="pressLink" placeholder="https://..." />
                </div>
                <div class="form-group">
                    <label>Media Image / Cover <span class="required">*</span></label>
                    <div class="drag-area" id="pressDragArea">
                        <i class="fas fa-newspaper"></i>
                        <div style="font-weight: 600; font-size: 1.1rem;">Click or drag ONE image here</div>
                    </div>
                    <input type="file" id="pressImgFile" accept="image/*,.heic,.heif" style="display:none" />
                    <div id="pressPreviewContainer" class="preview-container"></div>
                </div>
            </div>
             <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closePressModal()">Cancel</button>
                <button type="submit" class="save-btn" id="savePressBtn"><i class="fas fa-save"></i> Save Record</button>
            </div>
        </form>
    </div>
  </div>

  <div id="newsModal" class="modal">
    <div class="modal-content" style="max-width: 650px;">
      <div class="modal-header">
        <h2 id="newsModalTitle">New News Item</h2>
        <button type="button" class="modal-close" onclick="closeNewsModal()">&times;</button>
      </div>
      <form id="newsForm" class="modal-form">
        <div class="modal-body">
            <input type="hidden" id="nId" />
            <div class="form-row">
            <div class="form-group half">
                <label>Date <span class="required">*</span></label>
                <input type="date" id="nDate" required />
            </div>
            <div class="form-group half">
                <label>Category</label>
                <select id="nCategory">
                <option value="General">General</option>
                <option value="Milestone">Milestone</option>
                <option value="Project">Project Update</option>
                <option value="Award">Award</option>
                <option value="CSR">CSR Activity</option>
                <option value="Team">Team Activity</option>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label>Title <span class="required">*</span></label>
            <input type="text" id="nTitle" required placeholder="Announcement headline" />
            </div>
            <div class="form-group">
            <label>Content</label>
            <textarea id="nContent" rows="6" placeholder="Full news article body..."></textarea>
            </div>
            <div class="form-group">
            <label>Images</label>
            <div class="drag-area" id="newsDragArea">
                <i class="fas fa-images"></i>
                <div style="font-weight: 600; font-size: 1.1rem;">Click or drag to upload</div>
            </div>
            <input type="file" id="nImgFile" multiple accept="image/*,.heic,.heif" style="display:none" />
            <div id="newsPreviewContainer" class="preview-container"></div>
            </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-btn" onclick="closeNewsModal()">Cancel</button>
          <button type="submit" class="save-btn" id="saveNewsBtn"><i class="fas fa-save"></i> Save Record</button>
        </div>
      </form>
    </div>
  </div>

  <div id="cultureModal" class="modal">
    <div class="modal-content" style="max-width: 650px;">
      <div class="modal-header">
        <h2 id="cultureModalTitle">New Culture Event</h2>
        <button type="button" class="modal-close" onclick="closeCultureModal()">&times;</button>
      </div>
      <form id="cultureForm" class="modal-form">
        <div class="modal-body">
            <input type="hidden" id="cId" data-table="culture" />
            <div class="form-row">
            <div class="form-group half">
                <label>Year <span class="required">*</span></label>
                <input type="number" id="cYear" required placeholder="YYYY" min="2000" max="2100" />
            </div>
            <div class="form-group half">
                <label>Type <span class="required">*</span></label>
                <select id="cType" required onchange="updateModalSubOptions()">
                <option value="">-- Select Type --</option>
                <option value="trip">Company Trip</option>
                <option value="tb">Team Building</option>
                <option value="festive">Festive / Celebration</option>
                <option value="csr">CSR Activity</option>
                <option value="work">Work / Milestone</option>
                <option value="training">Company Training</option>
                <option value="intern">Industrial Training</option>
                <option value="sponsor">Sponsorship</option>
                </select>
            </div>
            </div>
            <div class="form-row">
                <div class="form-group half">
                    <label>Sub-Category</label>
                    <select id="cSubCategory"><option value="all">Default / All</option></select>
                </div>
                <div class="form-group half">
                    <label>Location</label>
                    <input type="text" id="cLocation" placeholder="Event venue" />
                </div>
            </div>
            <div class="form-group">
            <label>Event Name <span class="required">*</span></label>
            <input type="text" id="cName" required placeholder="e.g. Annual Dinner" />
            </div>
            <div class="form-group">
            <label>Description</label>
            <textarea id="cDescription" rows="4" placeholder="Event highlights..."></textarea>
            </div>
            <div class="form-group">
            <label>Photos</label>
            <div class="drag-area" id="cultureDragArea">
                <i class="fas fa-camera"></i>
                <div style="font-weight: 600; font-size: 1.1rem;">Click or drag multiple images here</div>
            </div>
            <input type="file" id="cImgFile" multiple accept="image/*,.heic,.heif" style="display:none" />
            <div id="culturePreviewContainer" class="preview-container"></div>
            </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-btn" onclick="closeCultureModal()">Cancel</button>
          <button type="submit" class="save-btn" id="saveCultureBtn"><i class="fas fa-save"></i> Save Record</button>
        </div>
      </form>
    </div>
  </div>

  <div id="certModal" class="modal">
    <div class="modal-content" style="max-width: 550px;">
      <div class="modal-header">
        <h2 id="certModalTitle">Add Certification</h2>
        <button type="button" class="modal-close" onclick="closeCertModal()">&times;</button>
      </div>
      <form id="certForm" class="modal-form">
        <div class="modal-body">
            <input type="hidden" id="certId" />
            <input type="hidden" id="certTable" />
            <div id="certSpecificFields"></div>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-btn" onclick="closeCertModal()">Cancel</button>
          <button type="submit" class="save-btn" id="saveCertBtn"><i class="fas fa-save"></i> Save Record</button>
        </div>
      </form>
    </div>
  </div>

  <div id="inquiryModal" class="modal">
    <div class="modal-content" style="max-width: 650px;">
      <div class="modal-header">
        <h2 id="inquiryModalTitle">Manage Inquiry</h2>
        <button type="button" class="modal-close" onclick="closeInquiryModal()">&times;</button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="iId" />
          <div class="settings-panel">
            <h4 style="margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; font-size: 1rem;">Contact Information</h4>
            <div class="form-row">
            <div class="form-group half">
                <label>Name</label>
                <input type="text" id="iFullName" readonly />
            </div>
            <div class="form-group half">
                <label>Company</label>
                <input type="text" id="iCompany" readonly />
            </div>
            </div>
            <div class="form-row">
            <div class="form-group half">
                <label>Email</label>
                <input type="email" id="iEmail" readonly />
            </div>
            <div class="form-group half">
                <label>Phone</label>
                <input type="tel" id="iPhone" readonly />
            </div>
            </div>
          </div>
          <div style="margin-bottom: 1.5rem;">
            <div class="form-group">
            <label>Nature of Inquiry</label>
            <input type="text" id="iNature" readonly />
            </div>
            <div class="form-group">
            <label>Message</label>
            <textarea id="iMessage" rows="5" readonly style="white-space: pre-line; background: #F8FAFC; line-height: 1.6;"></textarea>
            </div>
          </div>
          <div style="background: #FFFBEB; padding: 1.5rem; border-radius: var(--radius-sm); border: 1px solid #FDE68A;">
            <h4 style="margin-bottom: 1rem; color: #B45309; font-size: 1rem;"><i class="fas fa-clipboard-check"></i> Internal Tracking</h4>
            <div class="form-group">
            <label style="color:#92400E;">Status</label>
            <select id="iStatus" style="border-color: #FCD34D;">
                <option value="new">New (Unread)</option>
                <option value="replied">Replied</option>
                <option value="in-progress">In Progress</option>
                <option value="archived">Archived</option>
                <option value="spam">Spam</option>
            </select>
            </div>
            <div class="form-group" style="margin-bottom:0;">
            <label style="color:#92400E;">Internal Notes</label>
            <textarea id="iAdminNotes" rows="3" placeholder="Follow-up actions, assignments..." style="border-color: #FCD34D;"></textarea>
            </div>
          </div>
      </div>
      <div class="modal-actions" style="justify-content: space-between;">
        <button type="button" class="btn-delete" id="archiveInquiryBtn" style="padding: 0.75rem 1.5rem;"><i class="fas fa-archive"></i> Archive</button>
        <div style="display:flex; gap: 1rem;">
            <button type="button" class="cancel-btn" onclick="closeInquiryModal()">Close</button>
            <button type="button" class="save-btn" id="saveInquiryBtn"><i class="fas fa-save"></i> Save Tracking</button>
        </div>
      </div>
    </div>
  </div>

  <div id="currentProjectModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h2 id="currentProjectModalTitle">Featured / Flagship Project</h2>
        <button type="button" class="modal-close" onclick="closeCurrentProjectModal()">&times;</button>
      </div>
      <form id="currentProjectForm" class="modal-form">
        <div class="modal-body">
            <input type="hidden" id="cpId" />
            <div class="form-group">
            <label>Title <span class="required">*</span></label>
            <input type="text" id="cpTitle" required placeholder="Project Title" />
            </div>
            <div class="form-group">
            <label>Location</label>
            <input type="text" id="cpLocation" placeholder="City, State" />
            </div>
            <div class="form-group">
            <label>Short Description</label>
            <textarea id="cpDescription" rows="4" placeholder="Brief text shown on homepage slider..."></textarea>
            </div>
            <div class="form-row">
                <div class="form-group half">
                <label>Sort Order <small>(Lower number = shows first)</small></label>
                <input type="number" id="cpSortOrder" value="10" min="0" />
                </div>
                <div class="form-group half" style="display:flex; align-items:center; justify-content: flex-start; gap: 12px; background: #F8FAFC; padding: 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); margin-top: 1.6rem;">
                    <input type="checkbox" id="cpIsFeatured" checked style="width: 20px; height: 20px; accent-color: var(--brand-gold); cursor: pointer; margin:0;" />
                    <label for="cpIsFeatured" style="margin:0; cursor: pointer; user-select: none; font-size: 0.95rem; font-weight: 600;">Active on Homepage</label>
                </div>
            </div>

            <div class="settings-panel">
            <h4><i class="fas fa-link" style="color: var(--text-muted);"></i> Detail Page Link</h4>
            <div style="display:flex; gap:1rem; align-items:center;">
                <input type="file" id="cpHtmlFile" accept=".html" class="control-input" style="flex:1" />
                <span style="font-weight: 700; color: var(--text-muted); font-size: 0.85rem;">OR</span>
                <input type="url" id="cpDetailPage" class="control-input" style="flex:1" placeholder="https://... (Manual Link)" />
            </div>
            <div id="cpHtmlLink" style="display:none; margin-top: 1rem; font-weight: 600; font-size: 0.85rem;"></div>
            </div>

            <div class="form-group">
            <label>Cover Image <span class="required">*</span></label>
            <div class="drag-area" id="cpDragArea">
                <i class="fas fa-image"></i>
                <div style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.4rem;">Click or drag ONE image here</div>
                <small class="helper-text">Recommended: 1200x800 px</small>
            </div>
            <input type="file" id="cpImageInput" accept="image/*,.heic,.heif" style="display:none" />
            <div id="cpPreviewContainer" class="preview-container"></div>
            </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-btn" onclick="closeCurrentProjectModal()">Cancel</button>
          <button type="submit" class="save-btn" id="saveCurrentProjectBtn"><i class="fas fa-save"></i> Save Record</button>
        </div>
      </form>
    </div>
  </div>

  <div id="careerModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
      <div class="modal-header">
        <h2 id="careerModalTitle">Job Position</h2>
        <button type="button" class="modal-close" onclick="closeCareerModal()">&times;</button>
      </div>
      <form id="careerForm" class="modal-form">
        <div class="modal-body">
            <input type="hidden" id="careerId" />
            <div class="form-group">
            <label>Position Number <span class="required">*</span></label>
            <input type="number" id="careerItemNumber" min="1" max="99" required placeholder="e.g. 1" />
            </div>
            <div class="form-group">
            <label>Job Title <span class="required">*</span></label>
            <input type="text" id="careerTitle" required placeholder="e.g. Senior Site Engineer" />
            </div>
            <div class="form-group">
            <label>Status</label>
            <select id="careerAvailable">
                <option value="true">Open (Accepting Applications)</option>
                <option value="false">Closed</option>
            </select>
            </div>
            <div class="form-group">
            <label>List Priority <small>(0 = highest)</small></label>
            <input type="number" id="careerSortOrder" value="0" min="0" />
            </div>
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-btn" onclick="closeCareerModal()">Cancel</button>
          <button type="submit" class="save-btn" id="saveCareerBtn"><i class="fas fa-save"></i> Save Position</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // ================================================
    // UUID GENERATOR FALLBACK
    // ================================================
    window.generateUUID = function() {
        if (typeof crypto !== 'undefined' && crypto.randomUUID) return crypto.randomUUID();
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };

    // ================================================
    // CUSTOM CONFIRMATION REPLACEMENT
    // ================================================
    window.customConfirm = function(title, message, callback) {
        const modal = document.getElementById('customConfirmModal');
        document.getElementById('confirmTitle').textContent = title;
        document.getElementById('confirmMessage').textContent = message;
        
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);

        const cancelBtn = document.getElementById('confirmCancelBtn');
        const actionBtn = document.getElementById('confirmActionBtn');

        const cleanup = () => {
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 200);
            cancelBtn.onclick = null;
            actionBtn.onclick = null;
        };

        cancelBtn.onclick = () => cleanup();
        actionBtn.onclick = () => {
            cleanup();
            callback();
        };
    };

    // ================================================
    // ICON PICKER LOGIC
    // ================================================
    const COMMON_ICONS = [
        'fa-star', 'fa-trophy', 'fa-award', 'fa-medal', 'fa-crown',
        'fa-building', 'fa-hard-hat', 'fa-tools', 'fa-hammer', 'fa-truck-pickup',
        'fa-check', 'fa-check-circle', 'fa-check-double', 'fa-shield-alt', 'fa-certificate',
        'fa-handshake', 'fa-leaf', 'fa-bolt', 'fa-globe', 'fa-thumbs-up'
    ];

    window.openIconModal = function() {
        const container = document.getElementById('iconGridContainer');
        container.innerHTML = COMMON_ICONS.map(icon => `
            <div class="icon-item" onclick="copyIconCode('${icon}')">
                <i class="fas ${icon}"></i>
                <span>${icon.replace('fa-', '')}</span>
            </div>
        `).join('');
        
        const modal = document.getElementById('iconPickerModal');
        modal.style.display = "flex";
        setTimeout(() => modal.classList.add("show"), 10);
    };

    window.copyIconCode = function(iconClass) {
        const code = `<i class="fas ${iconClass}"></i>`;
        navigator.clipboard.writeText(code).then(() => {
            showToast(`Copied ${iconClass} to clipboard!`, 'success');
            hideModal('iconPickerModal');
        }).catch(err => {
            showToast('Failed to copy. Please type manually.', 'error');
        });
    };

    // ================================================
    // STATE MANAGEMENT FOR INSTANT EDIT POPULATION
    // ================================================
    window.appState = {
        projects: [], awards: [], news: [], press: [], culture: [], currentProjects: [], careers: [], inquiries: []
    };

    window.getDbClient = function() {
        if (typeof window.CMS !== 'undefined' && window.CMS.getDbClient) return window.CMS.getDbClient();
        if (typeof window.supabaseClient !== 'undefined') return window.supabaseClient; 
        return null;
    };

    window.safeParseImages = function(imgData) {
        if (!imgData) return [];
        if (Array.isArray(imgData)) return imgData;
        if (typeof imgData === 'string') {
            try {
                const parsed = JSON.parse(imgData);
                return Array.isArray(parsed) ? parsed : [imgData];
            } catch(e) {
                return [imgData];
            }
        }
        return [imgData];
    };

    // ================================================
    // SYSTEMATIC UI GROUPING HELPER (Year Accordions)
    // ================================================
    window.renderGroupedByYear = function(items, renderItemFn, dateKey = 'year') {
        const grouped = items.reduce((acc, item) => {
            let y = item[dateKey];
            if (!y && item.date) {
                y = item.date.includes('/') ? item.date.split('/')[2] :
                    item.date.includes('-') ? item.date.split('-')[0] : 'Unknown';
            }
            if (!y && item.publish_date) {
                 y = item.publish_date.includes('-') ? item.publish_date.split('-')[0] : 'Unknown';
            }
            if (!y) y = 'Unknown';
            if (!acc[y]) acc[y] = [];
            acc[y].push(item);
            return acc;
        }, {});

        const years = Object.keys(grouped).sort((a, b) => {
            if (a === 'Unknown') return 1;
            if (b === 'Unknown') return -1;
            return parseInt(b) - parseInt(a);
        });

        return years.map(year => `
            <div class="year-group">
                <div class="year-header" onclick="this.parentElement.classList.toggle('collapsed')">
                    <h3>${year === 'Unknown' ? 'Others' : year} <span class="badge solid">${grouped[year].length}</span></h3>
                    <i class="fas fa-chevron-up toggle-icon"></i>
                </div>
                <div class="year-content list-container">
                    ${grouped[year].map((item, index) => renderItemFn(item, index)).join('')}
                </div>
            </div>
        `).join('');
    };

    // ================================================
    // LIGHTBOX LOGIC
    // ================================================
    function openLightbox(src) {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        if (!modal || !img) return;
        img.src = src;
        modal.style.display = 'flex';
        setTimeout(() => { modal.style.opacity = '1'; }, 10);
    }

    window.closeLightbox = function() {
        const modal = document.getElementById('lightboxModal');
        if (!modal) return;
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
            document.getElementById('lightboxImg').src = '';
        }, 200);
    }

    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeLightbox(); });
    document.getElementById('lightboxModal')?.addEventListener('click', (e) => {
        if (e.target === document.getElementById('lightboxModal')) closeLightbox();
    });

    // ================================================
    // SCROLL MANAGEMENT
    // ================================================
    const state = { currentModule: 'dashboard', scrollRegistry: {} };

    function saveScrollPosition() {
        if (state.currentModule) state.scrollRegistry[state.currentModule] = window.scrollY;
    }

    function restoreScrollPosition(targetId = null) {
        const savedY = state.scrollRegistry[state.currentModule] || 0;
        setTimeout(() => {
            window.scrollTo({ top: savedY, behavior: 'auto' });
            if (targetId) {
                const element = document.querySelector(`[data-id="${targetId}"]`);
                if (element) {
                    element.classList.add('highlight-item');
                    const group = element.closest('.year-group');
                    if (group && group.classList.contains('collapsed')) group.classList.remove('collapsed');
                    setTimeout(() => element.classList.remove('highlight-item'), 2000);
                }
            }
        }, 100);
    }

    async function reloadAndPreserveScroll(loadFunction, isEdit, itemId) {
        const currentY = window.scrollY; 
        await loadFunction(true); 
        
        setTimeout(() => {
            window.scrollTo({ top: currentY, behavior: 'auto' });
            if (itemId) {
                const el = document.querySelector(`[data-id="${itemId}"]`);
                if (el) {
                    if (isEdit) el.classList.add('highlight-item');
                    const group = el.closest('.year-group');
                    if (group && group.classList.contains('collapsed')) group.classList.remove('collapsed');
                    if (isEdit) setTimeout(() => el.classList.remove('highlight-item'), 2000);
                }
            }
        }, 150);
    }

    // ================================================
    // TOAST NOTIFICATION SYSTEM
    // ================================================
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        let icon = type === 'error' ? 'fa-exclamation-circle' : type === 'info' ? 'fa-info-circle' : 'fa-check-circle';
        toast.innerHTML = `<i class="fas ${icon}"></i> <span>${message}</span>`;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s forwards';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    window.alert = function(msg) {
        if(msg.toLowerCase().includes('fail') || msg.toLowerCase().includes('error')) showToast(msg, 'error');
        else showToast(msg, 'success');
    };

    // ================================================
    // UTILITIES & CACHE
    // ================================================
    function clearCache(table = null) {
        if (typeof window.CMS?.clearCache === 'function') window.CMS.clearCache(table);
        if (table) {
            localStorage.removeItem(`cms_cache_${table}`);
            localStorage.removeItem(`cms_cache_${table}_v1`);
        } else {
            Object.keys(localStorage).forEach(key => {
                if (key.startsWith('cms_cache_') || key.startsWith('builtech_')) localStorage.removeItem(key);
            });
        }
    }

    function debounce(fn, delay = 350) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }
    
    window.debounceLoadCulture = debounce(() => loadCulture(), 350);
    window.debounceLoadProjects = debounce(() => loadProjects(), 350);
    window.debounceLoadAwards = debounce(() => loadAwards(), 350);
    window.debounceLoadNews = debounce(() => loadNews(), 350);
    window.debounceLoadPress = debounce(() => loadPress(), 350);
    window.debounceLoadInquiries = debounce(() => loadInquiries(), 350);
    window.debounceLoadArchivedInquiries = debounce(() => loadArchivedInquiries(), 350);

// ================================================
// MULTIPLE IMAGE MANAGER
// ================================================
class ImageManager {
    constructor(dragAreaId, fileInputId, containerId) {
        this.dragArea = document.getElementById(dragAreaId);
        this.fileInput = document.getElementById(fileInputId);
        this.container = document.getElementById(containerId);
        this.filesMap = {}; this.items = []; 
        if(!this.dragArea || !this.fileInput || !this.container) return;
        this.initEvents(); this.initSortable();
    }

    initEvents() {
        this.dragArea.onclick = () => this.fileInput.click();
        this.fileInput.onchange = (e) => this.processFiles(e.target.files);
        this.dragArea.addEventListener("dragover", e => { e.preventDefault(); this.dragArea.classList.add("drag-over"); });
        this.dragArea.addEventListener("dragleave", () => this.dragArea.classList.remove("drag-over"));
        this.dragArea.addEventListener("drop", e => { 
            e.preventDefault(); 
            this.dragArea.classList.remove("drag-over"); 
            if (e.dataTransfer?.files?.length) this.processFiles(e.dataTransfer.files); 
        });
    }

    async processFiles(fileList) {
        for (let file of fileList) {
            if (file.name.toLowerCase().endsWith(".heic") || file.name.toLowerCase().endsWith(".heif")) {
                if (typeof heic2any !== 'undefined') {
                    showToast(`Converting Apple format: ${file.name}...`, 'info');
                    try {
                        const convertedBlobArray = await heic2any({ blob: file, toType: "image/png", quality: 0.8 });
                        const convertedBlob = Array.isArray(convertedBlobArray) ? convertedBlobArray[0] : convertedBlobArray;
                        const newName = file.name.replace(/\.(heic|heif)$/i, ".png");
                        file = new File([convertedBlob], newName, { type: "image/png" });
                    } catch(e) { 
                        showToast(`Failed to convert ${file.name}`, 'error'); continue; 
                    }
                } else {
                    showToast(`Cannot process ${file.name}. Conversion library missing.`, 'error'); continue; 
                }
            }
            if (!file.type.startsWith("image/")) {
                showToast(`${file.name} is not a valid image.`, 'warning'); continue;
            }

            const fileId = 'file_' + Math.random().toString(36).substr(2, 9);
            this.filesMap[fileId] = file;
            const reader = new FileReader();

            reader.onload = ev => {
                const img = new Image();
                img.onload = () => {
                    const isSmall = img.width < 250 || img.height < 250;
                    this.items.push({ id: fileId, type: 'file', data: file, previewUrl: ev.target.result, isSmall: isSmall });
                    this.render();
                };
                img.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        }
        this.fileInput.value = ""; 
    }

    setExisting(urls) {
        this.items = (urls || []).map((url, i) => ({ 
            id: 'url_' + i + '_' + Math.random().toString(36).substr(2, 5), 
            type: 'url', data: url, previewUrl: url, isSmall: false 
        }));
        this.filesMap = {}; 
        this.render();
    }

    getFinalPayload() {
        const sequence = [];
        const boxes = this.container.querySelectorAll('.preview-box');
        boxes.forEach(box => {
            const id = box.dataset.id; 
            const item = this.items.find(i => i.id === id);
            if(item) sequence.push({ type: item.type, data: item.data });
        });
        return sequence;
    }

    render() {
        this.container.innerHTML = "";
        this.items.forEach(item => {
            const div = document.createElement("div"); 
            div.className = `preview-box ${item.isSmall ? 'small-image-fix' : ''}`; 
            div.draggable = true; 
            div.dataset.id = item.id;
            
            div.innerHTML = `
                <div class="img-wrapper">
                    <img src="${item.previewUrl}" title="Click to enlarge">
                </div>
                <button class="remove-btn" type="button" aria-label="Remove image">&times;</button>
            `;

            div.querySelector('img').onclick = (e) => { e.stopPropagation(); openLightbox(item.previewUrl); };
            div.querySelector(".remove-btn").onclick = (e) => { 
                e.stopPropagation(); 
                this.items = this.items.filter(i => i.id !== item.id); 
                if(item.type === 'file') delete this.filesMap[item.id]; 
                this.render(); 
            };
            this.setupDragEvents(div); 
            this.container.appendChild(div);
        });
    }

    setupDragEvents(itemEl) {
        itemEl.addEventListener('dragstart', () => { itemEl.classList.add('dragging'); });
        itemEl.addEventListener('dragend', () => { itemEl.classList.remove('dragging'); this.container.style.background = ''; });
    }

    initSortable() {
        this.container.addEventListener('dragover', (e) => {
            e.preventDefault(); 
            this.container.style.background = 'rgba(212, 175, 55, 0.05)';
            const draggingItem = this.container.querySelector('.dragging');
            if(!draggingItem) return;
            const siblings = [...this.container.querySelectorAll('.preview-box:not(.dragging)')];
            const nextSibling = siblings.find(sibling => {
                const box = sibling.getBoundingClientRect();
                return e.clientX <= box.left + box.width / 2 && e.clientY <= box.top + box.height;
            });
            if (nextSibling) this.container.insertBefore(draggingItem, nextSibling); 
            else this.container.appendChild(draggingItem);
        });
        this.container.addEventListener('dragleave', () => this.container.style.background = '');
    }
}

// ================================================
// SINGLE IMAGE MANAGER
// ================================================
class SingleImageManager {
    constructor(dragAreaId, fileInputId, containerId) {
        this.dragArea = document.getElementById(dragAreaId);
        this.fileInput = document.getElementById(fileInputId);
        this.container = document.getElementById(containerId);
        this.currentFile = null; this.existingUrl = null;
        if(!this.dragArea || !this.fileInput || !this.container) return;
        this.initEvents();
    }
    
    initEvents() {
        this.dragArea.onclick = () => this.fileInput.click();
        this.fileInput.onchange = (e) => this.processFile(e.target.files[0]);
        this.dragArea.addEventListener("dragover", e => { e.preventDefault(); this.dragArea.classList.add("drag-over"); });
        this.dragArea.addEventListener("dragleave", () => this.dragArea.classList.remove("drag-over"));
        this.dragArea.addEventListener("drop", e => { 
            e.preventDefault(); 
            this.dragArea.classList.remove("drag-over"); 
            if (e.dataTransfer?.files?.[0]) this.processFile(e.dataTransfer.files[0]); 
        });
    }
    
    async processFile(file) {
        if (!file) return;
        const isPdf = file.type === "application/pdf";

        if (file.name.toLowerCase().endsWith(".heic") || file.name.toLowerCase().endsWith(".heif")) {
            if (typeof heic2any !== 'undefined') {
                try {
                    const convertedBlobArray = await heic2any({ blob: file, toType: "image/png", quality: 0.8 });
                    const convertedBlob = Array.isArray(convertedBlobArray) ? convertedBlobArray[0] : convertedBlobArray;
                    file = new File([convertedBlob], file.name.replace(/\.(heic|heif)$/i, ".png"), { type: "image/png" });
                } catch(e) {
                     showToast('Failed to convert HEIC image.', 'error'); return; 
                }
            } else {
                 showToast('HEIC conversion missing.', 'error'); return;
            }
        }
        
        if (!file.type.startsWith("image/") && !isPdf) {
             showToast("Invalid file type uploaded. Please upload an image or PDF.", "error"); return;
        }
        
        this.currentFile = file; this.existingUrl = null;

        if (isPdf) {
            this.renderPdf();
        } else {
            const reader = new FileReader(); 
            reader.onload = ev => {
                const img = new Image();
                img.onload = () => this.render(ev.target.result, img.width < 250);
                img.src = ev.target.result;
            }; 
            reader.readAsDataURL(file);
        }
        this.fileInput.value = "";
    }
    
    setExisting(url) { 
        this.existingUrl = url; this.currentFile = null; 
        if(url && typeof url === 'string') {
            if (url.toLowerCase().includes('.pdf')) this.renderPdf(url);
            else this.render(url, false);
        } else if (url) {
            this.render(url, false);
        } else {
            this.container.innerHTML = ""; 
        }
    }
    
    getFinalPayload() { return { existingUrl: this.existingUrl, newFile: this.currentFile }; }
    
    render(src, isSmall) {
        this.container.innerHTML = `
            <div class="preview-box ${isSmall ? 'small-image-fix' : ''}" style="width:180px; height:120px; cursor: default;">
                <div class="img-wrapper"><img src="${src}" title="Click to enlarge"></div>
                <button class="remove-btn" type="button">&times;</button>
            </div>`;
        this.container.querySelector('img').onclick = (e) => { e.stopPropagation(); openLightbox(src); };
        this.container.querySelector('.remove-btn').onclick = (e) => { e.stopPropagation(); this.currentFile = null; this.existingUrl = null; this.container.innerHTML = ""; };
    }

    renderPdf(url = null) {
        this.container.innerHTML = `
            <div class="preview-box" style="width:180px; height:120px; cursor: pointer; display:flex; align-items:center; justify-content:center; background:#f8fafc; border: 1px solid var(--border-color);">
                <div style="text-align:center;">
                    <i class="fas fa-file-pdf" style="font-size:2.5rem; color:var(--danger); margin-bottom: 0.5rem;"></i>
                    <div style="font-size:0.85rem; font-weight:600; color: var(--text-heading);">PDF Document</div>
                </div>
                <button class="remove-btn" type="button">&times;</button>
            </div>`;
        this.container.querySelector('.remove-btn').onclick = (e) => { e.stopPropagation(); this.currentFile = null; this.existingUrl = null; this.container.innerHTML = ""; };
        if (url) this.container.querySelector('.preview-box').onclick = () => window.open(url, '_blank');
    }
}

let imgManagers = {};

    // ================================================
    // MODAL OPEN / CLOSE HELPERS
    // ================================================
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.style.display = "flex";
        setTimeout(() => modal.classList.add("show"), 10);
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.remove("show");
        setTimeout(() => { modal.style.display = "none"; }, 200); 
    }

    window.closeProjectModal = () => { hideModal("projectModal"); document.getElementById("pImgFile").value = ""; document.getElementById("pHtmlFile").value = ""; };
    window.closeAwardModal = () => { hideModal("awardModal"); document.getElementById("aImgFile").value = ""; };
    window.closePressModal = () => { hideModal("pressModal"); document.getElementById("pressImgFile").value = ""; };
    window.closeNewsModal = () => { hideModal("newsModal"); document.getElementById("nImgFile").value = ""; };
    window.closeCultureModal = () => { hideModal("cultureModal"); document.getElementById("cImgFile").value = ""; };
    window.closeCertModal = () => { hideModal("certModal"); document.getElementById("certFile").value = ""; };
    window.closeInquiryModal = () => hideModal("inquiryModal");
    window.closeCurrentProjectModal = () => { hideModal("currentProjectModal"); document.getElementById("cpImageInput").value = ""; document.getElementById("cpHtmlFile").value = ""; };
    window.closeCareerModal = () => hideModal("careerModal");

    async function getAuthUserId() {
        const db = window.getDbClient();
        if (!db || !db.auth) return null;
        try {
            const { data: { user }, error } = await db.auth.getUser();
            if (error || !user) return null;
            return user.id;
        } catch (err) {
            console.error("Failed to get auth user:", err);
            return null;
        }
    }

    function validateRequiredFields(formId) {
        const form = document.getElementById(formId);
        if (!form) return false;
        
        let valid = true;
        form.querySelectorAll('[required]').forEach(el => {
            if (!el.value.trim()) {
                el.style.borderColor = 'var(--danger)';
                valid = false;
                setTimeout(() => { el.style.borderColor = 'var(--border-color)'; }, 3000);
            }
        });
        
        form.querySelectorAll('input[type="number"][min][max]').forEach(el => {
            if (el.value) {
                const val = parseInt(el.value);
                if (isNaN(val) || val < el.min || val > el.max) {
                    el.style.borderColor = 'var(--danger)';
                    valid = false;
                    setTimeout(() => { el.style.borderColor = 'var(--border-color)'; }, 3000);
                }
            }
        });
        
        if (!valid) showToast("Please fill all required fields correctly.", "error");
        return valid;
    }

    // ================================================
    // CRUD Logic: PROJECTS
    // ================================================
    window.openProjectModalAction = async (id = null) => {
      showModal("projectModal");
      document.getElementById("projectModalTitle").textContent = id ? "Edit Project" : "New Project";
      document.getElementById("projectForm").reset();
      document.getElementById("pHtmlFile").value = "";
      imgManagers.projects.setExisting([]); 
      document.getElementById("pId").value = id || "";

      const htmlLink = document.getElementById("pHtmlLink");
      htmlLink.style.display = "none";
      
      document.getElementById("pIsCurrent").checked = false;
      document.getElementById("pIsFlagship").checked = false;

      if (id) {
        const item = window.appState.projects.find(p => p.id == id);
        if (item) {
            document.getElementById("pYear").value = item.year || "";
            document.getElementById("pTitle").value = item.title || "";
            document.getElementById("pLoc").value = item.loc || item.location || "";
            document.getElementById("pCat").value = item.cat || item.category || "";
            document.getElementById("pStatus").value = item.status || "Completed";
            document.getElementById("pAward").value = item.award || "";
            document.getElementById("pScope").value = item.scope || "";
            document.getElementById("pDetailManualUrl").value = item.detail_page || item.project_url || "";
            document.getElementById("pIsCurrent").checked = item.is_current_project || false;
            document.getElementById("pIsFlagship").checked = item.is_flagship || false;
            
            if (item.detail_page || item.project_url) {
                htmlLink.innerHTML = `Template: <a href="${item.detail_page || item.project_url}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                htmlLink.style.display = "block";
            }
            imgManagers.projects.setExisting(window.safeParseImages(item.img));
        } else {
            try {
                const getById = typeof window.CMS?.getProjectById === 'function' ? window.CMS.getProjectById : async (i) => {
                    const db = window.getDbClient(); if(!db) return null;
                    const {data} = await db.from('projects').select('*').eq('id',i).single(); return data;
                };
                const fetchedItem = await getById(id);
                if (fetchedItem) {
                    document.getElementById("pYear").value = fetchedItem.year || "";
                    document.getElementById("pTitle").value = fetchedItem.title || "";
                    document.getElementById("pLoc").value = fetchedItem.loc || fetchedItem.location || "";
                    document.getElementById("pCat").value = fetchedItem.cat || fetchedItem.category || "";
                    document.getElementById("pStatus").value = fetchedItem.status || "Completed";
                    document.getElementById("pAward").value = fetchedItem.award || "";
                    document.getElementById("pScope").value = fetchedItem.scope || "";
                    document.getElementById("pDetailManualUrl").value = fetchedItem.detail_page || fetchedItem.project_url || "";
                    document.getElementById("pIsCurrent").checked = fetchedItem.is_current_project || false;
                    document.getElementById("pIsFlagship").checked = fetchedItem.is_flagship || false;
                    
                    if (fetchedItem.detail_page || fetchedItem.project_url) {
                        htmlLink.innerHTML = `Template: <a href="${fetchedItem.detail_page || fetchedItem.project_url}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                        htmlLink.style.display = "block";
                    }
                    imgManagers.projects.setExisting(window.safeParseImages(fetchedItem.img));
                }
            } catch (err) { console.error("Failed to fetch project via API fallback:", err); }
        }
      }

      document.getElementById("projectForm").onsubmit = async (e) => {
        e.preventDefault();
        if(!validateRequiredFields("projectForm")) return;
        
        const btn = document.getElementById("saveProjectBtn");
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        const isEdit = !!document.getElementById("pId").value;
        const editId = document.getElementById("pId").value;
        const db = window.getDbClient();

        try {
            const uid = await getAuthUserId();
            const payloadSequence = imgManagers.projects.getFinalPayload();
            let finalUrls = [];
            
            let detailPageUrl = document.getElementById("pDetailManualUrl").value.trim() || null;
            const htmlFileInput = document.getElementById("pHtmlFile");
            if (htmlFileInput.files.length > 0) {
                if (db) {
                    const file = htmlFileInput.files[0];
                    const fileExt = file.name.split('.').pop();
                    const fileName = `template_${Math.random().toString(36).substring(2)}.${fileExt}`;
                    const { data: uploadData, error: htmlUploadErr } = await db.storage.from('projects').upload(fileName, file);
                    if (!htmlUploadErr && uploadData) {
                        const { data: publicUrlData } = db.storage.from('projects').getPublicUrl(fileName);
                        if (publicUrlData) detailPageUrl = publicUrlData.publicUrl;
                    } else {
                        throw new Error("HTML Template upload failed.");
                    }
                }
            }

            const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
            let uploadedUrls = [];

            if (filesToUpload.length > 0) {
                try {
                    if (typeof window.CMS?.uploadImages === 'function') {
                        uploadedUrls = await window.CMS.uploadImages(filesToUpload, 'projects');
                        if (!uploadedUrls) uploadedUrls = [];
                    } else if (db) {
                        for (let file of filesToUpload) {
                            const fileExt = file.name.split('.').pop();
                            const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                            const { data: uploadData, error } = await db.storage.from('projects').upload(fileName, file);
                            if (!error && uploadData) {
                                const { data: publicUrlData } = db.storage.from('projects').getPublicUrl(fileName);
                                if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                            }
                        }
                    }
                } catch (uploadErr) {
                    throw uploadErr;
                }
            }

            let uploadIndex = 0;
            for (let item of payloadSequence) {
                if (item.type === 'url') {
                    finalUrls.push(item.data);
                } else if (item.type === 'file') {
                    if (uploadedUrls[uploadIndex]) {
                        finalUrls.push(uploadedUrls[uploadIndex]);
                    }
                    uploadIndex++;
                }
            }

            const data = {
                year: document.getElementById("pYear").value.trim(),
                title: document.getElementById("pTitle").value.trim(),
                loc: document.getElementById("pLoc").value.trim(),
                cat: document.getElementById("pCat").value.trim(),
                status: document.getElementById("pStatus").value,
                award: document.getElementById("pAward").value.trim(),
                scope: document.getElementById("pScope").value.trim(),
                detail_page: detailPageUrl,
                img: finalUrls,
                is_current_project: document.getElementById("pIsCurrent").checked,
                is_flagship: document.getElementById("pIsFlagship").checked,
                created_by: uid
            };
            
            if (editId) data.id = editId;
            let newlySavedId = editId;

            if (typeof window.CMS?.saveProject === 'function') {
                const res = await window.CMS.saveProject(data);
                if (res && res.id) newlySavedId = res.id;
            } else {
                if (!db) throw new Error("Database client not found");
                const { data: savedData, error } = await db.from('projects').upsert(data).select();
                if (error) throw error;
                if (savedData && savedData[0]) newlySavedId = savedData[0].id;
            }

            window.closeProjectModal(); 
            await reloadAndPreserveScroll(loadProjects, isEdit, newlySavedId || null);
            loadDashboardStats();
            showToast("Project saved successfully!");
        } catch (err) { 
            console.error(err);
            if (err.message && err.message.includes('400')) {
                 showToast("Upload failed: Please ensure your Supabase Storage Bucket exists.", "error");
            } else {
                 showToast("Error saving project.", "error"); 
            }
        } finally { 
            btn.disabled = false; 
            btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
        }
      };
    };

    window.deleteProject = async (id) => {
        window.customConfirm("Delete Project", "Are you sure you want to permanently delete this project? This action cannot be undone.", async () => {
            try {
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("projects", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("projects").delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("projects"); 
                await reloadAndPreserveScroll(loadProjects, false, null);
                loadDashboardStats(); 
                showToast("Project deleted."); 
            } catch (err) { 
                console.error(err); 
                showToast("Failed to delete project.", "error");
            }
        });
    };

    async function loadProjects(force = false) {
        const el = document.getElementById("projectList");
        const search = document.getElementById("projectSearch")?.value.toLowerCase() || "";
        const statusFilter = document.getElementById("projectStatusFilter")?.value || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Projects...</p></div>`;
        
        try {
            const fetchFn = typeof window.CMS?.getProjects === 'function' ? window.CMS.getProjects : async () => {
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('projects').select('*').order('year',{ascending:false});
                return data;
            };
            let projects = await fetchFn(force) || [];
            window.appState.projects = projects; 
            
            if(search) projects = projects.filter(p => (p.title||'').toLowerCase().includes(search) || (p.loc||p.location||'').toLowerCase().includes(search));
            if(statusFilter) projects = projects.filter(p => p.status === statusFilter);

            if (!projects?.length) { el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No projects found.</p>`; return; }
            
            const renderItem = (p, index) => `
                <div class="item-row" data-id="${p.id}" style="animation-delay: ${index * 0.03}s; border-left-color: ${p.status === 'Completed' ? 'var(--success)' : p.status === 'Ongoing' ? 'var(--warning)' : 'var(--info)'};">
                    <div class="list-item-content">
                        ${window.safeParseImages(p.img)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(p.img)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-building"></i></div>`}
                        <div class="item-info">
                            <h4>
                                ${p.title || "Untitled"} 
                                ${p.is_flagship ? '<span class="badge gold" style="margin-left:8px;" title="Shows on Main Slider"><i class="fas fa-star"></i> Flagship</span>' : ''}
                                ${p.is_current_project ? '<span class="badge info" style="margin-left:4px;" title="Shows in Current Projects"><i class="fas fa-bolt"></i> Featured</span>' : ''}
                            </h4>
                            <p>
                                <span class="badge ${p.status === 'Completed' ? 'success' : p.status === 'Ongoing' ? 'warning' : 'info'}">${p.status}</span>
                                <span style="margin-left: 0.5rem;"><i class="fas fa-map-marker-alt"></i> ${p.loc || p.location || "—"}</span>
                                ${p.award ? `<span style="margin-left: 0.5rem; color: var(--brand-gold-hover);"><i class="fas fa-trophy"></i> Awarded</span>` : ''}
                                ${(p.detail_page || p.project_url) ? `<span style="margin-left: 0.5rem;"><a href="${p.detail_page || p.project_url}" target="_blank" style="color:var(--info);"><i class="fas fa-external-link-alt"></i></a></span>` : ''}
                            </p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openProjectModalAction('${p.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteProject('${p.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            el.innerHTML = window.renderGroupedByYear(projects, renderItem, 'year');
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;"><i class="fas fa-exclamation-triangle" style="font-size:3rem; margin-bottom:1rem; display:block;"></i>Failed to load projects.</p>`; }
    }
    window.loadProjects = loadProjects;

    // ================================================
    // CRUD Logic: AWARDS
    // ================================================
    window.openAwardModal = async (id = null) => {
      showModal("awardModal");
      document.getElementById("awardModalTitle").textContent = id ? "Edit Award" : "New Award";
      document.getElementById("awardForm").reset();
      imgManagers.awards.setExisting([]);
      document.getElementById("aId").value = id || "";

      if (id) {
        const item = window.appState.awards.find(a => a.id == id);
        if (item) {
            document.getElementById("aYear").value = item.year || "";
            document.getElementById("aTitle").value = item.title || "";
            document.getElementById("aIssuer").value = item.issuer || "";
            document.getElementById("aDesc").value = item.description || "";
            imgManagers.awards.setExisting(window.safeParseImages(item.img));
        } else {
            try {
                const getById = typeof window.CMS?.getAwardById === 'function' ? window.CMS.getAwardById : async (i) => {
                    const db = window.getDbClient(); if(!db) return null;
                    const {data} = await db.from('awards').select('*').eq('id',i).single(); return data;
                };
                const fetchedItem = await getById(id);
                if (fetchedItem) {
                    document.getElementById("aYear").value = fetchedItem.year || "";
                    document.getElementById("aTitle").value = fetchedItem.title || "";
                    document.getElementById("aIssuer").value = fetchedItem.issuer || "";
                    document.getElementById("aDesc").value = fetchedItem.description || "";
                    imgManagers.awards.setExisting(window.safeParseImages(fetchedItem.img));
                }
            } catch (err) {}
        }
      }

      document.getElementById("awardForm").onsubmit = async (e) => {
        e.preventDefault();
        if(!validateRequiredFields("awardForm")) return;

        const btn = document.getElementById("saveAwardBtn");
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        const isEdit = !!document.getElementById("aId").value;
        const editId = document.getElementById("aId").value;

        try {
            const uid = await getAuthUserId();
            const payloadSequence = imgManagers.awards.getFinalPayload();
            let finalUrls = [];
            
            const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
            let uploadedUrls = [];

            if (filesToUpload.length > 0) {
                try {
                    if (typeof window.CMS?.uploadImages === 'function') {
                        uploadedUrls = await window.CMS.uploadImages(filesToUpload, 'awards');
                        if(!uploadedUrls) uploadedUrls = [];
                    } else {
                        const db = window.getDbClient();
                        if (db) {
                            for (let file of filesToUpload) {
                                const fileExt = file.name.split('.').pop();
                                const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                const { data: uploadData, error } = await db.storage.from('awards').upload(fileName, file);
                                if (!error && uploadData) {
                                    const { data: publicUrlData } = db.storage.from('awards').getPublicUrl(fileName);
                                    if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                                }
                            }
                        }
                    }
                } catch (uploadErr) { throw uploadErr; }
            }

            let uploadIndex = 0;
            for (let item of payloadSequence) {
                if (item.type === 'url') {
                    finalUrls.push(item.data);
                } else if (item.type === 'file') {
                    if (uploadedUrls[uploadIndex]) {
                        finalUrls.push(uploadedUrls[uploadIndex]);
                    }
                    uploadIndex++;
                }
            }

            const data = {
                year: document.getElementById("aYear").value.trim(),
                title: document.getElementById("aTitle").value.trim(),
                issuer: document.getElementById("aIssuer").value.trim(),
                description: document.getElementById("aDesc").value.trim(),
                img: finalUrls,
                created_by: uid
            };
            
            if (editId) data.id = editId;
            let newlySavedId = editId;

            if (typeof window.CMS?.saveAward === 'function') {
                const res = await window.CMS.saveAward(data);
                if (res && res.id) newlySavedId = res.id;
            } else {
                const db = window.getDbClient();
                if (!db) throw new Error("Database client not found");
                const { data: savedData, error } = await db.from('awards').upsert(data).select();
                if (error) throw error;
                if (savedData && savedData[0]) newlySavedId = savedData[0].id;
            }

            window.closeAwardModal(); 
            await reloadAndPreserveScroll(loadAwards, isEdit, newlySavedId || null);
            loadDashboardStats(); 
            showToast("Award saved!"); 
        } catch (err) {
            showToast("Error saving award.", "error");
        } finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; }
      };
    };

    window.deleteAward = async (id) => {
        window.customConfirm("Delete Award", "Are you sure you want to permanently delete this award?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("awards", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("awards").delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("awards");
                await reloadAndPreserveScroll(loadAwards, false, null);
                loadDashboardStats();
                showToast("Award deleted."); 
            } catch (err) {
                showToast("Failed to delete award.", "error");
            }
        });
    };

    async function loadAwards(force = false) {
        const el = document.getElementById("awardList");
        const search = document.getElementById("awardSearch")?.value.toLowerCase() || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Awards...</p></div>`;
        try {
            const fetchFn = typeof window.CMS?.getAwards === 'function' ? window.CMS.getAwards : async () => {
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('awards').select('*').order('year',{ascending:false});
                return data;
            };
            let awards = await fetchFn(force) || [];
            window.appState.awards = awards;

            if (search) awards = awards.filter(a => (a.title||'').toLowerCase().includes(search) || (a.issuer||'').toLowerCase().includes(search));
            if (!awards?.length) { el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No awards found.</p>`; return; }
            
            const renderItem = (a, index) => `
                <div class="item-row" data-id="${a.id}" style="animation-delay: ${index * 0.03}s; border-left-color: var(--brand-gold);"> 
                    <div class="list-item-content">
                        ${window.safeParseImages(a.img)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(a.img)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-trophy"></i></div>`}
                        <div class="item-info">
                            <h4>${a.title}</h4>
                            <p><i class="fas fa-building"></i> ${a.issuer || 'Unknown Issuer'}</p>
                        </div> 
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="openAwardModal('${a.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="deleteAward('${a.id}')"><i class="fas fa-trash"></i></button>
                    </div> 
                </div>`;
            
            el.innerHTML = window.renderGroupedByYear(awards, renderItem, 'year');
        } catch(e) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load awards.</p>`; }
    }
    window.loadAwards = loadAwards;

    // ================================================
    // CRUD Logic: PRESS (Media)
    // ================================================
    window.openPressModal = async (id = null) => {
        showModal("pressModal");
        document.getElementById("pressModalTitle").textContent = id ? "Edit Media Recognition" : "New Media Recognition";
        document.getElementById("pressForm").reset();
        
        if (imgManagers.press) imgManagers.press.setExisting(null);
        document.getElementById("pressId").value = id || "";

        if (id) {
            const item = window.appState.press.find(c => c.id == id);
            if(item) {
                populatePressFields(item);
            } else {
                try {
                    const getById = typeof window.CMS?.getItemById === 'function' ? window.CMS.getItemById : async (t, i) => {
                        const db = window.getDbClient(); if(!db) return null;
                        const {data} = await db.from(t).select('*').eq('id',i).single(); return data;
                    };
                    const fetchedItem = await getById('press_clippings', id);
                    if (fetchedItem) populatePressFields(fetchedItem);
                } catch (err) { }
            }
        }

        function populatePressFields(data) {
            document.getElementById("pressPublication").value = data.media_source || data.publication || "";
            document.getElementById("pressTitle").value = data.title || "";
            document.getElementById("pressDate").value = data.publish_date || data.date || "";
            document.getElementById("pressSummary").value = data.summary || "";
            document.getElementById("pressLink").value = data.link || "";
            document.getElementById("pressIsFeatured").value = data.is_featured ? "true" : "false";
            
            const imgSrc = data.clipping_url || data.thumbnail_url || data.image || data.image_url;
            if (imgManagers.press && imgSrc) {
                imgManagers.press.setExisting(window.safeParseImages(imgSrc)[0]);
            }
        }

        document.getElementById("pressForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("pressForm")) return;

            const btn = document.getElementById("savePressBtn");
            btn.disabled = true; 
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("pressId").value;
            const editId = document.getElementById("pressId").value;

            try {
                const uid = await getAuthUserId();
                const payloadInfo = imgManagers.press.getFinalPayload();
                let finalUrl = payloadInfo.existingUrl;
                
                if (payloadInfo.newFile) {
                    try {
                        const uploadFn = typeof window.CMS?.uploadImages === 'function' ? window.CMS.uploadImages : null;
                        if(uploadFn) {
                            const uploadedUrls = await uploadFn([payloadInfo.newFile], 'press');
                            if (uploadedUrls && uploadedUrls.length > 0) finalUrl = uploadedUrls[0];
                        } else {
                            const db = window.getDbClient();
                            if(db) {
                                const fileExt = payloadInfo.newFile.name.split('.').pop();
                                const fileName = `${Math.random()}.${fileExt}`;
                                const { data: uploadData, error: uploadError } = await db.storage.from('press').upload(fileName, payloadInfo.newFile);
                                if (!uploadError && uploadData) {
                                    const { data: publicUrlData } = db.storage.from('press').getPublicUrl(fileName);
                                    if(publicUrlData) finalUrl = publicUrlData.publicUrl;
                                }
                            }
                        }
                    } catch (uploadErr) { throw uploadErr; }
                }

                const data = {
                    title: document.getElementById("pressTitle").value.trim(),
                    media_source: document.getElementById("pressPublication").value.trim(),
                    publish_date: document.getElementById("pressDate").value,
                    summary: document.getElementById("pressSummary").value.trim(),
                    link: document.getElementById("pressLink").value.trim(),
                    is_featured: document.getElementById("pressIsFeatured").value === "true",
                    thumbnail_url: finalUrl,
                    clipping_url: finalUrl,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.savePressCoverage === 'function') {
                    const res = await window.CMS.savePressCoverage(data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not available");
                    const { data: savedData, error } = await db.from('press_clippings').upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }
                
                window.closePressModal(); 
                await reloadAndPreserveScroll(loadPress, isEdit, newlySavedId || null);
                showToast("Clipping saved!");
            } catch (err) { 
                showToast("Error saving clipping.", "error"); 
            } finally { 
                btn.disabled = false; 
                btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
            }
        };
    };

    window.deletePress = async (id) => {
        window.customConfirm("Delete Media Recognition", "Delete this media clipping permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("press_clippings", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("press_clippings").delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("press_clippings");
                await reloadAndPreserveScroll(loadPress, false, null);
                showToast("Deleted."); 
            } catch (err) { 
                showToast("Failed to delete.", "error"); 
            }
        });
    };

    async function loadPress(force = false) {
        const el = document.getElementById("press-list");
        if (!el) return;
        const search = document.getElementById("pressSearch")?.value.toLowerCase() || "";
        
        if(!document.querySelector('.highlight-item')) {
            el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Media...</p></div>`;
        }

        try {
            const fetchFn = typeof window.CMS?.getPressClippings === 'function' ? window.CMS.getPressClippings : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('press_clippings').select('*').order('publish_date',{ascending:false}); 
                return data;
            };

            let clippings = await fetchFn(force) || [];
            window.appState.press = clippings;

            if (search) {
                clippings = clippings.filter(c => 
                    (c.title||'').toLowerCase().includes(search) || 
                    (c.media_source||'').toLowerCase().includes(search)
                );
            }

            if (!clippings.length) { 
                el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No media found.</p>`; 
                return; 
            }
            
            const renderItem = (item, index) => {
                const displayImg = item.clipping_url || item.thumbnail_url || item.image || item.image_url;
                return `
                <div class="item-row" data-id="${item.id}" style="animation-delay: ${index * 0.03}s; border-left-color: var(--info);">
                    <div class="list-item-content">
                        ${displayImg ? `<img loading="lazy" src="${window.safeParseImages(displayImg)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-newspaper"></i></div>`}
                        <div class="item-info">
                            <h4>${item.title || "Untitled"} ${item.is_featured ? '<span class="badge warning" style="margin-left:8px;">Featured</span>' : ''}</h4>
                            <p><strong>${item.media_source || "—"}</strong> &nbsp;|&nbsp; <i class="far fa-calendar-alt"></i> ${item.publish_date || ""}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openPressModal('${item.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deletePress('${item.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`;
            };
            el.innerHTML = window.renderGroupedByYear(clippings, renderItem, 'publish_date');
        } catch (err) { 
            el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load clippings.</p>`; 
        }
    }
    window.loadPress = loadPress;

   // ================================================
   // CRUD Logic: NEWS & REDESIGNED UI 
   // ================================================

   // News Selection Handlers
   window.isNewsSelectMode = false;
   
   window.toggleNewsSelectMode = () => {
       window.isNewsSelectMode = !window.isNewsSelectMode;
       const container = document.getElementById("page-news");
       const actionBtn = document.getElementById("toggleSelectNewsBtn");
       const bulkBar = document.getElementById("newsBulkActions");
       
       if(window.isNewsSelectMode) {
           container.classList.add("select-mode-active");
           actionBtn.style.display = "none";
           bulkBar.style.display = "flex";
       } else {
           container.classList.remove("select-mode-active");
           actionBtn.style.display = "flex";
           bulkBar.style.display = "none";
           // Deselect all
           document.querySelectorAll('.bulk-cb').forEach(cb => cb.checked = false);
           document.getElementById('selectAllNewsCb').checked = false;
           updateBulkCount();
       }
   };

   window.toggleSelectAllNews = (el) => {
       const checkboxes = document.querySelectorAll('.bulk-cb');
       checkboxes.forEach(cb => cb.checked = el.checked);
       updateBulkCount();
   };

   window.updateBulkCount = () => {
       const count = document.querySelectorAll('.bulk-cb:checked').length;
       document.getElementById('newsSelectedCount').textContent = `${count} record${count !== 1 ? 's' : ''} selected`;
   };

   window.bulkDeleteNews = async () => {
       const selectedCbs = document.querySelectorAll('.bulk-cb:checked');
       const ids = Array.from(selectedCbs).map(cb => cb.value);
       
       if(ids.length === 0) {
           showToast("Please select at least one record to delete.", "warning");
           return;
       }

       window.customConfirm("Bulk Delete News", `Are you sure you want to permanently delete ${ids.length} news record(s)? This cannot be undone.`, async () => {
           try {
               const db = window.getDbClient();
               if (!db) throw new Error("Database client not found");

               // Delete all selected
               const { error } = await db.from("news").delete().in('id', ids);
               if (error) throw error;
               
               clearCache("news"); 
               window.toggleNewsSelectMode(); // Exit select mode
               await reloadAndPreserveScroll(loadNews, false, null);
               loadDashboardStats(); 
               showToast(`Successfully deleted ${ids.length} records.`); 
           } catch (err) { 
               showToast("Failed to delete records.", "error");
           }
       });
   };

   // Helper for robust Date parsing to group cleanly
   function extractYearFromNewsDate(dateString) {
       if (!dateString) return 'Unknown';
       if (dateString.includes('/')) return dateString.split('/')[2];
       if (dateString.includes('-')) return dateString.split('-')[0];
       return 'Unknown';
   }

   // Redesigned renderGrouped specifically for News for perfection
   function renderNewsGroupedByYear(items) {
        const grouped = items.reduce((acc, item) => {
            const y = extractYearFromNewsDate(item.date);
            if (!acc[y]) acc[y] = [];
            acc[y].push(item);
            return acc;
        }, {});

        const years = Object.keys(grouped).sort((a, b) => {
            if (a === 'Unknown') return 1;
            if (b === 'Unknown') return -1;
            return parseInt(b) - parseInt(a);
        });

        return years.map(year => `
            <div class="year-group">
                <div class="year-header" onclick="this.parentElement.classList.toggle('collapsed')">
                    <h3>${year === 'Unknown' ? 'Others' : year} <span class="badge solid">${grouped[year].length}</span></h3>
                    <i class="fas fa-chevron-up toggle-icon"></i>
                </div>
                <div class="year-content list-container">
                    ${grouped[year].map((n, index) => `
                        <label class="item-row" data-id="${n.id}" style="animation-delay: ${index * 0.03}s; border-left-color: var(--sidebar-bg); display: flex; align-items: center; cursor: ${window.isNewsSelectMode ? 'pointer' : 'default'};"> 
                            <div class="list-item-content">
                                <input type="checkbox" class="bulk-cb" value="${n.id}" onchange="updateBulkCount()">
                                ${window.safeParseImages(n.img || n.photos)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(n.img || n.photos)[0]}" class="list-thumbnail" onclick="if(!window.isNewsSelectMode) openLightbox(this.src); event.preventDefault();">` : `<div class="empty-thumbnail"><i class="fas fa-bullhorn"></i></div>`}
                                <div class="item-info">
                                    <h4>${n.title || "Untitled"}</h4>
                                    <p><i class="far fa-calendar-alt"></i> ${n.date || "No date"} &nbsp;|&nbsp; <span class="badge solid">${n.category || 'General'}</span></p>
                                </div> 
                            </div>
                            <div class="actions">
                                <button type="button" class="btn-edit action-btn" onclick="openNewsModal('${n.id}'); event.preventDefault();"><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" class="btn-delete action-btn" onclick="deleteNews('${n.id}'); event.preventDefault();"><i class="fas fa-trash"></i></button>
                            </div> 
                        </label>
                    `).join('')}
                </div>
            </div>
        `).join('');
   }

   async function loadNews(force = false) {
       const el = document.getElementById("newsList");
       const search = document.getElementById("newsSearch")?.value.toLowerCase() || "";
       const categoryFilter = document.getElementById("newsCategoryFilter")?.value || "";
       
       if(!document.querySelector('.highlight-item')) {
           el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading News...</p></div>`;
       }

       try {
           const fetchFn = typeof window.CMS?.getNews === 'function' ? window.CMS.getNews : async () => {
               const db = window.getDbClient();
               if(!db) throw new Error("Database Client Not Initialized");
               const {data} = await db.from('news').select('*').order('date',{ascending:false});
               return data;
           };
           
           let items = await fetchFn(force) || [];
           window.appState.news = items;

           if (search) items = items.filter(n => (n.title || '').toLowerCase().includes(search));
           if (categoryFilter) items = items.filter(n => (n.category || 'General') === categoryFilter);
           
           if (!items?.length) { 
               el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No news found.</p>`; 
               return; 
           }
           
           el.innerHTML = renderNewsGroupedByYear(items);

           // Re-apply select mode UI state if active
           if(window.isNewsSelectMode) {
               document.getElementById("page-news").classList.add("select-mode-active");
           }

       } catch(e) {
           el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load news.</p>`;
       }
   }
   window.loadNews = loadNews;

   window.openNewsModal = async (id = null) => {
       showModal("newsModal");
       document.getElementById("newsModalTitle").textContent = id ? "Edit News Item" : "New News Item";
       document.getElementById("newsForm").reset();
       imgManagers.news.setExisting([]);
       document.getElementById("nId").value = id || "";

       if (id) {
            const item = window.appState.news.find(n => n.id == id);
            if(item) {
                let displayDate = "";
                if (item.date && item.date.includes('/')) {
                    const parts = item.date.split('/');
                    if(parts.length === 3) displayDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                } else if (item.date && item.date.includes('-')) {
                    displayDate = item.date;
                }
                document.getElementById("nDate").value = displayDate;
                document.getElementById("nCategory").value = item.category || "General";
                document.getElementById("nTitle").value = item.title || "";
                document.getElementById("nContent").value = item.description || "";
                imgManagers.news.setExisting(window.safeParseImages(item.img || item.photos));
            } else {
                try {
                    const getById = typeof window.CMS?.getNewsById === 'function' ? window.CMS.getNewsById : async (i) => {
                        const db = window.getDbClient(); if(!db) return null;
                        const {data} = await db.from('news').select('*').eq('id',i).single(); return data;
                    };
                    const fetchedItem = await getById(id);
                    if (fetchedItem) {
                        let displayDate = "";
                        if (fetchedItem.date && fetchedItem.date.includes('/')) {
                            const parts = fetchedItem.date.split('/');
                            displayDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                        } else {
                            displayDate = fetchedItem.date || "";
                        }
                        document.getElementById("nDate").value = displayDate;
                        document.getElementById("nCategory").value = fetchedItem.category || "General";
                        document.getElementById("nTitle").value = fetchedItem.title || "";
                        document.getElementById("nContent").value = fetchedItem.description || "";
                        imgManagers.news.setExisting(window.safeParseImages(fetchedItem.img || fetchedItem.photos));
                    }
                } catch (err) {}
            }
       }

       document.getElementById("newsForm").onsubmit = async (e) => {
           e.preventDefault();
           if(!validateRequiredFields("newsForm")) return;

           const btn = document.getElementById("saveNewsBtn");
           btn.disabled = true; 
           btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
           const isEdit = !!document.getElementById("nId").value;
           const editId = document.getElementById("nId").value;

           try {
               const uid = await getAuthUserId();
               const payloadSequence = imgManagers.news.getFinalPayload();
               let finalUrls = [];
               const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
               let uploadedUrls = [];

               if (filesToUpload.length > 0) {
                   try {
                       if (typeof window.CMS?.uploadImages === 'function') {
                           uploadedUrls = await window.CMS.uploadImages(filesToUpload, 'news');
                           if (!uploadedUrls) uploadedUrls = [];
                       } else {
                           const db = window.getDbClient();
                           if (db) {
                               for (let file of filesToUpload) {
                                   const fileExt = file.name.split('.').pop();
                                   const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                   const { data: uploadData, error } = await db.storage.from('news').upload(fileName, file);
                                   if (!error && uploadData) {
                                       const { data: publicUrlData } = db.storage.from('news').getPublicUrl(fileName);
                                       if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                                   }
                               }
                           }
                       }
                   } catch (uploadErr) { throw uploadErr; }
               }

               let uploadIndex = 0;
               for (let item of payloadSequence) {
                   if (item.type === 'url') {
                       finalUrls.push(item.data);
                   } else if (item.type === 'file') {
                       if (uploadedUrls[uploadIndex]) {
                           finalUrls.push(uploadedUrls[uploadIndex]);
                       }
                       uploadIndex++;
                   }
               }
               
               const inputDate = document.getElementById("nDate").value; 
               let databaseDate = null;
               if (inputDate) {
                   const [y, m, d] = inputDate.split('-');
                   databaseDate = `${d}/${m}/${y}`;
               }

               const data = {
                   year: inputDate ? parseInt(inputDate.substring(0, 4)) : new Date().getFullYear(),
                   title: document.getElementById("nTitle").value.trim(),
                   date: databaseDate, 
                   category: document.getElementById("nCategory").value,
                   description: document.getElementById("nContent").value.trim(),
                   img: finalUrls,
                   created_by: uid 
               };
               
               if (editId) data.id = editId;
               let newlySavedId = editId;

               if (typeof window.CMS?.saveNews === 'function') {
                   const res = await window.CMS.saveNews(data);
                   if (res && res.id) newlySavedId = res.id;
               } else {
                   const db = window.getDbClient();
                   if (!db) throw new Error("Database client not found");
                   const { data: savedData, error } = await db.from('news').upsert(data).select();
                   if (error) throw error;
                   if (savedData && savedData[0]) newlySavedId = savedData[0].id;
               }

               window.closeNewsModal(); 
               await reloadAndPreserveScroll(loadNews, isEdit, newlySavedId || null);
               loadDashboardStats(); 
               showToast("News item saved!"); 
           } catch (err) {
               showToast("Error saving news.", "error");
           } finally { 
               btn.disabled = false; 
               btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
           }
       };
   };

   window.deleteNews = async (id) => {
       window.customConfirm("Delete News", "Delete this news item permanently?", async () => {
           try { 
               if (typeof window.CMS?.deleteItem === 'function') {
                   await window.CMS.deleteItem("news", id);
               } else {
                   const db = window.getDbClient();
                   if (!db) throw new Error("Database client not found");
                   const { error } = await db.from("news").delete().eq('id', id);
                   if (error) throw error;
               }
               clearCache("news"); 
               await reloadAndPreserveScroll(loadNews, false, null);
               loadDashboardStats(); 
               showToast("News deleted."); 
           } catch (err) { 
               showToast("Failed to delete news.", "error");
           }
       });
   };
   
    // ================================================
    // CRUD Logic: CULTURE
    // ================================================
    const SUB_CAT_MAP = {
        festive: [ {v:'cny', t:'Chinese New Year'}, {v:'raya', t:'Hari Raya'}, {v:'midautumn', t:'Mid-Autumn'}, {v:'durian', t:'Durian Party'}, {v:'birthday', t:'Birthday'}, {v:'christmas', t:'Christmas'},{v:'wintersolstice',t:'Winter Solstice'},{v:'dumpling',t:'Dumpling Festival'},{v:'teambuilding', t:'Team Building'}, {v:'others', t:'Others'} ],
        csr: [ {v:'charity', t:'Charity'}, {v:'community', t:'Community'} ],
        work: [ {v:'sports', t:'Sports Day'}, {v:'seminar', t:'Seminar'} ],
        training: [ {v:'internal', t:'Internal Training'} ],
        intern: [ {v:'intern',t:'Industrial Training'} ],
        sponsor:[ {v:'sponsor' , t:'Sponsorship'}]
    };

    window.updateModalSubOptions = function(selectedVal = 'all') {
        const typeEl = document.getElementById('cType');
        const subSelect = document.getElementById('cSubCategory');
        if (!typeEl || !subSelect) return;
        const mainType = typeEl.value;
        subSelect.innerHTML = '<option value="all">Default / All</option>';
        if (SUB_CAT_MAP[mainType]) {
            SUB_CAT_MAP[mainType].forEach(opt => {
                const el = document.createElement('option');
                el.value = opt.v; el.textContent = opt.t;
                if(opt.v === selectedVal) el.selected = true;
                subSelect.appendChild(el);
            });
        }
    };

    window.openCultureModal = async (id = null) => {
        showModal("cultureModal");
        document.getElementById("cultureModalTitle").textContent = id ? "Edit Event" : "New Event";
        document.getElementById("cultureForm").reset();
        imgManagers.culture.setExisting([]);
        document.getElementById("cId").value = id || "";
        
        document.getElementById("cId").dataset.table = 'culture';

        if (id) {
            const item = window.appState.culture.find(c => c.id == id);
            if(item) {
                document.getElementById("cId").dataset.table = item._sourceTable || 'culture';
                document.getElementById("cYear").value = item.year || "";
                document.getElementById("cType").value = item.type || "";
                window.updateModalSubOptions(item.sub_category || 'all');
                document.getElementById("cName").value = item.name || "";
                document.getElementById("cLocation").value = item.location || "";
                document.getElementById("cDescription").value = item.description || "";
                imgManagers.culture.setExisting(window.safeParseImages(item.img));
            } else {
                try {
                    const db = window.getDbClient();
                    if(db) {
                        let fetchedItem = null;
                        let sTable = 'culture';
                        
                        const {data: d1} = await db.from('culture').select('*').eq('id',id).single();
                        if (d1) { 
                            fetchedItem = d1; 
                        } else {
                            const {data: d2} = await db.from('culture_sorted').select('*').eq('id',id).single();
                            if(d2) { 
                                fetchedItem = d2; 
                                sTable = 'culture_sorted'; 
                            }
                        }
                        
                        if (fetchedItem) {
                            document.getElementById("cId").dataset.table = sTable;
                            document.getElementById("cYear").value = fetchedItem.year || "";
                            document.getElementById("cType").value = fetchedItem.type || "";
                            window.updateModalSubOptions(fetchedItem.sub_category || 'all');
                            document.getElementById("cName").value = fetchedItem.name || "";
                            document.getElementById("cLocation").value = fetchedItem.location || "";
                            document.getElementById("cDescription").value = fetchedItem.description || "";
                            imgManagers.culture.setExisting(window.safeParseImages(fetchedItem.img));
                        }
                    }
                } catch (err) {}
            }
        } else {
            window.updateModalSubOptions();
        }

        document.getElementById("cultureForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("cultureForm")) return;

            const btn = document.getElementById("saveCultureBtn");
            btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("cId").value;
            const editId = document.getElementById("cId").value;
            const targetTable = document.getElementById("cId").dataset.table || 'culture';
            const targetBucket = 'culture';

            try {
                const uid = await getAuthUserId();
                const payloadSequence = imgManagers.culture.getFinalPayload();
                let finalUrls = [];
                const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
                let uploadedUrls = [];

                if (filesToUpload.length > 0) {
                    try {
                        if (typeof window.CMS?.uploadImages === 'function') {
                            uploadedUrls = await window.CMS.uploadImages(filesToUpload, targetBucket);
                            if (!uploadedUrls) uploadedUrls = [];
                        } else {
                            const db = window.getDbClient();
                            if (db) {
                                for (let file of filesToUpload) {
                                    const fileExt = file.name.split('.').pop();
                                    const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                    const { data: uploadData, error } = await db.storage.from(targetBucket).upload(fileName, file);
                                    if (!error && uploadData) {
                                        const { data: publicUrlData } = db.storage.from(targetBucket).getPublicUrl(fileName);
                                        if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                                    }
                                }
                            }
                        }
                    } catch (uploadErr) { throw uploadErr; }
                }

                let uploadIndex = 0;
                for (let item of payloadSequence) {
                    if (item.type === 'url') {
                        finalUrls.push(item.data);
                    } else if (item.type === 'file') {
                        if (uploadedUrls[uploadIndex]) {
                            finalUrls.push(uploadedUrls[uploadIndex]);
                        }
                        uploadIndex++;
                    }
                }

                const yearInput = parseInt(document.getElementById("cYear").value.trim());

                const data = {
                    year: !isNaN(yearInput) ? yearInput : null,
                    name: document.getElementById("cName").value.trim(),
                    location: document.getElementById("cLocation").value.trim(),
                    type: document.getElementById("cType").value,
                    sub_category: document.getElementById("cSubCategory").value,
                    description: document.getElementById("cDescription").value.trim(),
                    img: finalUrls,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.saveItem === 'function') {
                    const res = await window.CMS.saveItem(targetTable, data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { data: savedData, error } = await db.from(targetTable).upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }

                window.closeCultureModal(); 
                await reloadAndPreserveScroll(loadCulture, isEdit, newlySavedId || null);
                loadDashboardStats(); 
                showToast("Event saved successfully!"); 
            } catch (err) { 
                showToast("Error saving event.", "error"); 
            } finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; }
        };
    };

    window.deleteCulture = async (id, sourceTable = 'culture') => {
        window.customConfirm("Delete Event", "Delete this culture event permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem(sourceTable, id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from(sourceTable).delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("culture"); 
                clearCache("culture_sorted");
                await reloadAndPreserveScroll(loadCulture, false, null);
                loadDashboardStats(); 
                showToast("Event deleted."); 
            } catch (err) {
                showToast("Failed to delete event.", "error");
            }
        });
    };

    async function loadCulture(force = false) {
        const el = document.getElementById("cultureList");
        const search = document.getElementById("cultureSearch")?.value.toLowerCase() || "";
        const yF = document.getElementById("cultureYearFilter")?.value || "";
        const tF = document.getElementById("cultureTypeFilter")?.value || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Events...</p></div>`;
        try {
            const db = window.getDbClient();
            if(!db) throw new Error("Database Client Not Initialized");

            const [cultRes, sortRes] = await Promise.allSettled([
                db.from('culture').select('*'),
                db.from('culture_sorted').select('*')
            ]);

            let items = [];
            
            if (cultRes.status === 'fulfilled' && cultRes.value.data) {
                const cData = cultRes.value.data.map(item => ({ ...item, _sourceTable: 'culture' }));
                items.push(...cData);
            }
            if (sortRes.status === 'fulfilled' && sortRes.value.data) {
                const sData = sortRes.value.data.map(item => ({ ...item, _sourceTable: 'culture_sorted' }));
                items.push(...sData);
            }

            const uniqueItems = [];
            const ids = new Set();
            for (const item of items) {
                if (!ids.has(item.id)) {
                    ids.add(item.id);
                    uniqueItems.push(item);
                }
            }
            items = uniqueItems;

            items.sort((a, b) => (b.year || 0) - (a.year || 0));

            window.appState.culture = items;
            
            const ys = document.getElementById("cultureYearFilter");
            if(ys) {
                const currentVal = ys.value;
                const years = [...new Set(items.map(i => i.year))].filter(Boolean).sort((a, b) => b - a);
                ys.innerHTML = '<option value="">All Years</option>' + years.map(y => `<option value="${y}" ${y == currentVal ? 'selected' : ''}>${y}</option>`).join('');
            }
            
            if(search) items = items.filter(i => (i.name||"").toLowerCase().includes(search));
            if(yF) items = items.filter(i => String(i.year) === String(yF));
            if(tF) items = items.filter(i => i.type === tF);
            
            if(!items.length) { 
                if(document.getElementById("cultureEmpty")) document.getElementById("cultureEmpty").style.display="flex"; 
                el.innerHTML=""; return; 
            }
            if(document.getElementById("cultureEmpty")) document.getElementById("cultureEmpty").style.display="none";

            const renderItem = (item, index) => `
                <div class="item-row" data-id="${item.id}" style="animation-delay: ${index * 0.03}s; border-left-color: #8B5CF6;">
                    <div class="list-item-content">
                        ${window.safeParseImages(item.img)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(item.img)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-users"></i></div>`}
                        <div class="item-info">
                            <h4>${item.name || "Untitled"}</h4>
                            <p style="text-transform:capitalize;">${item.type || ""} &nbsp;|&nbsp; <i class="fas fa-map-marker-alt"></i> ${item.location || "Multiple locations"}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openCultureModal('${item.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteCulture('${item.id}', '${item._sourceTable || 'culture'}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            el.innerHTML = window.renderGroupedByYear(items, renderItem, 'year');
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load culture events.</p>`; }
    }
    window.loadCulture = loadCulture;

    // ================================================
    // CRUD Logic: CERTIFICATIONS
    // ================================================
    const CertificationManager = (function() {
        const CATEGORIES = [
            { id: 'cidb', table: 'cidb_star_ratings', label: 'CIDB Star Ratings', icon: 'fa-award', color: 'var(--warning)' },
            { id: 'shassic', table: 'shassic_scores', label: 'SHASSIC Scores', icon: 'fa-shield-halved', color: 'var(--success)' },
            { id: 'gbi', table: 'gbi_facilitator_certificates', label: 'GBI Facilitator', icon: 'fa-leaf', color: 'var(--success)' },
            { id: 'qlassic', table: 'qlassic_conquas_scores', label: 'QLASSIC / CONQUAS', icon: 'fa-check-double', color: 'var(--info)' }
        ];

        const openModal = (table, existingData = null) => {
            document.getElementById("certTable").value = table;
            document.getElementById("certId").value = existingData?.id || '';
            document.getElementById("certModalTitle").textContent = existingData ? `Edit Certification` : `New Certification`;

            document.getElementById("certSpecificFields").innerHTML = `
                <div class="form-row">
                    <div class="form-group half">
                        <label>Assessment Year <span class="required">*</span></label>
                        <input type="number" id="cCertYear" required min="1990" max="2100" value="${existingData?.year || new Date().getFullYear()}">
                    </div>
                    <div class="form-group half">
                        <label>Grade / Level <span class="required">*</span></label>
                        <input type="text" id="cGrade" required placeholder="e.g. G7, 4 Stars" value="${existingData?.grade || ''}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group half">
                        <label>Star Rating (0-5)</label>
                        <input type="number" id="cStar" min="0" max="5" value="${existingData?.star_rating !== undefined && existingData?.star_rating !== null ? existingData.star_rating : ''}">
                    </div>
                    <div class="form-group half">
                        <label>Score (%)</label>
                        <input type="number" id="cScore" step="0.01" min="0" max="100" placeholder="0.00" value="${existingData?.score || ''}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Project / Remarks</label>
                    <textarea id="cRemarks" rows="3" placeholder="Detail the project name...">${existingData?.remarks || ''}</textarea>
                </div>
                <div class="form-group">
                    <label>Document (Image/PDF)</label>
                    <div id="certDrop" class="drag-area">
                        <i class="fas fa-file-pdf"></i>
                        <div style="font-weight: 600; font-size: 1.1rem;">Click or drag to upload</div>
                    </div>
                    <input type="file" id="certFile" hidden accept="image/*,application/pdf">
                    <div id="certPreview" class="preview-container"></div>
                </div>`;

            imgManagers.cert = new SingleImageManager("certDrop", "certFile", "certPreview");
            if(existingData?.document_url) {
                imgManagers.cert.setExisting(window.safeParseImages(existingData.document_url)[0] || existingData.document_url);
            }

            document.getElementById("certForm").onsubmit = async (e) => {
                e.preventDefault();
                if(!validateRequiredFields("certForm")) return;

                const btn = document.getElementById("saveCertBtn");
                btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                const isEdit = !!document.getElementById("certId").value;
                const editingId = document.getElementById("certId").value;
                
                const submittedTable = document.getElementById("certTable").value;

                const db = window.getDbClient();
                if (!db) {
                   showToast("Database client missing.", "error"); 
                   btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record';
                   return;
                }

                try {
                    const uid = await getAuthUserId();
                    const payloadInfo = imgManagers.cert.getFinalPayload();
                    let finalUrl = payloadInfo.existingUrl;

                    if (payloadInfo.newFile) {
                        try {
                            if (typeof window.CMS?.uploadImages === 'function') {
                                const uploaded = await window.CMS.uploadImages([payloadInfo.newFile], `certs/${submittedTable}`);
                                if (uploaded?.length) finalUrl = uploaded[0];
                            } else {
                                const db = window.getDbClient();
                                if (db) {
                                    const fileExt = payloadInfo.newFile.name.split('.').pop();
                                    const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                    const { data: uploadData, error } = await db.storage.from('certifications').upload(fileName, payloadInfo.newFile);
                                    if (!error && uploadData) {
                                        const { data: publicUrlData } = db.storage.from('certifications').getPublicUrl(fileName);
                                        if(publicUrlData) finalUrl = publicUrlData.publicUrl;
                                    }
                                }
                            }
                        } catch (uploadErr) {
                            throw new Error("Upload failed");
                        }
                    }

                    const starRatingInput = parseInt(document.getElementById('cStar').value);
                    const yearInput = parseInt(document.getElementById('cCertYear').value);

                    const payload = {
                        year: !isNaN(yearInput) ? yearInput : new Date().getFullYear(),
                        grade: document.getElementById('cGrade').value.trim(),
                        star_rating: !isNaN(starRatingInput) ? starRatingInput : 0,
                        score: document.getElementById('cScore').value ? parseFloat(document.getElementById('cScore').value) : null,
                        remarks: document.getElementById('cRemarks').value.trim() || null,
                        document_url: finalUrl,
                        created_by: uid
                    };
                    
                    if (editingId) payload.id = editingId;

                    const { data, error } = await db.from(submittedTable).upsert(payload).select();
                    if (error) throw error;

                    window.closeCertModal();
                    let newlySavedId = data && data[0] ? data[0].id : editingId;
                    await reloadAndPreserveScroll(loadData, isEdit, newlySavedId || null);
                    showToast("Record saved.");
                } catch (err) { showToast("Error saving record.", "error"); } finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; }
            };

            showModal("certModal");
        };

        const loadData = async () => {
            const container = document.getElementById("certificationsList");
            if (!container) return;
            if(!document.querySelector('.highlight-item')) container.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;

            const db = window.getDbClient();
            if (!db) {
              container.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Database disconnected.</p>`;
              return;
            }

            try {
                const results = await Promise.allSettled( CATEGORIES.map(cat => db.from(cat.table).select('*').order('year', { ascending: false })) );
                
                let html = '';
                results.forEach((res, i) => {
                    const cat = CATEGORIES[i];
                    let items = [];
                    let errorMsg = '';
                    
                    if (res.status === 'fulfilled') {
                        if (res.value.error) {
                            errorMsg = res.value.error.message;
                        } else {
                            items = res.value.data || [];
                        }
                    } else {
                        errorMsg = res.reason;
                    }
                    
                    const renderCertItem = (item, idx) => {
                        const docUrlStr = String(item.document_url || '');
                        const isPdf = docUrlStr.toLowerCase().includes('.pdf');
                        const parsedUrl = item.document_url ? window.safeParseImages(item.document_url)[0] : '';
                        return `
                        <div class="item-row" data-id="${item.id}" style="border-left-color: ${cat.color}; animation-delay: ${idx * 0.05}s;">
                            <div class="list-item-content">
                                ${isPdf ? `<div class="empty-thumbnail" style="cursor:pointer;" onclick="window.open('${parsedUrl}', '_blank')"><i class="fas fa-file-pdf" style="color:var(--danger)"></i></div>` : (parsedUrl ? `<img loading="lazy" src="${parsedUrl}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-file-pdf"></i></div>`)}
                                <div class="item-info">
                                    <h4><span class="badge solid">${item.year}</span> ${item.grade || 'No Grade'}</h4>
                                    <p>${item.remarks || 'No remarks.'}</p>
                                </div>
                            </div>
                            <div class="actions">
                                <button class="btn-edit" onclick="CertificationManager.edit('${cat.table}', '${item.id}')"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn-delete" onclick="CertificationManager.remove('${cat.table}', '${item.id}')"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        `;
                    };

                    const groupedHtml = items.length > 0 ? window.renderGroupedByYear(items, renderCertItem, 'year') : '';

                    html += `
                        <div style="margin-bottom: 2rem; background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                            <h3 style="display:flex; align-items:center; gap:0.75rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom:1rem; font-size: 1.2rem;">
                                <i class="fas ${cat.icon}" style="color:${cat.color};"></i> <span>${cat.label}</span> 
                                <span class="badge solid" style="margin-left: auto;">${items.length} Records</span>
                            </h3>
                            ${errorMsg ? `<p style="color:var(--danger); font-size:0.95rem;">Error loading: ${errorMsg}.</p>` : ''}
                            ${(!errorMsg && items.length === 0) ? '<p style="color:var(--text-muted); font-size:0.95rem;">No records found.</p>' : `<div class="list-container">${groupedHtml}</div>`}
                        </div>`;
                });
                container.innerHTML = html;
            } catch (err) { container.innerHTML = `<p style="color:var(--danger); text-align: center;">Failed to load data.</p>`; }
        };

        return { 
            init: loadData, 
            create: (table) => openModal(table), 
            edit: async (table, id) => { 
                const db = window.getDbClient();
                if (!db) return;
                const { data } = await db.from(table).select('*').eq('id', id).single(); 
                if (data) openModal(table, data); 
            }, 
            remove: async (table, id) => { 
                window.customConfirm("Delete Certification", "Permanently delete this certification?", async () => {
                    try {
                        if (typeof window.CMS?.deleteItem === 'function') {
                            await window.CMS.deleteItem(table, id);
                        } else {
                            const db = window.getDbClient();
                            if (!db) throw new Error("Database client not found");
                            const { error } = await db.from(table).delete().eq('id', id);
                            if (error) throw error;
                        }
                        await reloadAndPreserveScroll(loadData, false, null); 
                        showToast("Record deleted.");
                    } catch (err) {
                        showToast("Failed to delete record.", "error");
                    }
                });
            } 
        };
    })();
    window.CertificationManager = CertificationManager;

    // ================================================
    // CRUD Logic: INQUIRIES
    // ================================================
    window.openInquiryModal = async (id) => {
        showModal("inquiryModal");
        try {
            let inquiry = window.appState.inquiries.find(i => i.id == id);
            if(!inquiry) {
                const getInq = typeof window.CMS?.getInquiryById === 'function' ? window.CMS.getInquiryById : async (i) => { 
                    const db = window.getDbClient();
                    if(!db) throw new Error("Database Missing");
                    const {data} = await db.from('inquiries').select('*').eq('id',i).single(); 
                    return data; 
                };
                inquiry = await getInq(id); 
            }
            if (!inquiry) throw new Error("Inquiry not found");
            
            document.getElementById("iId").value = id;
            document.getElementById("iFullName").value = inquiry.full_name || inquiry.name || "—";
            document.getElementById("iCompany").value = inquiry.company || "—";
            document.getElementById("iEmail").value = inquiry.email || "—";
            document.getElementById("iPhone").value = inquiry.phone || "—";
            document.getElementById("iNature").value = inquiry.nature || "—";
            document.getElementById("iMessage").value = inquiry.message || "";
            document.getElementById("iStatus").value = inquiry.status || "new";
            document.getElementById("iAdminNotes").value = inquiry.admin_notes || "";

            const arcBtn = document.getElementById("archiveInquiryBtn");
            if(arcBtn) {
                if((inquiry.status || "new").toLowerCase() === 'archived') {
                    arcBtn.style.display = 'none';
                } else {
                    arcBtn.style.display = 'block';
                }
            }

        } catch (err) { showToast("Could not load inquiry.", "error");}
    };

    document.getElementById("saveInquiryBtn")?.addEventListener("click", async () => {
        const id = document.getElementById("iId").value;
        const status = document.getElementById("iStatus").value;
        const admin_notes = document.getElementById("iAdminNotes").value;
        try {
            if (typeof window.CMS?.updateInquiry === 'function') {
                await window.CMS.updateInquiry({id, status, admin_notes});
            } else {
                const db = window.getDbClient();
                const {error} = await db.from('inquiries').update({status, admin_notes}).eq('id', id); 
                if (error) throw error;
            }
            
            window.closeInquiryModal();
            await reloadAndPreserveScroll(loadInquiries, true, id);
            if (typeof loadArchivedInquiries === 'function') loadArchivedInquiries(true); 
            refreshUnreadBadge();
            showToast("Inquiry updated.");
        } catch(e) {
            showToast("Failed to update inquiry.", "error");
        }
    });

    document.getElementById("archiveInquiryBtn")?.addEventListener("click", async function() {
        window.customConfirm("Archive Inquiry", "Move this inquiry to the archive?", async () => {
            const id = document.getElementById("iId").value;
            try {
                if (typeof window.CMS?.updateInquiry === 'function') {
                    await window.CMS.updateInquiry({id, status: 'archived'});
                } else {
                    const db = window.getDbClient();
                    const {error} = await db.from('inquiries').update({status: 'archived'}).eq('id', id); 
                    if (error) throw error;
                }
                
                window.closeInquiryModal();
                await reloadAndPreserveScroll(loadInquiries, false, null);
                if (typeof loadArchivedInquiries === 'function') loadArchivedInquiries(true); 
                refreshUnreadBadge();
                showToast("Inquiry Archived.");
            } catch(e) { 
                showToast("Failed to archive inquiry.", "error"); 
            }
        });
    });

    window.unarchiveInquiry = async (id) => {
        window.customConfirm("Unarchive Inquiry", "Restore this inquiry to active status?", async () => {
            try {
                if (typeof window.CMS?.updateInquiry === 'function') {
                    await window.CMS.updateInquiry({id, status: 'new'});
                } else {
                    const db = window.getDbClient();
                    const {error} = await db.from('inquiries').update({status: 'new'}).eq('id', id);
                    if (error) throw error;
                }
                await reloadAndPreserveScroll(loadArchivedInquiries, false, null);
                if (typeof loadInquiries === 'function') loadInquiries(true);
                refreshUnreadBadge();
                showToast("Inquiry restored to active.");
            } catch(e) {
                showToast("Failed to unarchive.", "error");
            }
        });
    };

    window.deleteInquiry = async (id) => {
        window.customConfirm("Delete Permanently", "Are you sure you want to completely delete this inquiry? This cannot be undone.", async () => {
            try {
                const db = window.getDbClient();
                const {error} = await db.from('inquiries').delete().eq('id', id);
                if (error) throw error;
                
                await reloadAndPreserveScroll(loadInquiries, false, null);
                if(typeof loadArchivedInquiries === 'function') loadArchivedInquiries(true);
                refreshUnreadBadge();
                showToast("Inquiry deleted permanently.");
            } catch(e) {
                showToast("Failed to delete.", "error");
            }
        });
    };

    async function loadInquiries(force = false) {
        const el = document.getElementById("inquiryList");
        const search = document.getElementById("inquirySearch")?.value.toLowerCase() || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;
        try {
            const getInq = typeof window.CMS?.getInquiries === 'function' ? window.CMS.getInquiries : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('inquiries').select('*').order('created_at',{ascending:false}); 
                return data; 
            };
            const all = await getInq(force) || [];
            let active = all.filter(i => (i.status || "new").toLowerCase() !== "archived");
            window.appState.inquiries = all; 
            
            if (search) active = active.filter(i => (i.full_name||'').toLowerCase().includes(search) || (i.email||'').toLowerCase().includes(search));
            if (!active.length) { el.innerHTML = `<p style="text-align:center; padding:4rem; color: var(--text-muted);"><i class="fas fa-check-circle" style="font-size:3rem; margin-bottom:1rem; display:block; color: #CBD5E1;"></i>All caught up! No active inquiries.</p>`; return; }
            
            el.innerHTML = active.map((i, index) => `
                <div class="item-row" data-id="${i.id}" style="animation-delay: ${index * 0.03}s; border-left-color: ${i.status === 'new' ? 'var(--danger)' : 'var(--warning)'};">
                    <div class="item-info">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                            <h4 style="margin:0;"><i class="fas fa-user-circle" style="color:var(--text-muted); margin-right: 6px;"></i> ${i.full_name || i.name || "Anonymous"}</h4>
                            <span class="badge ${i.status === 'new' ? 'danger' : 'warning'}">${(i.status || 'New').toUpperCase()}</span>
                        </div>
                        <p style="margin-bottom: 0.5rem;"><i class="fas fa-envelope"></i> ${i.email || "—"} &nbsp;|&nbsp; <i class="fas fa-phone"></i> ${i.phone || "—"}</p>
                        <p style="background:#F8FAFC; padding:10px; border-radius:4px; border-left: 2px solid #CBD5E1; font-style: italic; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">"${i.message ? i.message : ''}"</p>
                    </div>
                    <div class="actions">
                        <button class="btn-view" onclick="window.openInquiryModal('${i.id}')"><i class="fas fa-reply"></i> View</button>
                        <button class="btn-delete" onclick="window.deleteInquiry('${i.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load inquiries.</p>`; }
    }
    window.loadInquiries = loadInquiries;

    async function loadArchivedInquiries(force = false) {
        const el = document.getElementById("archivedInquiryList");
        if (!el) return;
        const search = document.getElementById("archivedInquirySearch")?.value.toLowerCase() || "";
        try {
            const getInq = typeof window.CMS?.getInquiries === 'function' ? window.CMS.getInquiries : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('inquiries').select('*').order('created_at',{ascending:false}); 
                return data; 
            };
            const all = await getInq(force) || [];
            let archived = all.filter(i => (i.status || "new").toLowerCase() === "archived");
            window.appState.inquiries = all; 
            
            if (search) archived = archived.filter(i => (i.full_name||'').toLowerCase().includes(search) || (i.email||'').toLowerCase().includes(search));
            if (!archived.length) { el.innerHTML = `<p style="text-align:center; padding:3rem; color: var(--text-muted);">No archived inquiries.</p>`; return; }
            
            el.innerHTML = archived.map((i, index) => `
                <div class="item-row" data-id="${i.id}" style="opacity:0.85; border-left-color: var(--success); animation-delay: ${index * 0.03}s;">
                    <div class="item-info">
                        <h4><i class="fas fa-archive" style="color:var(--success); margin-right: 6px;"></i> ${i.full_name || "Anonymous"}</h4>
                        <p><i class="fas fa-envelope"></i> ${i.email || "—"}</p>
                    </div>
                    <div class="actions">
                        <button class="btn-view" onclick="window.unarchiveInquiry('${i.id}')" style="color: var(--success); border-color: #A7F3D0;"><i class="fas fa-box-open"></i> Unarchive</button>
                        <button class="btn-delete" onclick="window.deleteInquiry('${i.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="color:var(--danger)">Failed to load archived inquiries.</p>`; }
    }
    window.loadArchivedInquiries = loadArchivedInquiries;

    // ================================================
    // CRUD Logic: FEATURED PROJECTS (Current Projects)
    // ================================================
    window.openCurrentProjectModal = async (id = null) => {
        showModal("currentProjectModal");
        document.getElementById("currentProjectModalTitle").textContent = id ? "Edit Flagship Project" : "New Flagship Project";
        document.getElementById("currentProjectForm").reset();
        document.getElementById("cpHtmlFile").value = "";
        
        if (imgManagers.currentProject) imgManagers.currentProject.setExisting(null);
        document.getElementById("cpId").value = id || "";

        const htmlLink = document.getElementById("cpHtmlLink");
        htmlLink.style.display = "none";

        if (id) {
            const item = window.appState.currentProjects.find(p => p.id == id);
            if(item) {
                document.getElementById("cpTitle").value = item.title || "";
                document.getElementById("cpLocation").value = item.location || "";
                document.getElementById("cpDescription").value = item.description || "";
                document.getElementById("cpDetailPage").value = item.detail_page || "";
                document.getElementById("cpIsFeatured").checked = item.is_featured !== false;
                document.getElementById("cpSortOrder").value = item.sort_order ?? 10;
                
                if (item.detail_page) {
                    htmlLink.innerHTML = `Template: <a href="${item.detail_page}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                    htmlLink.style.display = "block";
                }

                if (imgManagers.currentProject) imgManagers.currentProject.setExisting(window.safeParseImages(item.image)[0]);
            } else {
                try {
                    const fn = typeof window.CMS?.getCurrentProjectById === 'function' ? window.CMS.getCurrentProjectById : async (i) => { 
                        const db = window.getDbClient();
                        if(!db) return null;
                        const {data} = await db.from('current_projects').select('*').eq('id',i).single(); 
                        return data; 
                    };
                    const fetchedItem = await fn(id);
                    if (fetchedItem) {
                        document.getElementById("cpTitle").value = fetchedItem.title || "";
                        document.getElementById("cpLocation").value = fetchedItem.location || "";
                        document.getElementById("cpDescription").value = fetchedItem.description || "";
                        document.getElementById("cpDetailPage").value = fetchedItem.detail_page || "";
                        document.getElementById("cpIsFeatured").checked = fetchedItem.is_featured !== false;
                        document.getElementById("cpSortOrder").value = fetchedItem.sort_order ?? 10;
                        
                        if (fetchedItem.detail_page) {
                            htmlLink.innerHTML = `Template: <a href="${fetchedItem.detail_page}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                            htmlLink.style.display = "block";
                        }

                        if (imgManagers.currentProject) imgManagers.currentProject.setExisting(window.safeParseImages(fetchedItem.image)[0]);
                    }
                } catch (err) {}
            }
        }

        document.getElementById("currentProjectForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("currentProjectForm")) return;

            const btn = document.getElementById("saveCurrentProjectBtn");
            btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("cpId").value;
            const editId = document.getElementById("cpId").value;
            const db = window.getDbClient();

            try {
                const uid = await getAuthUserId();
                const payloadInfo = imgManagers.currentProject.getFinalPayload();
                let finalUrl = payloadInfo.existingUrl;

                let detailPageUrl = document.getElementById("cpDetailPage").value.trim() || null;
                const htmlFileInput = document.getElementById("cpHtmlFile");
                if (htmlFileInput.files.length > 0) {
                    if (db) {
                        const file = htmlFileInput.files[0];
                        const fileExt = file.name.split('.').pop();
                        const fileName = `template_flagship_${Math.random().toString(36).substring(2)}.${fileExt}`;
                        const { data: uploadData, error: htmlUploadErr } = await db.storage.from('projects').upload(fileName, file);
                        if (!htmlUploadErr && uploadData) {
                            const { data: publicUrlData } = db.storage.from('projects').getPublicUrl(fileName);
                            if (publicUrlData) detailPageUrl = publicUrlData.publicUrl;
                        } else {
                            throw new Error("HTML Template upload failed.");
                        }
                    }
                }

                if (payloadInfo.newFile) {
                    try {
                        const uploadFn = typeof window.CMS?.uploadImages === 'function' ? window.CMS.uploadImages : null;
                        if(uploadFn) {
                            const uploadedUrls = await uploadFn([payloadInfo.newFile], 'featured');
                            if (uploadedUrls && uploadedUrls.length > 0) finalUrl = uploadedUrls[0];
                        } else {
                            if(db) {
                                const fileExt = payloadInfo.newFile.name.split('.').pop();
                                const fileName = `${Math.random()}.${fileExt}`;
                                const { data: uploadData, error: uploadError } = await db.storage.from('featured').upload(fileName, payloadInfo.newFile);
                                if (!uploadError && uploadData) {
                                    const { data: publicUrlData } = db.storage.from('featured').getPublicUrl(fileName);
                                    if(publicUrlData) finalUrl = publicUrlData.publicUrl;
                                }
                            }
                        }
                    } catch (uploadErr) {
                        showToast("Cover image upload failed.", "error");
                        throw new Error("Upload failed");
                    }
                }

                const sortOrderInput = parseInt(document.getElementById("cpSortOrder").value);

                const data = {
                    title: document.getElementById("cpTitle").value.trim(),
                    location: document.getElementById("cpLocation").value.trim(),
                    description: document.getElementById("cpDescription").value.trim(),
                    image: finalUrl,
                    detail_page: detailPageUrl,
                    is_featured: document.getElementById("cpIsFeatured").checked,
                    sort_order: !isNaN(sortOrderInput) ? sortOrderInput : 10,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.saveCurrentProject === 'function') {
                    const res = await window.CMS.saveCurrentProject(data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    if (!db) throw new Error("Database client not available");
                    const { data: savedData, error } = await db.from('current_projects').upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }
                
                window.closeCurrentProjectModal(); 
                await reloadAndPreserveScroll(loadCurrentProjects, isEdit, newlySavedId || null);
                showToast("Flagship Project Saved!");
            } catch (err) { 
                showToast("Error saving record.", "error"); 
            } finally { 
                btn.disabled = false; 
                btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
            }
        };
    };

    window.deleteCurrentProject = async (id) => {
        window.customConfirm("Delete Flagship", "Delete this flagship project permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("current_projects", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("current_projects").delete().eq('id', id);
                    if (error) throw error;
                }
                await reloadAndPreserveScroll(loadCurrentProjects, false, null); 
                showToast("Deleted."); 
            } catch (err) {
                showToast("Failed to delete.", "error");
            }
        });
    };

    async function loadCurrentProjects(force = false) {
        const el = document.getElementById("currentProjectList");
        if (!el) return;
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;
        try {
            const fn = typeof window.CMS?.getCurrentProjects === 'function' ? window.CMS.getCurrentProjects : async () => { 
                const db = window.getDbClient();
                if (!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('current_projects').select('*').order('sort_order',{ascending:true}); 
                return data; 
            };
            const projects = await fn(force) || [];
            window.appState.currentProjects = projects;

            if (!projects.length) { el.innerHTML = `<p style="text-align:center; color: var(--text-muted); padding:3rem;">No flagship projects found.</p>`; return; }
            el.innerHTML = projects.map((p, index) => `
                <div class="item-row" data-id="${p.id}" style="${p.is_featured === false ? 'opacity: 0.6;' : ''} border-left-color: ${p.is_featured ? 'var(--brand-gold)' : 'var(--text-muted)'}; animation-delay: ${index * 0.03}s;">
                    <div class="list-item-content">
                        ${window.safeParseImages(p.image)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(p.image)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-star"></i></div>`}
                        <div class="item-info">
                            <h4>${p.title || "Untitled"} ${p.is_featured ? '<span class="badge success" style="margin-left:8px;">Active</span>' : '<span class="badge danger" style="margin-left:8px;">Hidden</span>'}</h4>
                            <p>
                                <i class="fas fa-map-marker-alt"></i> ${p.location || "—"}
                                ${p.detail_page ? `<span style="margin-left: 1rem;"><a href="${p.detail_page}" target="_blank" style="color:var(--info);"><i class="fas fa-external-link-alt"></i></a></span>` : ''}
                            </p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openCurrentProjectModal('${p.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteCurrentProject('${p.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load featured projects.</p>`; }
    }
    window.loadCurrentProjects = loadCurrentProjects;

    // ================================================
    // CRUD Logic: CAREERS (Job Openings)
    // ================================================
    window.openCareerModal = async (id = null) => {
        showModal("careerModal");
        document.getElementById("careerModalTitle").textContent = id ? "Edit Position" : "New Position";
        document.getElementById("careerForm").reset();
        document.getElementById("careerId").value = id || "";

        if (id) {
            const item = window.appState.careers.find(p => p.id == id);
            if(item) {
                document.getElementById("careerItemNumber").value = item.item_number !== null ? item.item_number : "";
                document.getElementById("careerTitle").value = item.position_title || "";
                document.getElementById("careerAvailable").value = item.is_available ? "true" : "false";
                document.getElementById("careerSortOrder").value = item.sort_order ?? 0;
            } else {
                try {
                    const fn = typeof window.CMS?.getJobOpeningById === 'function' ? window.CMS.getJobOpeningById : async (i) => { 
                        const db = window.getDbClient();
                        if(!db) return null;
                        const {data} = await db.from('job_openings').select('*').eq('id',i).single(); 
                        return data; 
                    };
                    const fetchedItem = await fn(id);
                    if (fetchedItem) {
                        document.getElementById("careerItemNumber").value = fetchedItem.item_number !== null ? fetchedItem.item_number : "";
                        document.getElementById("careerTitle").value = fetchedItem.position_title || "";
                        document.getElementById("careerAvailable").value = fetchedItem.is_available ? "true" : "false";
                        document.getElementById("careerSortOrder").value = fetchedItem.sort_order ?? 0;
                    }
                } catch (err) {}
            }
        }

        document.getElementById("careerForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("careerForm")) return;

            const btn = document.getElementById("saveCareerBtn");
            btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("careerId").value;
            const editId = document.getElementById("careerId").value;

            try {
                const uid = await getAuthUserId();
                const itemNumInput = parseInt(document.getElementById("careerItemNumber").value);
                const sortOrderInput = parseInt(document.getElementById("careerSortOrder").value);

                const data = {
                    item_number: !isNaN(itemNumInput) ? itemNumInput : null,
                    position_title: document.getElementById("careerTitle").value.trim(),
                    is_available: document.getElementById("careerAvailable").value === "true",
                    sort_order: !isNaN(sortOrderInput) ? sortOrderInput : 0,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.saveJobOpening === 'function') {
                    const res = await window.CMS.saveJobOpening(data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { data: savedData, error } = await db.from('job_openings').upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }
                
                window.closeCareerModal(); 
                await reloadAndPreserveScroll(loadCareers, isEdit, newlySavedId || null);
                showToast("Position saved!");
            } catch (err) { 
                showToast("Error saving.", "error"); 
            } finally { 
                btn.disabled = false; 
                btn.innerHTML = '<i class="fas fa-save"></i> Save Position'; 
            }
        };
    };

    window.deleteCareer = async (id) => {
        window.customConfirm("Delete Job", "Delete this job position permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("job_openings", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("job_openings").delete().eq('id', id);
                    if (error) throw error;
                }
                await reloadAndPreserveScroll(loadCareers, false, null); 
                showToast("Position Deleted."); 
            } catch (err) {
                showToast("Failed to delete.", "error");
            }
        });
    };

    async function loadCareers(force = false) {
        const el = document.getElementById("careerList");
        if (!el) return;
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;
        try {
            const fn = typeof window.CMS?.getJobOpenings === 'function' ? window.CMS.getJobOpenings : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('job_openings').select('*').order('sort_order',{ascending:true}); 
                return data; 
            };
            const positions = await fn(force) || [];
            window.appState.careers = positions;

            if (!positions.length) { el.innerHTML = `<p style="text-align:center; padding:3rem; color:var(--text-muted);">No openings found.</p>`; return; }
            el.innerHTML = positions.map((p, index) => `
                <div class="item-row" data-id="${p.id}" style="${!p.is_available ? 'opacity:0.6;' : ''} border-left-color: ${p.is_available ? 'var(--success)' : 'var(--text-muted)'}; animation-delay: ${index * 0.03}s;">
                    <div class="item-info">
                        <h4><i class="fas fa-briefcase" style="color:var(--text-muted); margin-right:0.5rem;"></i> ${p.item_number ? p.item_number + ". " : ""}${p.position_title || "Untitled"}</h4>
                        <p style="color: ${p.is_available ? 'var(--success)' : 'var(--danger)'}; font-weight:600; margin-top:0.2rem;">${p.is_available ? "Active / Open" : "Closed"}</p>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openCareerModal('${p.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteCareer('${p.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load careers.</p>`; }
    }
    window.loadCareers = loadCareers;

    // ================================================
    // DASHBOARD STATS & UNREAD BADGES
    // ================================================
    async function loadDashboardStats() {
        try {
            const getProjects = typeof window.CMS?.getProjects === 'function' ? window.CMS.getProjects : async () => {
                const db = window.getDbClient();
                if(!db) return [];
                const {data} = await db.from('projects').select('*');
                return data || [];
            };
            const projects = await getProjects() || [];
            
            if (document.getElementById('totalProjects')) document.getElementById('totalProjects').textContent = projects.length;
            if (document.getElementById('ongoingProjects')) document.getElementById('ongoingProjects').textContent = projects.filter(p => (p.status || '').toLowerCase() === 'ongoing').length;
            if (document.getElementById('upcomingProjects')) document.getElementById('upcomingProjects').textContent = projects.filter(p => (p.status || '').toLowerCase() === 'upcoming').length;

            const getAwards = typeof window.CMS?.getAwards === 'function' ? window.CMS.getAwards : async () => {
                const db = window.getDbClient();
                if(!db) return [];
                const {data} = await db.from('awards').select('*');
                return data || [];
            };
            const awards = await getAwards() || [];
            if (document.getElementById('totalAwards')) document.getElementById('totalAwards').textContent = awards.length;
        } catch (err) { console.error("Failed to load dashboard stats", err); }
    }

    async function refreshUnreadBadge() {
        try {
            const getInq = typeof window.CMS?.getInquiries === 'function' ? window.CMS.getInquiries : async () => { 
                const db = window.getDbClient();
                if(!db) return [];
                const {data} = await db.from('inquiries').select('id, status'); 
                return data; 
            };
            const inquiries = await getInq() || [];
            const unreadCount = inquiries.filter(i => (i.status || 'new').toLowerCase() === 'new').length;
            
            const badgeId = 'unreadInquiriesBadge';
            let badge = document.getElementById(badgeId);
            const menuLink = document.querySelector('.sidebar-menu a[data-page="inquiries"]');
            
            if (unreadCount > 0) {
                if (!badge && menuLink) {
                    badge = document.createElement('span');
                    badge.id = badgeId;
                    badge.style.cssText = 'background: var(--danger); color: white; border-radius: 12px; padding: 2px 8px; font-size: 0.75rem; margin-left: auto; font-weight: bold; line-height: 1;';
                    menuLink.appendChild(badge);
                }
                if (badge) badge.textContent = unreadCount;
            } else if (badge) { badge.remove(); }
        } catch (err) {}
    }

    // ================================================
    // PAGE SWITCHING ROUTER
    // ================================================
    async function switchPage(page, targetId = null) {
        saveScrollPosition();

        document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
        document.querySelectorAll(".sidebar-menu a").forEach(a => a.classList.remove("active"));

        const target = document.getElementById(`page-${page}`);
        const menuItem = document.querySelector(`.sidebar-menu a[data-page="${page}"]`);
        
        if (target) target.classList.add("active");
        if (menuItem) menuItem.classList.add("active");

        const isNewModule = state.currentModule !== page;
        state.currentModule = page;

        // Contextual FAB Button Switching
        const globalFab = document.getElementById("globalFab");
        const fabActions = {
            "projects": () => window.openProjectModalAction(),
            "awards": () => window.openAwardModal(),
            "news": () => window.openNewsModal(),
            "press": () => window.openPressModal(),
            "culture": () => window.openCultureModal(),
            "current-projects": () => window.openCurrentProjectModal(),
            "careers": () => window.openCareerModal()
        };

        if (fabActions[page] && globalFab) {
            globalFab.style.display = "flex";
            globalFab.onclick = fabActions[page];
        } else if (globalFab) {
            globalFab.style.display = "none";
        }

        const loaders = {
            "dashboard": () => loadDashboardStats(),
            "projects": () => loadProjects(false),
            "awards": () => loadAwards(false),
            "news": () => loadNews(false),
            "press": () => loadPress(false),
            "culture": () => loadCulture(false),
            "certifications": () => CertificationManager.init(),
            "inquiries": () => loadInquiries(false),
            "archived-inquiries": () => loadArchivedInquiries(false),
            "current-projects": () => loadCurrentProjects(false),
            "careers": () => loadCareers(false)
        };

        if (loaders[page]) await loaders[page](); 

        if (targetId) {
            restoreScrollPosition(targetId);
        } else if (isNewModule) {
            window.scrollTo({ top: 0, behavior: 'instant' });
        } else {
            restoreScrollPosition();
        }

        refreshUnreadBadge();
        if (window.innerWidth <= 1024) {
            const sb = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if(sb) sb.classList.remove('open');
            if(overlay) overlay.classList.remove('show');
        }
    }

    // ================================================
    // INITIALIZATION & EVENT LISTENERS
    // ================================================
    document.addEventListener("DOMContentLoaded", () => {
        try {
            const dateDisplay = document.getElementById('currentDateDisplay');
            if (dateDisplay) {
                dateDisplay.textContent = "System is fully operational and securely connected.";
            }

            const bannerDay = document.getElementById('bannerDay');
            const bannerMonthYear = document.getElementById('bannerMonthYear');
            if(bannerDay && bannerMonthYear) {
                const now = new Date();
                bannerDay.textContent = now.getDate();
                bannerMonthYear.textContent = now.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }

            if (typeof window.CMS !== 'undefined' && typeof window.CMS.isAuthenticated === 'function' && !window.CMS.isAuthenticated()) {
                window.location.href = "login.html";
                return;
            } else if (typeof window.CMS !== 'undefined' && window.CMS.getCurrentUser) {
                const user = window.CMS.getCurrentUser();
                if (user && user.role !== "admin") {
                    if(document.getElementById("mainContent")) document.getElementById("mainContent").style.display = "none";
                    if(document.getElementById("accessDenied")) document.getElementById("accessDenied").style.display = "block";
                    return;
                }
            }

            imgManagers.projects = new ImageManager("projectDragArea", "pImgFile", "projectPreviewContainer");
            imgManagers.culture = new ImageManager("cultureDragArea", "cImgFile", "culturePreviewContainer");
            imgManagers.awards = new ImageManager("awardDragArea", "aImgFile", "awardPreviewContainer");
            imgManagers.news = new ImageManager("newsDragArea", "nImgFile", "newsPreviewContainer");
            imgManagers.press = new SingleImageManager("pressDragArea", "pressImgFile", "pressPreviewContainer");
            imgManagers.currentProject = new SingleImageManager("cpDragArea", "cpImageInput", "cpPreviewContainer");

            document.querySelectorAll(".sidebar-menu a").forEach(link => {
                link.onclick = e => { e.preventDefault(); switchPage(link.dataset.page); };
            });

            const bindClick = (id, fn) => document.getElementById(id)?.addEventListener('click', fn);
            
            bindClick('btnNewProject', () => window.openProjectModalAction());
            bindClick('btnNewAward', () => window.openAwardModal());
            bindClick('btnNewNews', () => window.openNewsModal());
            bindClick('btnNewCulture', () => window.openCultureModal());
            
            bindClick('btnAddProjectPage', () => window.openProjectModalAction());
            bindClick('btnAddAwardPage', () => window.openAwardModal());
            bindClick('btnAddNewsPage', () => window.openNewsModal());
            bindClick('btnAddPressPage', () => window.openPressModal());
            bindClick('btnAddCulturePage', () => window.openCultureModal());
            bindClick('btnAddCurrentProjectPage', () => window.openCurrentProjectModal());
            bindClick('btnAddCareerPage', () => window.openCareerModal());

            // Add Logout Event Listeners
            document.getElementById('logoutButton')?.addEventListener('click', async () => {
                window.customConfirm("Sign Out", "Are you sure you want to log out of the Admin Portal?", async () => {
                    const db = window.getDbClient();
                    if (db && db.auth) await db.auth.signOut();
                    window.location.href = 'login.html';
                });
            });

            document.getElementById('accessDeniedLogout')?.addEventListener('click', async () => {
                 const db = window.getDbClient();
                 if (db && db.auth) await db.auth.signOut();
                 window.location.href = 'login.html';
            });

            // Mobile menu event listeners
            document.getElementById('sidebarToggle')?.addEventListener('click', () => { 
                document.getElementById('sidebar').classList.add('open');
                document.getElementById('sidebarOverlay')?.classList.add('show');
            });

            document.getElementById('sidebarOverlay')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            });

            document.getElementById('mobileSidebarClose')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            });

            document.querySelectorAll(".modal").forEach(modal => {
                modal.addEventListener('click', e => { if (e.target === modal) hideModal(modal.id); });
            });
            
            document.getElementById("lightboxModal")?.addEventListener('click', (e) => {
                if(e.target.id === 'lightboxModal') closeLightbox();
            });

            if (typeof window.CMS !== 'undefined' && typeof window.CMS.subscribeToInquiries === 'function') {
              window.CMS.subscribeToInquiries(payload => {
                if (payload.eventType === 'INSERT' || payload.eventType === 'UPDATE') {
                  refreshUnreadBadge(); showToast("New inquiry received!", "info");
                }
              });
            }

            setTimeout(() => {
                loadDashboardStats();
                refreshUnreadBadge();
            }, 400);

            switchPage("dashboard");

        } catch (err) {
            console.error("[CRITICAL] Error in DOMContentLoaded:", err);
        }
    });
  </script>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>
<script src="js/auth-guard.js"></script>
<script>
  async function checkSecurityGate() {
        const SUPABASE_URL = 'https://guvifomiadxehmtrqrfu.supabase.co';
        const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imd1dmlmb21pYWR4ZWhtdHJxcmZ1Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzMxMDc1MjUsImV4cCI6MjA4ODY4MzUyNX0.8gy3oPTSwPXCZHAi0FbmpjkIrHQuZmWd_TE-h-L0gD8'; 
        
        if (typeof supabase === 'undefined') {
            window.location.href = 'login.html';
            return;
        }
        
        window.supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_ANON_KEY);
        const gateClient = window.supabaseClient;
        
        gateClient.auth.onAuthStateChange((event, session) => {
            if (event === 'SIGNED_OUT' || !session) {
                sessionStorage.clear();
                window.location.href = 'login.html';
            }
        });

        try {
            const { data: { session }, error: authError } = await gateClient.auth.getSession();

            if (authError || !session) {
                sessionStorage.clear();
                window.location.href = 'login.html';
                return;
            }

            const { data: userRole, error: roleError } = await gateClient
                .from('user_roles')
                .select('role')
                .eq('user_id', session.user.id)
                .maybeSingle();

            if (roleError || !userRole || userRole.role !== 'admin') {
                alert("Access Denied: You do not have administrator privileges.");
                await gateClient.auth.signOut();
                sessionStorage.clear();
                window.location.href = 'login.html';
                return;
            }

            sessionStorage.setItem('builtech_auth', 'true');
            sessionStorage.setItem('builtech_user', JSON.stringify(session.user));
            
            document.getElementById('securityGateOverlay').style.display = 'none';
            document.getElementById('userGreeting').textContent = session.user.email.split('@')[0];
            console.log("%c[Security] Administrator Access Granted", "color: #059669; font-weight: bold;");

        } catch (err) {
            console.error("Security Gate Error:", err);
            window.location.href = 'login.html';
        }
    }
    checkSecurityGate();
  </script>
<script>
    // ================================================
    // UUID GENERATOR FALLBACK
    // ================================================
    window.generateUUID = function() {
        if (typeof crypto !== 'undefined' && crypto.randomUUID) return crypto.randomUUID();
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };

    // ================================================
    // CUSTOM CONFIRMATION REPLACEMENT
    // ================================================
    window.customConfirm = function(title, message, callback) {
        const modal = document.getElementById('customConfirmModal');
        document.getElementById('confirmTitle').textContent = title;
        document.getElementById('confirmMessage').textContent = message;
        
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);

        const cancelBtn = document.getElementById('confirmCancelBtn');
        const actionBtn = document.getElementById('confirmActionBtn');

        const cleanup = () => {
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 200);
            cancelBtn.onclick = null;
            actionBtn.onclick = null;
        };

        cancelBtn.onclick = () => cleanup();
        actionBtn.onclick = () => {
            cleanup();
            callback();
        };
    };

    // ================================================
    // ICON PICKER LOGIC
    // ================================================
    const COMMON_ICONS = [
        'fa-star', 'fa-trophy', 'fa-award', 'fa-medal', 'fa-crown',
        'fa-building', 'fa-hard-hat', 'fa-tools', 'fa-hammer', 'fa-truck-pickup',
        'fa-check', 'fa-check-circle', 'fa-check-double', 'fa-shield-alt', 'fa-certificate',
        'fa-handshake', 'fa-leaf', 'fa-bolt', 'fa-globe', 'fa-thumbs-up'
    ];

    window.openIconModal = function() {
        const container = document.getElementById('iconGridContainer');
        container.innerHTML = COMMON_ICONS.map(icon => `
            <div class="icon-item" onclick="copyIconCode('${icon}')">
                <i class="fas ${icon}"></i>
                <span>${icon.replace('fa-', '')}</span>
            </div>
        `).join('');
        
        const modal = document.getElementById('iconPickerModal');
        modal.style.display = "flex";
        setTimeout(() => modal.classList.add("show"), 10);
    };

    window.copyIconCode = function(iconClass) {
        const code = `<i class="fas ${iconClass}"></i>`;
        navigator.clipboard.writeText(code).then(() => {
            showToast(`Copied ${iconClass} to clipboard!`, 'success');
            hideModal('iconPickerModal');
        }).catch(err => {
            showToast('Failed to copy. Please type manually.', 'error');
        });
    };

    // ================================================
    // STATE MANAGEMENT FOR INSTANT EDIT POPULATION
    // ================================================
    window.appState = {
        projects: [], awards: [], news: [], press: [], culture: [], currentProjects: [], careers: [], inquiries: []
    };

    window.getDbClient = function() {
        if (typeof window.CMS !== 'undefined' && window.CMS.getDbClient) return window.CMS.getDbClient();
        if (typeof window.supabaseClient !== 'undefined') return window.supabaseClient; 
        return null;
    };

    window.safeParseImages = function(imgData) {
        if (!imgData) return [];
        if (Array.isArray(imgData)) return imgData;
        if (typeof imgData === 'string') {
            try {
                const parsed = JSON.parse(imgData);
                return Array.isArray(parsed) ? parsed : [imgData];
            } catch(e) {
                return [imgData];
            }
        }
        return [imgData];
    };

    // ================================================
    // SYSTEMATIC UI GROUPING HELPER (Year Accordions)
    // ================================================
    window.renderGroupedByYear = function(items, renderItemFn, dateKey = 'year') {
        const grouped = items.reduce((acc, item) => {
            let y = item[dateKey];
            if (!y && item.date) {
                y = item.date.includes('/') ? item.date.split('/')[2] :
                    item.date.includes('-') ? item.date.split('-')[0] : 'Unknown';
            }
            if (!y && item.publish_date) {
                 y = item.publish_date.includes('-') ? item.publish_date.split('-')[0] : 'Unknown';
            }
            if (!y) y = 'Unknown';
            if (!acc[y]) acc[y] = [];
            acc[y].push(item);
            return acc;
        }, {});

        const years = Object.keys(grouped).sort((a, b) => {
            if (a === 'Unknown') return 1;
            if (b === 'Unknown') return -1;
            return parseInt(b) - parseInt(a);
        });

        return years.map(year => `
            <div class="year-group">
                <div class="year-header" onclick="this.parentElement.classList.toggle('collapsed')">
                    <h3>${year === 'Unknown' ? 'Others' : year} <span class="badge solid">${grouped[year].length}</span></h3>
                    <i class="fas fa-chevron-up toggle-icon"></i>
                </div>
                <div class="year-content list-container">
                    ${grouped[year].map((item, index) => renderItemFn(item, index)).join('')}
                </div>
            </div>
        `).join('');
    };

    // ================================================
    // LIGHTBOX LOGIC
    // ================================================
    function openLightbox(src) {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        if (!modal || !img) return;
        img.src = src;
        modal.style.display = 'flex';
        setTimeout(() => { modal.style.opacity = '1'; }, 10);
    }

    window.closeLightbox = function() {
        const modal = document.getElementById('lightboxModal');
        if (!modal) return;
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
            document.getElementById('lightboxImg').src = '';
        }, 200);
    }

    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeLightbox(); });
    document.getElementById('lightboxModal')?.addEventListener('click', (e) => {
        if (e.target === document.getElementById('lightboxModal')) closeLightbox();
    });

    // ================================================
    // SCROLL MANAGEMENT
    // ================================================
    const state = { currentModule: 'dashboard', scrollRegistry: {} };

    function saveScrollPosition() {
        if (state.currentModule) state.scrollRegistry[state.currentModule] = window.scrollY;
    }

    function restoreScrollPosition(targetId = null) {
        const savedY = state.scrollRegistry[state.currentModule] || 0;
        setTimeout(() => {
            window.scrollTo({ top: savedY, behavior: 'auto' });
            if (targetId) {
                const element = document.querySelector(`[data-id="${targetId}"]`);
                if (element) {
                    element.classList.add('highlight-item');
                    const group = element.closest('.year-group');
                    if (group && group.classList.contains('collapsed')) group.classList.remove('collapsed');
                    setTimeout(() => element.classList.remove('highlight-item'), 2000);
                }
            }
        }, 100);
    }

    async function reloadAndPreserveScroll(loadFunction, isEdit, itemId) {
        const currentY = window.scrollY; 
        await loadFunction(true); 
        
        setTimeout(() => {
            window.scrollTo({ top: currentY, behavior: 'auto' });
            if (itemId) {
                const el = document.querySelector(`[data-id="${itemId}"]`);
                if (el) {
                    if (isEdit) el.classList.add('highlight-item');
                    const group = el.closest('.year-group');
                    if (group && group.classList.contains('collapsed')) group.classList.remove('collapsed');
                    if (isEdit) setTimeout(() => el.classList.remove('highlight-item'), 2000);
                }
            }
        }, 150);
    }

    // ================================================
    // TOAST NOTIFICATION SYSTEM
    // ================================================
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        let icon = type === 'error' ? 'fa-exclamation-circle' : type === 'info' ? 'fa-info-circle' : 'fa-check-circle';
        toast.innerHTML = `<i class="fas ${icon}"></i> <span>${message}</span>`;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s forwards';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    window.alert = function(msg) {
        if(msg.toLowerCase().includes('fail') || msg.toLowerCase().includes('error')) showToast(msg, 'error');
        else showToast(msg, 'success');
    };

    // ================================================
    // UTILITIES & CACHE
    // ================================================
    function clearCache(table = null) {
        if (typeof window.CMS?.clearCache === 'function') window.CMS.clearCache(table);
        if (table) {
            localStorage.removeItem(`cms_cache_${table}`);
            localStorage.removeItem(`cms_cache_${table}_v1`);
        } else {
            Object.keys(localStorage).forEach(key => {
                if (key.startsWith('cms_cache_') || key.startsWith('builtech_')) localStorage.removeItem(key);
            });
        }
    }

    function debounce(fn, delay = 350) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }
    
    window.debounceLoadCulture = debounce(() => loadCulture(), 350);
    window.debounceLoadProjects = debounce(() => loadProjects(), 350);
    window.debounceLoadAwards = debounce(() => loadAwards(), 350);
    window.debounceLoadNews = debounce(() => loadNews(), 350);
    window.debounceLoadPress = debounce(() => loadPress(), 350);
    window.debounceLoadInquiries = debounce(() => loadInquiries(), 350);
    window.debounceLoadArchivedInquiries = debounce(() => loadArchivedInquiries(), 350);

// ================================================
// MULTIPLE IMAGE MANAGER
// ================================================
class ImageManager {
    constructor(dragAreaId, fileInputId, containerId) {
        this.dragArea = document.getElementById(dragAreaId);
        this.fileInput = document.getElementById(fileInputId);
        this.container = document.getElementById(containerId);
        this.filesMap = {}; this.items = []; 
        if(!this.dragArea || !this.fileInput || !this.container) return;
        this.initEvents(); this.initSortable();
    }

    initEvents() {
        this.dragArea.onclick = () => this.fileInput.click();
        this.fileInput.onchange = (e) => this.processFiles(e.target.files);
        this.dragArea.addEventListener("dragover", e => { e.preventDefault(); this.dragArea.classList.add("drag-over"); });
        this.dragArea.addEventListener("dragleave", () => this.dragArea.classList.remove("drag-over"));
        this.dragArea.addEventListener("drop", e => { 
            e.preventDefault(); 
            this.dragArea.classList.remove("drag-over"); 
            if (e.dataTransfer?.files?.length) this.processFiles(e.dataTransfer.files); 
        });
    }

    async processFiles(fileList) {
        for (let file of fileList) {
            if (file.name.toLowerCase().endsWith(".heic") || file.name.toLowerCase().endsWith(".heif")) {
                if (typeof heic2any !== 'undefined') {
                    showToast(`Converting Apple format: ${file.name}...`, 'info');
                    try {
                        const convertedBlobArray = await heic2any({ blob: file, toType: "image/png", quality: 0.8 });
                        const convertedBlob = Array.isArray(convertedBlobArray) ? convertedBlobArray[0] : convertedBlobArray;
                        const newName = file.name.replace(/\.(heic|heif)$/i, ".png");
                        file = new File([convertedBlob], newName, { type: "image/png" });
                    } catch(e) { 
                        showToast(`Failed to convert ${file.name}`, 'error'); continue; 
                    }
                } else {
                    showToast(`Cannot process ${file.name}. Conversion library missing.`, 'error'); continue; 
                }
            }
            if (!file.type.startsWith("image/")) {
                showToast(`${file.name} is not a valid image.`, 'warning'); continue;
            }

            const fileId = 'file_' + Math.random().toString(36).substr(2, 9);
            this.filesMap[fileId] = file;
            const reader = new FileReader();

            reader.onload = ev => {
                const img = new Image();
                img.onload = () => {
                    const isSmall = img.width < 250 || img.height < 250;
                    this.items.push({ id: fileId, type: 'file', data: file, previewUrl: ev.target.result, isSmall: isSmall });
                    this.render();
                };
                img.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        }
        this.fileInput.value = ""; 
    }

    setExisting(urls) {
        this.items = (urls || []).map((url, i) => ({ 
            id: 'url_' + i + '_' + Math.random().toString(36).substr(2, 5), 
            type: 'url', data: url, previewUrl: url, isSmall: false 
        }));
        this.filesMap = {}; 
        this.render();
    }

    getFinalPayload() {
        const sequence = [];
        const boxes = this.container.querySelectorAll('.preview-box');
        boxes.forEach(box => {
            const id = box.dataset.id; 
            const item = this.items.find(i => i.id === id);
            if(item) sequence.push({ type: item.type, data: item.data });
        });
        return sequence;
    }

    render() {
        this.container.innerHTML = "";
        this.items.forEach(item => {
            const div = document.createElement("div"); 
            div.className = `preview-box ${item.isSmall ? 'small-image-fix' : ''}`; 
            div.draggable = true; 
            div.dataset.id = item.id;
            
            div.innerHTML = `
                <div class="img-wrapper">
                    <img src="${item.previewUrl}" title="Click to enlarge">
                </div>
                <button class="remove-btn" type="button" aria-label="Remove image">&times;</button>
            `;

            div.querySelector('img').onclick = (e) => { e.stopPropagation(); openLightbox(item.previewUrl); };
            div.querySelector(".remove-btn").onclick = (e) => { 
                e.stopPropagation(); 
                this.items = this.items.filter(i => i.id !== item.id); 
                if(item.type === 'file') delete this.filesMap[item.id]; 
                this.render(); 
            };
            this.setupDragEvents(div); 
            this.container.appendChild(div);
        });
    }

    setupDragEvents(itemEl) {
        itemEl.addEventListener('dragstart', () => { itemEl.classList.add('dragging'); });
        itemEl.addEventListener('dragend', () => { itemEl.classList.remove('dragging'); this.container.style.background = ''; });
    }

    initSortable() {
        this.container.addEventListener('dragover', (e) => {
            e.preventDefault(); 
            this.container.style.background = 'rgba(212, 175, 55, 0.05)';
            const draggingItem = this.container.querySelector('.dragging');
            if(!draggingItem) return;
            const siblings = [...this.container.querySelectorAll('.preview-box:not(.dragging)')];
            const nextSibling = siblings.find(sibling => {
                const box = sibling.getBoundingClientRect();
                return e.clientX <= box.left + box.width / 2 && e.clientY <= box.top + box.height;
            });
            if (nextSibling) this.container.insertBefore(draggingItem, nextSibling); 
            else this.container.appendChild(draggingItem);
        });
        this.container.addEventListener('dragleave', () => this.container.style.background = '');
    }
}

// ================================================
// SINGLE IMAGE MANAGER
// ================================================
class SingleImageManager {
    constructor(dragAreaId, fileInputId, containerId) {
        this.dragArea = document.getElementById(dragAreaId);
        this.fileInput = document.getElementById(fileInputId);
        this.container = document.getElementById(containerId);
        this.currentFile = null; this.existingUrl = null;
        if(!this.dragArea || !this.fileInput || !this.container) return;
        this.initEvents();
    }
    
    initEvents() {
        this.dragArea.onclick = () => this.fileInput.click();
        this.fileInput.onchange = (e) => this.processFile(e.target.files[0]);
        this.dragArea.addEventListener("dragover", e => { e.preventDefault(); this.dragArea.classList.add("drag-over"); });
        this.dragArea.addEventListener("dragleave", () => this.dragArea.classList.remove("drag-over"));
        this.dragArea.addEventListener("drop", e => { 
            e.preventDefault(); 
            this.dragArea.classList.remove("drag-over"); 
            if (e.dataTransfer?.files?.[0]) this.processFile(e.dataTransfer.files[0]); 
        });
    }
    
    async processFile(file) {
        if (!file) return;
        const isPdf = file.type === "application/pdf";

        if (file.name.toLowerCase().endsWith(".heic") || file.name.toLowerCase().endsWith(".heif")) {
            if (typeof heic2any !== 'undefined') {
                try {
                    const convertedBlobArray = await heic2any({ blob: file, toType: "image/png", quality: 0.8 });
                    const convertedBlob = Array.isArray(convertedBlobArray) ? convertedBlobArray[0] : convertedBlobArray;
                    file = new File([convertedBlob], file.name.replace(/\.(heic|heif)$/i, ".png"), { type: "image/png" });
                } catch(e) {
                     showToast('Failed to convert HEIC image.', 'error'); return; 
                }
            } else {
                 showToast('HEIC conversion missing.', 'error'); return;
            }
        }
        
        if (!file.type.startsWith("image/") && !isPdf) {
             showToast("Invalid file type uploaded. Please upload an image or PDF.", "error"); return;
        }
        
        this.currentFile = file; this.existingUrl = null;

        if (isPdf) {
            this.renderPdf();
        } else {
            const reader = new FileReader(); 
            reader.onload = ev => {
                const img = new Image();
                img.onload = () => this.render(ev.target.result, img.width < 250);
                img.src = ev.target.result;
            }; 
            reader.readAsDataURL(file);
        }
        this.fileInput.value = "";
    }
    
    setExisting(url) { 
        this.existingUrl = url; this.currentFile = null; 
        if(url && typeof url === 'string') {
            if (url.toLowerCase().includes('.pdf')) this.renderPdf(url);
            else this.render(url, false);
        } else if (url) {
            this.render(url, false);
        } else {
            this.container.innerHTML = ""; 
        }
    }
    
    getFinalPayload() { return { existingUrl: this.existingUrl, newFile: this.currentFile }; }
    
    render(src, isSmall) {
        this.container.innerHTML = `
            <div class="preview-box ${isSmall ? 'small-image-fix' : ''}" style="width:180px; height:120px; cursor: default;">
                <div class="img-wrapper"><img src="${src}" title="Click to enlarge"></div>
                <button class="remove-btn" type="button">&times;</button>
            </div>`;
        this.container.querySelector('img').onclick = (e) => { e.stopPropagation(); openLightbox(src); };
        this.container.querySelector('.remove-btn').onclick = (e) => { e.stopPropagation(); this.currentFile = null; this.existingUrl = null; this.container.innerHTML = ""; };
    }

    renderPdf(url = null) {
        this.container.innerHTML = `
            <div class="preview-box" style="width:180px; height:120px; cursor: pointer; display:flex; align-items:center; justify-content:center; background:#f8fafc; border: 1px solid var(--border-color);">
                <div style="text-align:center;">
                    <i class="fas fa-file-pdf" style="font-size:2.5rem; color:var(--danger); margin-bottom: 0.5rem;"></i>
                    <div style="font-size:0.85rem; font-weight:600; color: var(--text-heading);">PDF Document</div>
                </div>
                <button class="remove-btn" type="button">&times;</button>
            </div>`;
        this.container.querySelector('.remove-btn').onclick = (e) => { e.stopPropagation(); this.currentFile = null; this.existingUrl = null; this.container.innerHTML = ""; };
        if (url) this.container.querySelector('.preview-box').onclick = () => window.open(url, '_blank');
    }
}

let imgManagers = {};

    // ================================================
    // MODAL OPEN / CLOSE HELPERS
    // ================================================
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.style.display = "flex";
        setTimeout(() => modal.classList.add("show"), 10);
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.remove("show");
        setTimeout(() => { modal.style.display = "none"; }, 200); 
    }

    window.closeProjectModal = () => { hideModal("projectModal"); document.getElementById("pImgFile").value = ""; document.getElementById("pHtmlFile").value = ""; };
    window.closeAwardModal = () => { hideModal("awardModal"); document.getElementById("aImgFile").value = ""; };
    window.closePressModal = () => { hideModal("pressModal"); document.getElementById("pressImgFile").value = ""; };
    window.closeNewsModal = () => { hideModal("newsModal"); document.getElementById("nImgFile").value = ""; };
    window.closeCultureModal = () => { hideModal("cultureModal"); document.getElementById("cImgFile").value = ""; };
    window.closeCertModal = () => { hideModal("certModal"); document.getElementById("certFile").value = ""; };
    window.closeInquiryModal = () => hideModal("inquiryModal");
    window.closeCurrentProjectModal = () => { hideModal("currentProjectModal"); document.getElementById("cpImageInput").value = ""; document.getElementById("cpHtmlFile").value = ""; };
    window.closeCareerModal = () => hideModal("careerModal");

    async function getAuthUserId() {
        const db = window.getDbClient();
        if (!db || !db.auth) return null;
        try {
            const { data: { user }, error } = await db.auth.getUser();
            if (error || !user) return null;
            return user.id;
        } catch (err) {
            console.error("Failed to get auth user:", err);
            return null;
        }
    }

    function validateRequiredFields(formId) {
        const form = document.getElementById(formId);
        if (!form) return false;
        
        let valid = true;
        form.querySelectorAll('[required]').forEach(el => {
            if (!el.value.trim()) {
                el.style.borderColor = 'var(--danger)';
                valid = false;
                setTimeout(() => { el.style.borderColor = 'var(--border-color)'; }, 3000);
            }
        });
        
        form.querySelectorAll('input[type="number"][min][max]').forEach(el => {
            if (el.value) {
                const val = parseInt(el.value);
                if (isNaN(val) || val < el.min || val > el.max) {
                    el.style.borderColor = 'var(--danger)';
                    valid = false;
                    setTimeout(() => { el.style.borderColor = 'var(--border-color)'; }, 3000);
                }
            }
        });
        
        if (!valid) showToast("Please fill all required fields correctly.", "error");
        return valid;
    }

    // ================================================
    // CRUD Logic: PROJECTS
    // ================================================
    window.openProjectModalAction = async (id = null) => {
      showModal("projectModal");
      document.getElementById("projectModalTitle").textContent = id ? "Edit Project" : "New Project";
      document.getElementById("projectForm").reset();
      document.getElementById("pHtmlFile").value = "";
      imgManagers.projects.setExisting([]); 
      document.getElementById("pId").value = id || "";

      const htmlLink = document.getElementById("pHtmlLink");
      htmlLink.style.display = "none";
      
      document.getElementById("pIsCurrent").checked = false;
      document.getElementById("pIsFlagship").checked = false;

      if (id) {
        const item = window.appState.projects.find(p => p.id == id);
        if (item) {
            document.getElementById("pYear").value = item.year || "";
            document.getElementById("pTitle").value = item.title || "";
            document.getElementById("pLoc").value = item.loc || item.location || "";
            document.getElementById("pCat").value = item.cat || item.category || "";
            document.getElementById("pStatus").value = item.status || "Completed";
            document.getElementById("pAward").value = item.award || "";
            document.getElementById("pScope").value = item.scope || "";
            document.getElementById("pDetailManualUrl").value = item.detail_page || item.project_url || "";
            document.getElementById("pIsCurrent").checked = item.is_current_project || false;
            document.getElementById("pIsFlagship").checked = item.is_flagship || false;
            
            if (item.detail_page || item.project_url) {
                htmlLink.innerHTML = `Template: <a href="${item.detail_page || item.project_url}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                htmlLink.style.display = "block";
            }
            imgManagers.projects.setExisting(window.safeParseImages(item.img));
        } else {
            try {
                const getById = typeof window.CMS?.getProjectById === 'function' ? window.CMS.getProjectById : async (i) => {
                    const db = window.getDbClient(); if(!db) return null;
                    const {data} = await db.from('projects').select('*').eq('id',i).single(); return data;
                };
                const fetchedItem = await getById(id);
                if (fetchedItem) {
                    document.getElementById("pYear").value = fetchedItem.year || "";
                    document.getElementById("pTitle").value = fetchedItem.title || "";
                    document.getElementById("pLoc").value = fetchedItem.loc || fetchedItem.location || "";
                    document.getElementById("pCat").value = fetchedItem.cat || fetchedItem.category || "";
                    document.getElementById("pStatus").value = fetchedItem.status || "Completed";
                    document.getElementById("pAward").value = fetchedItem.award || "";
                    document.getElementById("pScope").value = fetchedItem.scope || "";
                    document.getElementById("pDetailManualUrl").value = fetchedItem.detail_page || fetchedItem.project_url || "";
                    document.getElementById("pIsCurrent").checked = fetchedItem.is_current_project || false;
                    document.getElementById("pIsFlagship").checked = fetchedItem.is_flagship || false;
                    
                    if (fetchedItem.detail_page || fetchedItem.project_url) {
                        htmlLink.innerHTML = `Template: <a href="${fetchedItem.detail_page || fetchedItem.project_url}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                        htmlLink.style.display = "block";
                    }
                    imgManagers.projects.setExisting(window.safeParseImages(fetchedItem.img));
                }
            } catch (err) { console.error("Failed to fetch project via API fallback:", err); }
        }
      }

      document.getElementById("projectForm").onsubmit = async (e) => {
        e.preventDefault();
        if(!validateRequiredFields("projectForm")) return;
        
        const btn = document.getElementById("saveProjectBtn");
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        const isEdit = !!document.getElementById("pId").value;
        const editId = document.getElementById("pId").value;
        const db = window.getDbClient();

        try {
            const uid = await getAuthUserId();
            const payloadSequence = imgManagers.projects.getFinalPayload();
            let finalUrls = [];
            
            let detailPageUrl = document.getElementById("pDetailManualUrl").value.trim() || null;
            const htmlFileInput = document.getElementById("pHtmlFile");
            if (htmlFileInput.files.length > 0) {
                if (db) {
                    const file = htmlFileInput.files[0];
                    const fileExt = file.name.split('.').pop();
                    const fileName = `template_${Math.random().toString(36).substring(2)}.${fileExt}`;
                    const { data: uploadData, error: htmlUploadErr } = await db.storage.from('projects').upload(fileName, file);
                    if (!htmlUploadErr && uploadData) {
                        const { data: publicUrlData } = db.storage.from('projects').getPublicUrl(fileName);
                        if (publicUrlData) detailPageUrl = publicUrlData.publicUrl;
                    } else {
                        throw new Error("HTML Template upload failed.");
                    }
                }
            }

            const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
            let uploadedUrls = [];

            if (filesToUpload.length > 0) {
                try {
                    if (typeof window.CMS?.uploadImages === 'function') {
                        uploadedUrls = await window.CMS.uploadImages(filesToUpload, 'projects');
                        if (!uploadedUrls) uploadedUrls = [];
                    } else if (db) {
                        for (let file of filesToUpload) {
                            const fileExt = file.name.split('.').pop();
                            const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                            const { data: uploadData, error } = await db.storage.from('projects').upload(fileName, file);
                            if (!error && uploadData) {
                                const { data: publicUrlData } = db.storage.from('projects').getPublicUrl(fileName);
                                if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                            }
                        }
                    }
                } catch (uploadErr) {
                    throw uploadErr;
                }
            }

            let uploadIndex = 0;
            for (let item of payloadSequence) {
                if (item.type === 'url') {
                    finalUrls.push(item.data);
                } else if (item.type === 'file') {
                    if (uploadedUrls[uploadIndex]) {
                        finalUrls.push(uploadedUrls[uploadIndex]);
                    }
                    uploadIndex++;
                }
            }

            const data = {
                year: document.getElementById("pYear").value.trim(),
                title: document.getElementById("pTitle").value.trim(),
                loc: document.getElementById("pLoc").value.trim(),
                cat: document.getElementById("pCat").value.trim(),
                status: document.getElementById("pStatus").value,
                award: document.getElementById("pAward").value.trim(),
                scope: document.getElementById("pScope").value.trim(),
                detail_page: detailPageUrl,
                img: finalUrls,
                is_current_project: document.getElementById("pIsCurrent").checked,
                is_flagship: document.getElementById("pIsFlagship").checked,
                created_by: uid
            };
            
            if (editId) data.id = editId;
            let newlySavedId = editId;

            if (typeof window.CMS?.saveProject === 'function') {
                const res = await window.CMS.saveProject(data);
                if (res && res.id) newlySavedId = res.id;
            } else {
                if (!db) throw new Error("Database client not found");
                const { data: savedData, error } = await db.from('projects').upsert(data).select();
                if (error) throw error;
                if (savedData && savedData[0]) newlySavedId = savedData[0].id;
            }

            window.closeProjectModal(); 
            await reloadAndPreserveScroll(loadProjects, isEdit, newlySavedId || null);
            loadDashboardStats();
            showToast("Project saved successfully!");
        } catch (err) { 
            console.error(err);
            if (err.message && err.message.includes('400')) {
                 showToast("Upload failed: Please ensure your Supabase Storage Bucket exists.", "error");
            } else {
                 showToast("Error saving project.", "error"); 
            }
        } finally { 
            btn.disabled = false; 
            btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
        }
      };
    };

    window.deleteProject = async (id) => {
        window.customConfirm("Delete Project", "Are you sure you want to permanently delete this project? This action cannot be undone.", async () => {
            try {
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("projects", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("projects").delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("projects"); 
                await reloadAndPreserveScroll(loadProjects, false, null);
                loadDashboardStats(); 
                showToast("Project deleted."); 
            } catch (err) { 
                console.error(err); 
                showToast("Failed to delete project.", "error");
            }
        });
    };

    async function loadProjects(force = false) {
        const el = document.getElementById("projectList");
        const search = document.getElementById("projectSearch")?.value.toLowerCase() || "";
        const statusFilter = document.getElementById("projectStatusFilter")?.value || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Projects...</p></div>`;
        
        try {
            const fetchFn = typeof window.CMS?.getProjects === 'function' ? window.CMS.getProjects : async () => {
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('projects').select('*').order('year',{ascending:false});
                return data;
            };
            let projects = await fetchFn(force) || [];
            window.appState.projects = projects; 
            
            if(search) projects = projects.filter(p => (p.title||'').toLowerCase().includes(search) || (p.loc||p.location||'').toLowerCase().includes(search));
            if(statusFilter) projects = projects.filter(p => p.status === statusFilter);

            if (!projects?.length) { el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No projects found.</p>`; return; }
            
            const renderItem = (p, index) => `
                <div class="item-row" data-id="${p.id}" style="animation-delay: ${index * 0.03}s; border-left-color: ${p.status === 'Completed' ? 'var(--success)' : p.status === 'Ongoing' ? 'var(--warning)' : 'var(--info)'};">
                    <div class="list-item-content">
                        ${window.safeParseImages(p.img)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(p.img)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-building"></i></div>`}
                        <div class="item-info">
                            <h4>
                                ${p.title || "Untitled"} 
                                ${p.is_flagship ? '<span class="badge gold" style="margin-left:8px;" title="Shows on Main Slider"><i class="fas fa-star"></i> Flagship</span>' : ''}
                                ${p.is_current_project ? '<span class="badge info" style="margin-left:4px;" title="Shows in Current Projects"><i class="fas fa-bolt"></i> Featured</span>' : ''}
                            </h4>
                            <p>
                                <span class="badge ${p.status === 'Completed' ? 'success' : p.status === 'Ongoing' ? 'warning' : 'info'}">${p.status}</span>
                                <span style="margin-left: 0.5rem;"><i class="fas fa-map-marker-alt"></i> ${p.loc || p.location || "—"}</span>
                                ${p.award ? `<span style="margin-left: 0.5rem; color: var(--brand-gold-hover);"><i class="fas fa-trophy"></i> Awarded</span>` : ''}
                                ${(p.detail_page || p.project_url) ? `<span style="margin-left: 0.5rem;"><a href="${p.detail_page || p.project_url}" target="_blank" style="color:var(--info);"><i class="fas fa-external-link-alt"></i></a></span>` : ''}
                            </p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openProjectModalAction('${p.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteProject('${p.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            el.innerHTML = window.renderGroupedByYear(projects, renderItem, 'year');
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;"><i class="fas fa-exclamation-triangle" style="font-size:3rem; margin-bottom:1rem; display:block;"></i>Failed to load projects.</p>`; }
    }
    window.loadProjects = loadProjects;

    // ================================================
    // CRUD Logic: AWARDS
    // ================================================
    window.openAwardModal = async (id = null) => {
      showModal("awardModal");
      document.getElementById("awardModalTitle").textContent = id ? "Edit Award" : "New Award";
      document.getElementById("awardForm").reset();
      imgManagers.awards.setExisting([]);
      document.getElementById("aId").value = id || "";

      if (id) {
        const item = window.appState.awards.find(a => a.id == id);
        if (item) {
            document.getElementById("aYear").value = item.year || "";
            document.getElementById("aTitle").value = item.title || "";
            document.getElementById("aIssuer").value = item.issuer || "";
            document.getElementById("aDesc").value = item.description || "";
            imgManagers.awards.setExisting(window.safeParseImages(item.img));
        } else {
            try {
                const getById = typeof window.CMS?.getAwardById === 'function' ? window.CMS.getAwardById : async (i) => {
                    const db = window.getDbClient(); if(!db) return null;
                    const {data} = await db.from('awards').select('*').eq('id',i).single(); return data;
                };
                const fetchedItem = await getById(id);
                if (fetchedItem) {
                    document.getElementById("aYear").value = fetchedItem.year || "";
                    document.getElementById("aTitle").value = fetchedItem.title || "";
                    document.getElementById("aIssuer").value = fetchedItem.issuer || "";
                    document.getElementById("aDesc").value = fetchedItem.description || "";
                    imgManagers.awards.setExisting(window.safeParseImages(fetchedItem.img));
                }
            } catch (err) {}
        }
      }

      document.getElementById("awardForm").onsubmit = async (e) => {
        e.preventDefault();
        if(!validateRequiredFields("awardForm")) return;

        const btn = document.getElementById("saveAwardBtn");
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        const isEdit = !!document.getElementById("aId").value;
        const editId = document.getElementById("aId").value;

        try {
            const uid = await getAuthUserId();
            const payloadSequence = imgManagers.awards.getFinalPayload();
            let finalUrls = [];
            
            const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
            let uploadedUrls = [];

            if (filesToUpload.length > 0) {
                try {
                    if (typeof window.CMS?.uploadImages === 'function') {
                        uploadedUrls = await window.CMS.uploadImages(filesToUpload, 'awards');
                        if(!uploadedUrls) uploadedUrls = [];
                    } else {
                        const db = window.getDbClient();
                        if (db) {
                            for (let file of filesToUpload) {
                                const fileExt = file.name.split('.').pop();
                                const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                const { data: uploadData, error } = await db.storage.from('awards').upload(fileName, file);
                                if (!error && uploadData) {
                                    const { data: publicUrlData } = db.storage.from('awards').getPublicUrl(fileName);
                                    if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                                }
                            }
                        }
                    }
                } catch (uploadErr) { throw uploadErr; }
            }

            let uploadIndex = 0;
            for (let item of payloadSequence) {
                if (item.type === 'url') {
                    finalUrls.push(item.data);
                } else if (item.type === 'file') {
                    if (uploadedUrls[uploadIndex]) {
                        finalUrls.push(uploadedUrls[uploadIndex]);
                    }
                    uploadIndex++;
                }
            }

            const data = {
                year: document.getElementById("aYear").value.trim(),
                title: document.getElementById("aTitle").value.trim(),
                issuer: document.getElementById("aIssuer").value.trim(),
                description: document.getElementById("aDesc").value.trim(),
                img: finalUrls,
                created_by: uid
            };
            
            if (editId) data.id = editId;
            let newlySavedId = editId;

            if (typeof window.CMS?.saveAward === 'function') {
                const res = await window.CMS.saveAward(data);
                if (res && res.id) newlySavedId = res.id;
            } else {
                const db = window.getDbClient();
                if (!db) throw new Error("Database client not found");
                const { data: savedData, error } = await db.from('awards').upsert(data).select();
                if (error) throw error;
                if (savedData && savedData[0]) newlySavedId = savedData[0].id;
            }

            window.closeAwardModal(); 
            await reloadAndPreserveScroll(loadAwards, isEdit, newlySavedId || null);
            loadDashboardStats(); 
            showToast("Award saved!"); 
        } catch (err) {
            showToast("Error saving award.", "error");
        } finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; }
      };
    };

    window.deleteAward = async (id) => {
        window.customConfirm("Delete Award", "Are you sure you want to permanently delete this award?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("awards", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("awards").delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("awards");
                await reloadAndPreserveScroll(loadAwards, false, null);
                loadDashboardStats();
                showToast("Award deleted."); 
            } catch (err) {
                showToast("Failed to delete award.", "error");
            }
        });
    };

    async function loadAwards(force = false) {
        const el = document.getElementById("awardList");
        const search = document.getElementById("awardSearch")?.value.toLowerCase() || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Awards...</p></div>`;
        try {
            const fetchFn = typeof window.CMS?.getAwards === 'function' ? window.CMS.getAwards : async () => {
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('awards').select('*').order('year',{ascending:false});
                return data;
            };
            let awards = await fetchFn(force) || [];
            window.appState.awards = awards;

            if (search) awards = awards.filter(a => (a.title||'').toLowerCase().includes(search) || (a.issuer||'').toLowerCase().includes(search));
            if (!awards?.length) { el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No awards found.</p>`; return; }
            
            const renderItem = (a, index) => `
                <div class="item-row" data-id="${a.id}" style="animation-delay: ${index * 0.03}s; border-left-color: var(--brand-gold);"> 
                    <div class="list-item-content">
                        ${window.safeParseImages(a.img)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(a.img)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-trophy"></i></div>`}
                        <div class="item-info">
                            <h4>${a.title}</h4>
                            <p><i class="fas fa-building"></i> ${a.issuer || 'Unknown Issuer'}</p>
                        </div> 
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="openAwardModal('${a.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="deleteAward('${a.id}')"><i class="fas fa-trash"></i></button>
                    </div> 
                </div>`;
            
            el.innerHTML = window.renderGroupedByYear(awards, renderItem, 'year');
        } catch(e) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load awards.</p>`; }
    }
    window.loadAwards = loadAwards;

    // ================================================
    // CRUD Logic: PRESS (Media)
    // ================================================
    window.openPressModal = async (id = null) => {
        showModal("pressModal");
        document.getElementById("pressModalTitle").textContent = id ? "Edit Media Recognition" : "New Media Recognition";
        document.getElementById("pressForm").reset();
        
        if (imgManagers.press) imgManagers.press.setExisting(null);
        document.getElementById("pressId").value = id || "";

        if (id) {
            const item = window.appState.press.find(c => c.id == id);
            if(item) {
                populatePressFields(item);
            } else {
                try {
                    const getById = typeof window.CMS?.getItemById === 'function' ? window.CMS.getItemById : async (t, i) => {
                        const db = window.getDbClient(); if(!db) return null;
                        const {data} = await db.from(t).select('*').eq('id',i).single(); return data;
                    };
                    const fetchedItem = await getById('press_clippings', id);
                    if (fetchedItem) populatePressFields(fetchedItem);
                } catch (err) { }
            }
        }

        function populatePressFields(data) {
            document.getElementById("pressPublication").value = data.media_source || data.publication || "";
            document.getElementById("pressTitle").value = data.title || "";
            document.getElementById("pressDate").value = data.publish_date || data.date || "";
            document.getElementById("pressSummary").value = data.summary || "";
            document.getElementById("pressLink").value = data.link || "";
            document.getElementById("pressIsFeatured").value = data.is_featured ? "true" : "false";
            
            const imgSrc = data.clipping_url || data.thumbnail_url || data.image || data.image_url;
            if (imgManagers.press && imgSrc) {
                imgManagers.press.setExisting(window.safeParseImages(imgSrc)[0]);
            }
        }

        document.getElementById("pressForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("pressForm")) return;

            const btn = document.getElementById("savePressBtn");
            btn.disabled = true; 
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("pressId").value;
            const editId = document.getElementById("pressId").value;

            try {
                const uid = await getAuthUserId();
                const payloadInfo = imgManagers.press.getFinalPayload();
                let finalUrl = payloadInfo.existingUrl;
                
                if (payloadInfo.newFile) {
                    try {
                        const uploadFn = typeof window.CMS?.uploadImages === 'function' ? window.CMS.uploadImages : null;
                        if(uploadFn) {
                            const uploadedUrls = await uploadFn([payloadInfo.newFile], 'press');
                            if (uploadedUrls && uploadedUrls.length > 0) finalUrl = uploadedUrls[0];
                        } else {
                            const db = window.getDbClient();
                            if(db) {
                                const fileExt = payloadInfo.newFile.name.split('.').pop();
                                const fileName = `${Math.random()}.${fileExt}`;
                                const { data: uploadData, error: uploadError } = await db.storage.from('press').upload(fileName, payloadInfo.newFile);
                                if (!uploadError && uploadData) {
                                    const { data: publicUrlData } = db.storage.from('press').getPublicUrl(fileName);
                                    if(publicUrlData) finalUrl = publicUrlData.publicUrl;
                                }
                            }
                        }
                    } catch (uploadErr) { throw uploadErr; }
                }

                const data = {
                    title: document.getElementById("pressTitle").value.trim(),
                    media_source: document.getElementById("pressPublication").value.trim(),
                    publish_date: document.getElementById("pressDate").value,
                    summary: document.getElementById("pressSummary").value.trim(),
                    link: document.getElementById("pressLink").value.trim(),
                    is_featured: document.getElementById("pressIsFeatured").value === "true",
                    thumbnail_url: finalUrl,
                    clipping_url: finalUrl,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.savePressCoverage === 'function') {
                    const res = await window.CMS.savePressCoverage(data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not available");
                    const { data: savedData, error } = await db.from('press_clippings').upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }
                
                window.closePressModal(); 
                await reloadAndPreserveScroll(loadPress, isEdit, newlySavedId || null);
                showToast("Clipping saved!");
            } catch (err) { 
                showToast("Error saving clipping.", "error"); 
            } finally { 
                btn.disabled = false; 
                btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
            }
        };
    };

    window.deletePress = async (id) => {
        window.customConfirm("Delete Media Recognition", "Delete this media clipping permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("press_clippings", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("press_clippings").delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("press_clippings");
                await reloadAndPreserveScroll(loadPress, false, null);
                showToast("Deleted."); 
            } catch (err) { 
                showToast("Failed to delete.", "error"); 
            }
        });
    };

    async function loadPress(force = false) {
        const el = document.getElementById("press-list");
        if (!el) return;
        const search = document.getElementById("pressSearch")?.value.toLowerCase() || "";
        
        if(!document.querySelector('.highlight-item')) {
            el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Media...</p></div>`;
        }

        try {
            const fetchFn = typeof window.CMS?.getPressClippings === 'function' ? window.CMS.getPressClippings : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('press_clippings').select('*').order('publish_date',{ascending:false}); 
                return data;
            };

            let clippings = await fetchFn(force) || [];
            window.appState.press = clippings;

            if (search) {
                clippings = clippings.filter(c => 
                    (c.title||'').toLowerCase().includes(search) || 
                    (c.media_source||'').toLowerCase().includes(search)
                );
            }

            if (!clippings.length) { 
                el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No media found.</p>`; 
                return; 
            }
            
            const renderItem = (item, index) => {
                const displayImg = item.clipping_url || item.thumbnail_url || item.image || item.image_url;
                return `
                <div class="item-row" data-id="${item.id}" style="animation-delay: ${index * 0.03}s; border-left-color: var(--info);">
                    <div class="list-item-content">
                        ${displayImg ? `<img loading="lazy" src="${window.safeParseImages(displayImg)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-newspaper"></i></div>`}
                        <div class="item-info">
                            <h4>${item.title || "Untitled"} ${item.is_featured ? '<span class="badge warning" style="margin-left:8px;">Featured</span>' : ''}</h4>
                            <p><strong>${item.media_source || "—"}</strong> &nbsp;|&nbsp; <i class="far fa-calendar-alt"></i> ${item.publish_date || ""}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openPressModal('${item.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deletePress('${item.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`;
            };
            el.innerHTML = window.renderGroupedByYear(clippings, renderItem, 'publish_date');
        } catch (err) { 
            el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load clippings.</p>`; 
        }
    }
    window.loadPress = loadPress;

   // ================================================
   // CRUD Logic: NEWS & REDESIGNED UI 
   // ================================================

   // News Selection Handlers
   window.isNewsSelectMode = false;
   
   window.toggleNewsSelectMode = () => {
       window.isNewsSelectMode = !window.isNewsSelectMode;
       const container = document.getElementById("page-news");
       const actionBtn = document.getElementById("toggleSelectNewsBtn");
       const bulkBar = document.getElementById("newsBulkActions");
       
       if(window.isNewsSelectMode) {
           container.classList.add("select-mode-active");
           actionBtn.style.display = "none";
           bulkBar.style.display = "flex";
       } else {
           container.classList.remove("select-mode-active");
           actionBtn.style.display = "flex";
           bulkBar.style.display = "none";
           // Deselect all
           document.querySelectorAll('.bulk-cb').forEach(cb => cb.checked = false);
           document.getElementById('selectAllNewsCb').checked = false;
           updateBulkCount();
       }
   };

   window.toggleSelectAllNews = (el) => {
       const checkboxes = document.querySelectorAll('.bulk-cb');
       checkboxes.forEach(cb => cb.checked = el.checked);
       updateBulkCount();
   };

   window.updateBulkCount = () => {
       const count = document.querySelectorAll('.bulk-cb:checked').length;
       document.getElementById('newsSelectedCount').textContent = `${count} record${count !== 1 ? 's' : ''} selected`;
   };

   window.bulkDeleteNews = async () => {
       const selectedCbs = document.querySelectorAll('.bulk-cb:checked');
       const ids = Array.from(selectedCbs).map(cb => cb.value);
       
       if(ids.length === 0) {
           showToast("Please select at least one record to delete.", "warning");
           return;
       }

       window.customConfirm("Bulk Delete News", `Are you sure you want to permanently delete ${ids.length} news record(s)? This cannot be undone.`, async () => {
           try {
               const db = window.getDbClient();
               if (!db) throw new Error("Database client not found");

               // Delete all selected
               const { error } = await db.from("news").delete().in('id', ids);
               if (error) throw error;
               
               clearCache("news"); 
               window.toggleNewsSelectMode(); // Exit select mode
               await reloadAndPreserveScroll(loadNews, false, null);
               loadDashboardStats(); 
               showToast(`Successfully deleted ${ids.length} records.`); 
           } catch (err) { 
               showToast("Failed to delete records.", "error");
           }
       });
   };

   // Helper for robust Date parsing to group cleanly
   function extractYearFromNewsDate(dateString) {
       if (!dateString) return 'Unknown';
       if (dateString.includes('/')) return dateString.split('/')[2];
       if (dateString.includes('-')) return dateString.split('-')[0];
       return 'Unknown';
   }

   // Redesigned renderGrouped specifically for News for perfection
   function renderNewsGroupedByYear(items) {
        const grouped = items.reduce((acc, item) => {
            const y = extractYearFromNewsDate(item.date);
            if (!acc[y]) acc[y] = [];
            acc[y].push(item);
            return acc;
        }, {});

        const years = Object.keys(grouped).sort((a, b) => {
            if (a === 'Unknown') return 1;
            if (b === 'Unknown') return -1;
            return parseInt(b) - parseInt(a);
        });

        return years.map(year => `
            <div class="year-group">
                <div class="year-header" onclick="this.parentElement.classList.toggle('collapsed')">
                    <h3>${year === 'Unknown' ? 'Others' : year} <span class="badge solid">${grouped[year].length}</span></h3>
                    <i class="fas fa-chevron-up toggle-icon"></i>
                </div>
                <div class="year-content list-container">
                    ${grouped[year].map((n, index) => `
                        <label class="item-row" data-id="${n.id}" style="animation-delay: ${index * 0.03}s; border-left-color: var(--sidebar-bg); display: flex; align-items: center; cursor: ${window.isNewsSelectMode ? 'pointer' : 'default'};"> 
                            <div class="list-item-content">
                                <input type="checkbox" class="bulk-cb" value="${n.id}" onchange="updateBulkCount()">
                                ${window.safeParseImages(n.img || n.photos)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(n.img || n.photos)[0]}" class="list-thumbnail" onclick="if(!window.isNewsSelectMode) openLightbox(this.src); event.preventDefault();">` : `<div class="empty-thumbnail"><i class="fas fa-bullhorn"></i></div>`}
                                <div class="item-info">
                                    <h4>${n.title || "Untitled"}</h4>
                                    <p><i class="far fa-calendar-alt"></i> ${n.date || "No date"} &nbsp;|&nbsp; <span class="badge solid">${n.category || 'General'}</span></p>
                                </div> 
                            </div>
                            <div class="actions">
                                <button type="button" class="btn-edit action-btn" onclick="openNewsModal('${n.id}'); event.preventDefault();"><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" class="btn-delete action-btn" onclick="deleteNews('${n.id}'); event.preventDefault();"><i class="fas fa-trash"></i></button>
                            </div> 
                        </label>
                    `).join('')}
                </div>
            </div>
        `).join('');
   }

   async function loadNews(force = false) {
       const el = document.getElementById("newsList");
       const search = document.getElementById("newsSearch")?.value.toLowerCase() || "";
       const categoryFilter = document.getElementById("newsCategoryFilter")?.value || "";
       
       if(!document.querySelector('.highlight-item')) {
           el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading News...</p></div>`;
       }

       try {
           const fetchFn = typeof window.CMS?.getNews === 'function' ? window.CMS.getNews : async () => {
               const db = window.getDbClient();
               if(!db) throw new Error("Database Client Not Initialized");
               const {data} = await db.from('news').select('*').order('date',{ascending:false});
               return data;
           };
           
           let items = await fetchFn(force) || [];
           window.appState.news = items;

           if (search) items = items.filter(n => (n.title || '').toLowerCase().includes(search));
           if (categoryFilter) items = items.filter(n => (n.category || 'General') === categoryFilter);
           
           if (!items?.length) { 
               el.innerHTML = `<p style="text-align:center; color:var(--text-muted); padding:3rem;">No news found.</p>`; 
               return; 
           }
           
           el.innerHTML = renderNewsGroupedByYear(items);

           // Re-apply select mode UI state if active
           if(window.isNewsSelectMode) {
               document.getElementById("page-news").classList.add("select-mode-active");
           }

       } catch(e) {
           el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load news.</p>`;
       }
   }
   window.loadNews = loadNews;

   window.openNewsModal = async (id = null) => {
       showModal("newsModal");
       document.getElementById("newsModalTitle").textContent = id ? "Edit News Item" : "New News Item";
       document.getElementById("newsForm").reset();
       imgManagers.news.setExisting([]);
       document.getElementById("nId").value = id || "";

       if (id) {
            const item = window.appState.news.find(n => n.id == id);
            if(item) {
                let displayDate = "";
                if (item.date && item.date.includes('/')) {
                    const parts = item.date.split('/');
                    if(parts.length === 3) displayDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                } else if (item.date && item.date.includes('-')) {
                    displayDate = item.date;
                }
                document.getElementById("nDate").value = displayDate;
                document.getElementById("nCategory").value = item.category || "General";
                document.getElementById("nTitle").value = item.title || "";
                document.getElementById("nContent").value = item.description || "";
                imgManagers.news.setExisting(window.safeParseImages(item.img || item.photos));
            } else {
                try {
                    const getById = typeof window.CMS?.getNewsById === 'function' ? window.CMS.getNewsById : async (i) => {
                        const db = window.getDbClient(); if(!db) return null;
                        const {data} = await db.from('news').select('*').eq('id',i).single(); return data;
                    };
                    const fetchedItem = await getById(id);
                    if (fetchedItem) {
                        let displayDate = "";
                        if (fetchedItem.date && fetchedItem.date.includes('/')) {
                            const parts = fetchedItem.date.split('/');
                            displayDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                        } else {
                            displayDate = fetchedItem.date || "";
                        }
                        document.getElementById("nDate").value = displayDate;
                        document.getElementById("nCategory").value = fetchedItem.category || "General";
                        document.getElementById("nTitle").value = fetchedItem.title || "";
                        document.getElementById("nContent").value = fetchedItem.description || "";
                        imgManagers.news.setExisting(window.safeParseImages(fetchedItem.img || fetchedItem.photos));
                    }
                } catch (err) {}
            }
       }

       document.getElementById("newsForm").onsubmit = async (e) => {
           e.preventDefault();
           if(!validateRequiredFields("newsForm")) return;

           const btn = document.getElementById("saveNewsBtn");
           btn.disabled = true; 
           btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
           const isEdit = !!document.getElementById("nId").value;
           const editId = document.getElementById("nId").value;

           try {
               const uid = await getAuthUserId();
               const payloadSequence = imgManagers.news.getFinalPayload();
               let finalUrls = [];
               const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
               let uploadedUrls = [];

               if (filesToUpload.length > 0) {
                   try {
                       if (typeof window.CMS?.uploadImages === 'function') {
                           uploadedUrls = await window.CMS.uploadImages(filesToUpload, 'news');
                           if (!uploadedUrls) uploadedUrls = [];
                       } else {
                           const db = window.getDbClient();
                           if (db) {
                               for (let file of filesToUpload) {
                                   const fileExt = file.name.split('.').pop();
                                   const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                   const { data: uploadData, error } = await db.storage.from('news').upload(fileName, file);
                                   if (!error && uploadData) {
                                       const { data: publicUrlData } = db.storage.from('news').getPublicUrl(fileName);
                                       if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                                   }
                               }
                           }
                       }
                   } catch (uploadErr) { throw uploadErr; }
               }

               let uploadIndex = 0;
               for (let item of payloadSequence) {
                   if (item.type === 'url') {
                       finalUrls.push(item.data);
                   } else if (item.type === 'file') {
                       if (uploadedUrls[uploadIndex]) {
                           finalUrls.push(uploadedUrls[uploadIndex]);
                       }
                       uploadIndex++;
                   }
               }
               
               const inputDate = document.getElementById("nDate").value; 
               let databaseDate = null;
               if (inputDate) {
                   const [y, m, d] = inputDate.split('-');
                   databaseDate = `${d}/${m}/${y}`;
               }

               const data = {
                   year: inputDate ? parseInt(inputDate.substring(0, 4)) : new Date().getFullYear(),
                   title: document.getElementById("nTitle").value.trim(),
                   date: databaseDate, 
                   category: document.getElementById("nCategory").value,
                   description: document.getElementById("nContent").value.trim(),
                   img: finalUrls,
                   created_by: uid 
               };
               
               if (editId) data.id = editId;
               let newlySavedId = editId;

               if (typeof window.CMS?.saveNews === 'function') {
                   const res = await window.CMS.saveNews(data);
                   if (res && res.id) newlySavedId = res.id;
               } else {
                   const db = window.getDbClient();
                   if (!db) throw new Error("Database client not found");
                   const { data: savedData, error } = await db.from('news').upsert(data).select();
                   if (error) throw error;
                   if (savedData && savedData[0]) newlySavedId = savedData[0].id;
               }

               window.closeNewsModal(); 
               await reloadAndPreserveScroll(loadNews, isEdit, newlySavedId || null);
               loadDashboardStats(); 
               showToast("News item saved!"); 
           } catch (err) {
               showToast("Error saving news.", "error");
           } finally { 
               btn.disabled = false; 
               btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
           }
       };
   };

   window.deleteNews = async (id) => {
       window.customConfirm("Delete News", "Delete this news item permanently?", async () => {
           try { 
               if (typeof window.CMS?.deleteItem === 'function') {
                   await window.CMS.deleteItem("news", id);
               } else {
                   const db = window.getDbClient();
                   if (!db) throw new Error("Database client not found");
                   const { error } = await db.from("news").delete().eq('id', id);
                   if (error) throw error;
               }
               clearCache("news"); 
               await reloadAndPreserveScroll(loadNews, false, null);
               loadDashboardStats(); 
               showToast("News deleted."); 
           } catch (err) { 
               showToast("Failed to delete news.", "error");
           }
       });
   };
   
    // ================================================
    // CRUD Logic: CULTURE
    // ================================================
    const SUB_CAT_MAP = {
        festive: [ {v:'cny', t:'Chinese New Year'}, {v:'raya', t:'Hari Raya'}, {v:'midautumn', t:'Mid-Autumn'}, {v:'durian', t:'Durian Party'}, {v:'birthday', t:'Birthday'}, {v:'christmas', t:'Christmas'},{v:'wintersolstice',t:'Winter Solstice'},{v:'dumpling',t:'Dumpling Festival'},{v:'teambuilding', t:'Team Building'}, {v:'others', t:'Others'} ],
        csr: [ {v:'charity', t:'Charity'}, {v:'community', t:'Community'} ],
        work: [ {v:'sports', t:'Sports Day'}, {v:'seminar', t:'Seminar'} ],
        training: [ {v:'internal', t:'Internal Training'} ],
        intern: [ {v:'intern',t:'Industrial Training'} ],
        sponsor:[ {v:'sponsor' , t:'Sponsorship'}]
    };

    window.updateModalSubOptions = function(selectedVal = 'all') {
        const typeEl = document.getElementById('cType');
        const subSelect = document.getElementById('cSubCategory');
        if (!typeEl || !subSelect) return;
        const mainType = typeEl.value;
        subSelect.innerHTML = '<option value="all">Default / All</option>';
        if (SUB_CAT_MAP[mainType]) {
            SUB_CAT_MAP[mainType].forEach(opt => {
                const el = document.createElement('option');
                el.value = opt.v; el.textContent = opt.t;
                if(opt.v === selectedVal) el.selected = true;
                subSelect.appendChild(el);
            });
        }
    };

    window.openCultureModal = async (id = null) => {
        showModal("cultureModal");
        document.getElementById("cultureModalTitle").textContent = id ? "Edit Event" : "New Event";
        document.getElementById("cultureForm").reset();
        imgManagers.culture.setExisting([]);
        document.getElementById("cId").value = id || "";
        
        document.getElementById("cId").dataset.table = 'culture';

        if (id) {
            const item = window.appState.culture.find(c => c.id == id);
            if(item) {
                document.getElementById("cId").dataset.table = item._sourceTable || 'culture';
                document.getElementById("cYear").value = item.year || "";
                document.getElementById("cType").value = item.type || "";
                window.updateModalSubOptions(item.sub_category || 'all');
                document.getElementById("cName").value = item.name || "";
                document.getElementById("cLocation").value = item.location || "";
                document.getElementById("cDescription").value = item.description || "";
                imgManagers.culture.setExisting(window.safeParseImages(item.img));
            } else {
                try {
                    const db = window.getDbClient();
                    if(db) {
                        let fetchedItem = null;
                        let sTable = 'culture';
                        
                        const {data: d1} = await db.from('culture').select('*').eq('id',id).single();
                        if (d1) { 
                            fetchedItem = d1; 
                        } else {
                            const {data: d2} = await db.from('culture_sorted').select('*').eq('id',id).single();
                            if(d2) { 
                                fetchedItem = d2; 
                                sTable = 'culture_sorted'; 
                            }
                        }
                        
                        if (fetchedItem) {
                            document.getElementById("cId").dataset.table = sTable;
                            document.getElementById("cYear").value = fetchedItem.year || "";
                            document.getElementById("cType").value = fetchedItem.type || "";
                            window.updateModalSubOptions(fetchedItem.sub_category || 'all');
                            document.getElementById("cName").value = fetchedItem.name || "";
                            document.getElementById("cLocation").value = fetchedItem.location || "";
                            document.getElementById("cDescription").value = fetchedItem.description || "";
                            imgManagers.culture.setExisting(window.safeParseImages(fetchedItem.img));
                        }
                    }
                } catch (err) {}
            }
        } else {
            window.updateModalSubOptions();
        }

        document.getElementById("cultureForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("cultureForm")) return;

            const btn = document.getElementById("saveCultureBtn");
            btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("cId").value;
            const editId = document.getElementById("cId").value;
            const targetTable = document.getElementById("cId").dataset.table || 'culture';
            const targetBucket = 'culture';

            try {
                const uid = await getAuthUserId();
                const payloadSequence = imgManagers.culture.getFinalPayload();
                let finalUrls = [];
                const filesToUpload = payloadSequence.filter(item => item.type === 'file').map(item => item.data);
                let uploadedUrls = [];

                if (filesToUpload.length > 0) {
                    try {
                        if (typeof window.CMS?.uploadImages === 'function') {
                            uploadedUrls = await window.CMS.uploadImages(filesToUpload, targetBucket);
                            if (!uploadedUrls) uploadedUrls = [];
                        } else {
                            const db = window.getDbClient();
                            if (db) {
                                for (let file of filesToUpload) {
                                    const fileExt = file.name.split('.').pop();
                                    const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                    const { data: uploadData, error } = await db.storage.from(targetBucket).upload(fileName, file);
                                    if (!error && uploadData) {
                                        const { data: publicUrlData } = db.storage.from(targetBucket).getPublicUrl(fileName);
                                        if(publicUrlData) uploadedUrls.push(publicUrlData.publicUrl);
                                    }
                                }
                            }
                        }
                    } catch (uploadErr) { throw uploadErr; }
                }

                let uploadIndex = 0;
                for (let item of payloadSequence) {
                    if (item.type === 'url') {
                        finalUrls.push(item.data);
                    } else if (item.type === 'file') {
                        if (uploadedUrls[uploadIndex]) {
                            finalUrls.push(uploadedUrls[uploadIndex]);
                        }
                        uploadIndex++;
                    }
                }

                const yearInput = parseInt(document.getElementById("cYear").value.trim());

                const data = {
                    year: !isNaN(yearInput) ? yearInput : null,
                    name: document.getElementById("cName").value.trim(),
                    location: document.getElementById("cLocation").value.trim(),
                    type: document.getElementById("cType").value,
                    sub_category: document.getElementById("cSubCategory").value,
                    description: document.getElementById("cDescription").value.trim(),
                    img: finalUrls,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.saveItem === 'function') {
                    const res = await window.CMS.saveItem(targetTable, data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { data: savedData, error } = await db.from(targetTable).upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }

                window.closeCultureModal(); 
                await reloadAndPreserveScroll(loadCulture, isEdit, newlySavedId || null);
                loadDashboardStats(); 
                showToast("Event saved successfully!"); 
            } catch (err) { 
                showToast("Error saving event.", "error"); 
            } finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; }
        };
    };

    window.deleteCulture = async (id, sourceTable = 'culture') => {
        window.customConfirm("Delete Event", "Delete this culture event permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem(sourceTable, id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from(sourceTable).delete().eq('id', id);
                    if (error) throw error;
                }
                clearCache("culture"); 
                clearCache("culture_sorted");
                await reloadAndPreserveScroll(loadCulture, false, null);
                loadDashboardStats(); 
                showToast("Event deleted."); 
            } catch (err) {
                showToast("Failed to delete event.", "error");
            }
        });
    };

    async function loadCulture(force = false) {
        const el = document.getElementById("cultureList");
        const search = document.getElementById("cultureSearch")?.value.toLowerCase() || "";
        const yF = document.getElementById("cultureYearFilter")?.value || "";
        const tF = document.getElementById("cultureTypeFilter")?.value || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading Events...</p></div>`;
        try {
            const db = window.getDbClient();
            if(!db) throw new Error("Database Client Not Initialized");

            const [cultRes, sortRes] = await Promise.allSettled([
                db.from('culture').select('*'),
                db.from('culture_sorted').select('*')
            ]);

            let items = [];
            
            if (cultRes.status === 'fulfilled' && cultRes.value.data) {
                const cData = cultRes.value.data.map(item => ({ ...item, _sourceTable: 'culture' }));
                items.push(...cData);
            }
            if (sortRes.status === 'fulfilled' && sortRes.value.data) {
                const sData = sortRes.value.data.map(item => ({ ...item, _sourceTable: 'culture_sorted' }));
                items.push(...sData);
            }

            const uniqueItems = [];
            const ids = new Set();
            for (const item of items) {
                if (!ids.has(item.id)) {
                    ids.add(item.id);
                    uniqueItems.push(item);
                }
            }
            items = uniqueItems;

            items.sort((a, b) => (b.year || 0) - (a.year || 0));

            window.appState.culture = items;
            
            const ys = document.getElementById("cultureYearFilter");
            if(ys) {
                const currentVal = ys.value;
                const years = [...new Set(items.map(i => i.year))].filter(Boolean).sort((a, b) => b - a);
                ys.innerHTML = '<option value="">All Years</option>' + years.map(y => `<option value="${y}" ${y == currentVal ? 'selected' : ''}>${y}</option>`).join('');
            }
            
            if(search) items = items.filter(i => (i.name||"").toLowerCase().includes(search));
            if(yF) items = items.filter(i => String(i.year) === String(yF));
            if(tF) items = items.filter(i => i.type === tF);
            
            if(!items.length) { 
                if(document.getElementById("cultureEmpty")) document.getElementById("cultureEmpty").style.display="flex"; 
                el.innerHTML=""; return; 
            }
            if(document.getElementById("cultureEmpty")) document.getElementById("cultureEmpty").style.display="none";

            const renderItem = (item, index) => `
                <div class="item-row" data-id="${item.id}" style="animation-delay: ${index * 0.03}s; border-left-color: #8B5CF6;">
                    <div class="list-item-content">
                        ${window.safeParseImages(item.img)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(item.img)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-users"></i></div>`}
                        <div class="item-info">
                            <h4>${item.name || "Untitled"}</h4>
                            <p style="text-transform:capitalize;">${item.type || ""} &nbsp;|&nbsp; <i class="fas fa-map-marker-alt"></i> ${item.location || "Multiple locations"}</p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openCultureModal('${item.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteCulture('${item.id}', '${item._sourceTable || 'culture'}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            el.innerHTML = window.renderGroupedByYear(items, renderItem, 'year');
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load culture events.</p>`; }
    }
    window.loadCulture = loadCulture;

    // ================================================
    // CRUD Logic: CERTIFICATIONS
    // ================================================
    const CertificationManager = (function() {
        const CATEGORIES = [
            { id: 'cidb', table: 'cidb_star_ratings', label: 'CIDB Star Ratings', icon: 'fa-award', color: 'var(--warning)' },
            { id: 'shassic', table: 'shassic_scores', label: 'SHASSIC Scores', icon: 'fa-shield-halved', color: 'var(--success)' },
            { id: 'gbi', table: 'gbi_facilitator_certificates', label: 'GBI Facilitator', icon: 'fa-leaf', color: 'var(--success)' },
            { id: 'qlassic', table: 'qlassic_conquas_scores', label: 'QLASSIC / CONQUAS', icon: 'fa-check-double', color: 'var(--info)' }
        ];

        const openModal = (table, existingData = null) => {
            document.getElementById("certTable").value = table;
            document.getElementById("certId").value = existingData?.id || '';
            document.getElementById("certModalTitle").textContent = existingData ? `Edit Certification` : `New Certification`;

            document.getElementById("certSpecificFields").innerHTML = `
                <div class="form-row">
                    <div class="form-group half">
                        <label>Assessment Year <span class="required">*</span></label>
                        <input type="number" id="cCertYear" required min="1990" max="2100" value="${existingData?.year || new Date().getFullYear()}">
                    </div>
                    <div class="form-group half">
                        <label>Grade / Level <span class="required">*</span></label>
                        <input type="text" id="cGrade" required placeholder="e.g. G7, 4 Stars" value="${existingData?.grade || ''}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group half">
                        <label>Star Rating (0-5)</label>
                        <input type="number" id="cStar" min="0" max="5" value="${existingData?.star_rating !== undefined && existingData?.star_rating !== null ? existingData.star_rating : ''}">
                    </div>
                    <div class="form-group half">
                        <label>Score (%)</label>
                        <input type="number" id="cScore" step="0.01" min="0" max="100" placeholder="0.00" value="${existingData?.score || ''}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Project / Remarks</label>
                    <textarea id="cRemarks" rows="3" placeholder="Detail the project name...">${existingData?.remarks || ''}</textarea>
                </div>
                <div class="form-group">
                    <label>Document (Image/PDF)</label>
                    <div id="certDrop" class="drag-area">
                        <i class="fas fa-file-pdf"></i>
                        <div style="font-weight: 600; font-size: 1.1rem;">Click or drag to upload</div>
                    </div>
                    <input type="file" id="certFile" hidden accept="image/*,application/pdf">
                    <div id="certPreview" class="preview-container"></div>
                </div>`;

            imgManagers.cert = new SingleImageManager("certDrop", "certFile", "certPreview");
            if(existingData?.document_url) {
                imgManagers.cert.setExisting(window.safeParseImages(existingData.document_url)[0] || existingData.document_url);
            }

            document.getElementById("certForm").onsubmit = async (e) => {
                e.preventDefault();
                if(!validateRequiredFields("certForm")) return;

                const btn = document.getElementById("saveCertBtn");
                btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                const isEdit = !!document.getElementById("certId").value;
                const editingId = document.getElementById("certId").value;
                
                const submittedTable = document.getElementById("certTable").value;

                const db = window.getDbClient();
                if (!db) {
                   showToast("Database client missing.", "error"); 
                   btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record';
                   return;
                }

                try {
                    const uid = await getAuthUserId();
                    const payloadInfo = imgManagers.cert.getFinalPayload();
                    let finalUrl = payloadInfo.existingUrl;

                    if (payloadInfo.newFile) {
                        try {
                            if (typeof window.CMS?.uploadImages === 'function') {
                                const uploaded = await window.CMS.uploadImages([payloadInfo.newFile], `certs/${submittedTable}`);
                                if (uploaded?.length) finalUrl = uploaded[0];
                            } else {
                                const db = window.getDbClient();
                                if (db) {
                                    const fileExt = payloadInfo.newFile.name.split('.').pop();
                                    const fileName = `${Math.random().toString(36).substring(2)}.${fileExt}`;
                                    const { data: uploadData, error } = await db.storage.from('certifications').upload(fileName, payloadInfo.newFile);
                                    if (!error && uploadData) {
                                        const { data: publicUrlData } = db.storage.from('certifications').getPublicUrl(fileName);
                                        if(publicUrlData) finalUrl = publicUrlData.publicUrl;
                                    }
                                }
                            }
                        } catch (uploadErr) {
                            throw new Error("Upload failed");
                        }
                    }

                    const starRatingInput = parseInt(document.getElementById('cStar').value);
                    const yearInput = parseInt(document.getElementById('cCertYear').value);

                    const payload = {
                        year: !isNaN(yearInput) ? yearInput : new Date().getFullYear(),
                        grade: document.getElementById('cGrade').value.trim(),
                        star_rating: !isNaN(starRatingInput) ? starRatingInput : 0,
                        score: document.getElementById('cScore').value ? parseFloat(document.getElementById('cScore').value) : null,
                        remarks: document.getElementById('cRemarks').value.trim() || null,
                        document_url: finalUrl,
                        created_by: uid
                    };
                    
                    if (editingId) payload.id = editingId;

                    const { data, error } = await db.from(submittedTable).upsert(payload).select();
                    if (error) throw error;

                    window.closeCertModal();
                    let newlySavedId = data && data[0] ? data[0].id : editingId;
                    await reloadAndPreserveScroll(loadData, isEdit, newlySavedId || null);
                    showToast("Record saved.");
                } catch (err) { showToast("Error saving record.", "error"); } finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; }
            };

            showModal("certModal");
        };

        const loadData = async () => {
            const container = document.getElementById("certificationsList");
            if (!container) return;
            if(!document.querySelector('.highlight-item')) container.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;

            const db = window.getDbClient();
            if (!db) {
              container.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Database disconnected.</p>`;
              return;
            }

            try {
                const results = await Promise.allSettled( CATEGORIES.map(cat => db.from(cat.table).select('*').order('year', { ascending: false })) );
                
                let html = '';
                results.forEach((res, i) => {
                    const cat = CATEGORIES[i];
                    let items = [];
                    let errorMsg = '';
                    
                    if (res.status === 'fulfilled') {
                        if (res.value.error) {
                            errorMsg = res.value.error.message;
                        } else {
                            items = res.value.data || [];
                        }
                    } else {
                        errorMsg = res.reason;
                    }
                    
                    const renderCertItem = (item, idx) => {
                        const docUrlStr = String(item.document_url || '');
                        const isPdf = docUrlStr.toLowerCase().includes('.pdf');
                        const parsedUrl = item.document_url ? window.safeParseImages(item.document_url)[0] : '';
                        return `
                        <div class="item-row" data-id="${item.id}" style="border-left-color: ${cat.color}; animation-delay: ${idx * 0.05}s;">
                            <div class="list-item-content">
                                ${isPdf ? `<div class="empty-thumbnail" style="cursor:pointer;" onclick="window.open('${parsedUrl}', '_blank')"><i class="fas fa-file-pdf" style="color:var(--danger)"></i></div>` : (parsedUrl ? `<img loading="lazy" src="${parsedUrl}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-file-pdf"></i></div>`)}
                                <div class="item-info">
                                    <h4><span class="badge solid">${item.year}</span> ${item.grade || 'No Grade'}</h4>
                                    <p>${item.remarks || 'No remarks.'}</p>
                                </div>
                            </div>
                            <div class="actions">
                                <button class="btn-edit" onclick="CertificationManager.edit('${cat.table}', '${item.id}')"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn-delete" onclick="CertificationManager.remove('${cat.table}', '${item.id}')"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        `;
                    };

                    const groupedHtml = items.length > 0 ? window.renderGroupedByYear(items, renderCertItem, 'year') : '';

                    html += `
                        <div style="margin-bottom: 2rem; background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                            <h3 style="display:flex; align-items:center; gap:0.75rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom:1rem; font-size: 1.2rem;">
                                <i class="fas ${cat.icon}" style="color:${cat.color};"></i> <span>${cat.label}</span> 
                                <span class="badge solid" style="margin-left: auto;">${items.length} Records</span>
                            </h3>
                            ${errorMsg ? `<p style="color:var(--danger); font-size:0.95rem;">Error loading: ${errorMsg}.</p>` : ''}
                            ${(!errorMsg && items.length === 0) ? '<p style="color:var(--text-muted); font-size:0.95rem;">No records found.</p>' : `<div class="list-container">${groupedHtml}</div>`}
                        </div>`;
                });
                container.innerHTML = html;
            } catch (err) { container.innerHTML = `<p style="color:var(--danger); text-align: center;">Failed to load data.</p>`; }
        };

        return { 
            init: loadData, 
            create: (table) => openModal(table), 
            edit: async (table, id) => { 
                const db = window.getDbClient();
                if (!db) return;
                const { data } = await db.from(table).select('*').eq('id', id).single(); 
                if (data) openModal(table, data); 
            }, 
            remove: async (table, id) => { 
                window.customConfirm("Delete Certification", "Permanently delete this certification?", async () => {
                    try {
                        if (typeof window.CMS?.deleteItem === 'function') {
                            await window.CMS.deleteItem(table, id);
                        } else {
                            const db = window.getDbClient();
                            if (!db) throw new Error("Database client not found");
                            const { error } = await db.from(table).delete().eq('id', id);
                            if (error) throw error;
                        }
                        await reloadAndPreserveScroll(loadData, false, null); 
                        showToast("Record deleted.");
                    } catch (err) {
                        showToast("Failed to delete record.", "error");
                    }
                });
            } 
        };
    })();
    window.CertificationManager = CertificationManager;

    // ================================================
    // CRUD Logic: INQUIRIES
    // ================================================
    window.openInquiryModal = async (id) => {
        showModal("inquiryModal");
        try {
            let inquiry = window.appState.inquiries.find(i => i.id == id);
            if(!inquiry) {
                const getInq = typeof window.CMS?.getInquiryById === 'function' ? window.CMS.getInquiryById : async (i) => { 
                    const db = window.getDbClient();
                    if(!db) throw new Error("Database Missing");
                    const {data} = await db.from('inquiries').select('*').eq('id',i).single(); 
                    return data; 
                };
                inquiry = await getInq(id); 
            }
            if (!inquiry) throw new Error("Inquiry not found");
            
            document.getElementById("iId").value = id;
            document.getElementById("iFullName").value = inquiry.full_name || inquiry.name || "—";
            document.getElementById("iCompany").value = inquiry.company || "—";
            document.getElementById("iEmail").value = inquiry.email || "—";
            document.getElementById("iPhone").value = inquiry.phone || "—";
            document.getElementById("iNature").value = inquiry.nature || "—";
            document.getElementById("iMessage").value = inquiry.message || "";
            document.getElementById("iStatus").value = inquiry.status || "new";
            document.getElementById("iAdminNotes").value = inquiry.admin_notes || "";

            const arcBtn = document.getElementById("archiveInquiryBtn");
            if(arcBtn) {
                if((inquiry.status || "new").toLowerCase() === 'archived') {
                    arcBtn.style.display = 'none';
                } else {
                    arcBtn.style.display = 'block';
                }
            }

        } catch (err) { showToast("Could not load inquiry.", "error");}
    };

    document.getElementById("saveInquiryBtn")?.addEventListener("click", async () => {
        const id = document.getElementById("iId").value;
        const status = document.getElementById("iStatus").value;
        const admin_notes = document.getElementById("iAdminNotes").value;
        try {
            if (typeof window.CMS?.updateInquiry === 'function') {
                await window.CMS.updateInquiry({id, status, admin_notes});
            } else {
                const db = window.getDbClient();
                const {error} = await db.from('inquiries').update({status, admin_notes}).eq('id', id); 
                if (error) throw error;
            }
            
            window.closeInquiryModal();
            await reloadAndPreserveScroll(loadInquiries, true, id);
            if (typeof loadArchivedInquiries === 'function') loadArchivedInquiries(true); 
            refreshUnreadBadge();
            showToast("Inquiry updated.");
        } catch(e) {
            showToast("Failed to update inquiry.", "error");
        }
    });

    document.getElementById("archiveInquiryBtn")?.addEventListener("click", async function() {
        window.customConfirm("Archive Inquiry", "Move this inquiry to the archive?", async () => {
            const id = document.getElementById("iId").value;
            try {
                if (typeof window.CMS?.updateInquiry === 'function') {
                    await window.CMS.updateInquiry({id, status: 'archived'});
                } else {
                    const db = window.getDbClient();
                    const {error} = await db.from('inquiries').update({status: 'archived'}).eq('id', id); 
                    if (error) throw error;
                }
                
                window.closeInquiryModal();
                await reloadAndPreserveScroll(loadInquiries, false, null);
                if (typeof loadArchivedInquiries === 'function') loadArchivedInquiries(true); 
                refreshUnreadBadge();
                showToast("Inquiry Archived.");
            } catch(e) { 
                showToast("Failed to archive inquiry.", "error"); 
            }
        });
    });

    window.unarchiveInquiry = async (id) => {
        window.customConfirm("Unarchive Inquiry", "Restore this inquiry to active status?", async () => {
            try {
                if (typeof window.CMS?.updateInquiry === 'function') {
                    await window.CMS.updateInquiry({id, status: 'new'});
                } else {
                    const db = window.getDbClient();
                    const {error} = await db.from('inquiries').update({status: 'new'}).eq('id', id);
                    if (error) throw error;
                }
                await reloadAndPreserveScroll(loadArchivedInquiries, false, null);
                if (typeof loadInquiries === 'function') loadInquiries(true);
                refreshUnreadBadge();
                showToast("Inquiry restored to active.");
            } catch(e) {
                showToast("Failed to unarchive.", "error");
            }
        });
    };

    window.deleteInquiry = async (id) => {
        window.customConfirm("Delete Permanently", "Are you sure you want to completely delete this inquiry? This cannot be undone.", async () => {
            try {
                const db = window.getDbClient();
                const {error} = await db.from('inquiries').delete().eq('id', id);
                if (error) throw error;
                
                await reloadAndPreserveScroll(loadInquiries, false, null);
                if(typeof loadArchivedInquiries === 'function') loadArchivedInquiries(true);
                refreshUnreadBadge();
                showToast("Inquiry deleted permanently.");
            } catch(e) {
                showToast("Failed to delete.", "error");
            }
        });
    };

    async function loadInquiries(force = false) {
        const el = document.getElementById("inquiryList");
        const search = document.getElementById("inquirySearch")?.value.toLowerCase() || "";
        
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;
        try {
            const getInq = typeof window.CMS?.getInquiries === 'function' ? window.CMS.getInquiries : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('inquiries').select('*').order('created_at',{ascending:false}); 
                return data; 
            };
            const all = await getInq(force) || [];
            let active = all.filter(i => (i.status || "new").toLowerCase() !== "archived");
            window.appState.inquiries = all; 
            
            if (search) active = active.filter(i => (i.full_name||'').toLowerCase().includes(search) || (i.email||'').toLowerCase().includes(search));
            if (!active.length) { el.innerHTML = `<p style="text-align:center; padding:4rem; color: var(--text-muted);"><i class="fas fa-check-circle" style="font-size:3rem; margin-bottom:1rem; display:block; color: #CBD5E1;"></i>All caught up! No active inquiries.</p>`; return; }
            
            el.innerHTML = active.map((i, index) => `
                <div class="item-row" data-id="${i.id}" style="animation-delay: ${index * 0.03}s; border-left-color: ${i.status === 'new' ? 'var(--danger)' : 'var(--warning)'};">
                    <div class="item-info">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                            <h4 style="margin:0;"><i class="fas fa-user-circle" style="color:var(--text-muted); margin-right: 6px;"></i> ${i.full_name || i.name || "Anonymous"}</h4>
                            <span class="badge ${i.status === 'new' ? 'danger' : 'warning'}">${(i.status || 'New').toUpperCase()}</span>
                        </div>
                        <p style="margin-bottom: 0.5rem;"><i class="fas fa-envelope"></i> ${i.email || "—"} &nbsp;|&nbsp; <i class="fas fa-phone"></i> ${i.phone || "—"}</p>
                        <p style="background:#F8FAFC; padding:10px; border-radius:4px; border-left: 2px solid #CBD5E1; font-style: italic; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">"${i.message ? i.message : ''}"</p>
                    </div>
                    <div class="actions">
                        <button class="btn-view" onclick="window.openInquiryModal('${i.id}')"><i class="fas fa-reply"></i> View</button>
                        <button class="btn-delete" onclick="window.deleteInquiry('${i.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load inquiries.</p>`; }
    }
    window.loadInquiries = loadInquiries;

    async function loadArchivedInquiries(force = false) {
        const el = document.getElementById("archivedInquiryList");
        if (!el) return;
        const search = document.getElementById("archivedInquirySearch")?.value.toLowerCase() || "";
        try {
            const getInq = typeof window.CMS?.getInquiries === 'function' ? window.CMS.getInquiries : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('inquiries').select('*').order('created_at',{ascending:false}); 
                return data; 
            };
            const all = await getInq(force) || [];
            let archived = all.filter(i => (i.status || "new").toLowerCase() === "archived");
            window.appState.inquiries = all; 
            
            if (search) archived = archived.filter(i => (i.full_name||'').toLowerCase().includes(search) || (i.email||'').toLowerCase().includes(search));
            if (!archived.length) { el.innerHTML = `<p style="text-align:center; padding:3rem; color: var(--text-muted);">No archived inquiries.</p>`; return; }
            
            el.innerHTML = archived.map((i, index) => `
                <div class="item-row" data-id="${i.id}" style="opacity:0.85; border-left-color: var(--success); animation-delay: ${index * 0.03}s;">
                    <div class="item-info">
                        <h4><i class="fas fa-archive" style="color:var(--success); margin-right: 6px;"></i> ${i.full_name || "Anonymous"}</h4>
                        <p><i class="fas fa-envelope"></i> ${i.email || "—"}</p>
                    </div>
                    <div class="actions">
                        <button class="btn-view" onclick="window.unarchiveInquiry('${i.id}')" style="color: var(--success); border-color: #A7F3D0;"><i class="fas fa-box-open"></i> Unarchive</button>
                        <button class="btn-delete" onclick="window.deleteInquiry('${i.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="color:var(--danger)">Failed to load archived inquiries.</p>`; }
    }
    window.loadArchivedInquiries = loadArchivedInquiries;

    // ================================================
    // CRUD Logic: FEATURED PROJECTS (Current Projects)
    // ================================================
    window.openCurrentProjectModal = async (id = null) => {
        showModal("currentProjectModal");
        document.getElementById("currentProjectModalTitle").textContent = id ? "Edit Flagship Project" : "New Flagship Project";
        document.getElementById("currentProjectForm").reset();
        document.getElementById("cpHtmlFile").value = "";
        
        if (imgManagers.currentProject) imgManagers.currentProject.setExisting(null);
        document.getElementById("cpId").value = id || "";

        const htmlLink = document.getElementById("cpHtmlLink");
        htmlLink.style.display = "none";

        if (id) {
            const item = window.appState.currentProjects.find(p => p.id == id);
            if(item) {
                document.getElementById("cpTitle").value = item.title || "";
                document.getElementById("cpLocation").value = item.location || "";
                document.getElementById("cpDescription").value = item.description || "";
                document.getElementById("cpDetailPage").value = item.detail_page || "";
                document.getElementById("cpIsFeatured").checked = item.is_featured !== false;
                document.getElementById("cpSortOrder").value = item.sort_order ?? 10;
                
                if (item.detail_page) {
                    htmlLink.innerHTML = `Template: <a href="${item.detail_page}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                    htmlLink.style.display = "block";
                }

                if (imgManagers.currentProject) imgManagers.currentProject.setExisting(window.safeParseImages(item.image)[0]);
            } else {
                try {
                    const fn = typeof window.CMS?.getCurrentProjectById === 'function' ? window.CMS.getCurrentProjectById : async (i) => { 
                        const db = window.getDbClient();
                        if(!db) return null;
                        const {data} = await db.from('current_projects').select('*').eq('id',i).single(); 
                        return data; 
                    };
                    const fetchedItem = await fn(id);
                    if (fetchedItem) {
                        document.getElementById("cpTitle").value = fetchedItem.title || "";
                        document.getElementById("cpLocation").value = fetchedItem.location || "";
                        document.getElementById("cpDescription").value = fetchedItem.description || "";
                        document.getElementById("cpDetailPage").value = fetchedItem.detail_page || "";
                        document.getElementById("cpIsFeatured").checked = fetchedItem.is_featured !== false;
                        document.getElementById("cpSortOrder").value = fetchedItem.sort_order ?? 10;
                        
                        if (fetchedItem.detail_page) {
                            htmlLink.innerHTML = `Template: <a href="${fetchedItem.detail_page}" target="_blank" style="color:var(--info);">View Current Link</a>`;
                            htmlLink.style.display = "block";
                        }

                        if (imgManagers.currentProject) imgManagers.currentProject.setExisting(window.safeParseImages(fetchedItem.image)[0]);
                    }
                } catch (err) {}
            }
        }

        document.getElementById("currentProjectForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("currentProjectForm")) return;

            const btn = document.getElementById("saveCurrentProjectBtn");
            btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("cpId").value;
            const editId = document.getElementById("cpId").value;
            const db = window.getDbClient();

            try {
                const uid = await getAuthUserId();
                const payloadInfo = imgManagers.currentProject.getFinalPayload();
                let finalUrl = payloadInfo.existingUrl;

                let detailPageUrl = document.getElementById("cpDetailPage").value.trim() || null;
                const htmlFileInput = document.getElementById("cpHtmlFile");
                if (htmlFileInput.files.length > 0) {
                    if (db) {
                        const file = htmlFileInput.files[0];
                        const fileExt = file.name.split('.').pop();
                        const fileName = `template_flagship_${Math.random().toString(36).substring(2)}.${fileExt}`;
                        const { data: uploadData, error: htmlUploadErr } = await db.storage.from('projects').upload(fileName, file);
                        if (!htmlUploadErr && uploadData) {
                            const { data: publicUrlData } = db.storage.from('projects').getPublicUrl(fileName);
                            if (publicUrlData) detailPageUrl = publicUrlData.publicUrl;
                        } else {
                            throw new Error("HTML Template upload failed.");
                        }
                    }
                }

                if (payloadInfo.newFile) {
                    try {
                        const uploadFn = typeof window.CMS?.uploadImages === 'function' ? window.CMS.uploadImages : null;
                        if(uploadFn) {
                            const uploadedUrls = await uploadFn([payloadInfo.newFile], 'featured');
                            if (uploadedUrls && uploadedUrls.length > 0) finalUrl = uploadedUrls[0];
                        } else {
                            if(db) {
                                const fileExt = payloadInfo.newFile.name.split('.').pop();
                                const fileName = `${Math.random()}.${fileExt}`;
                                const { data: uploadData, error: uploadError } = await db.storage.from('featured').upload(fileName, payloadInfo.newFile);
                                if (!uploadError && uploadData) {
                                    const { data: publicUrlData } = db.storage.from('featured').getPublicUrl(fileName);
                                    if(publicUrlData) finalUrl = publicUrlData.publicUrl;
                                }
                            }
                        }
                    } catch (uploadErr) {
                        showToast("Cover image upload failed.", "error");
                        throw new Error("Upload failed");
                    }
                }

                const sortOrderInput = parseInt(document.getElementById("cpSortOrder").value);

                const data = {
                    title: document.getElementById("cpTitle").value.trim(),
                    location: document.getElementById("cpLocation").value.trim(),
                    description: document.getElementById("cpDescription").value.trim(),
                    image: finalUrl,
                    detail_page: detailPageUrl,
                    is_featured: document.getElementById("cpIsFeatured").checked,
                    sort_order: !isNaN(sortOrderInput) ? sortOrderInput : 10,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.saveCurrentProject === 'function') {
                    const res = await window.CMS.saveCurrentProject(data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    if (!db) throw new Error("Database client not available");
                    const { data: savedData, error } = await db.from('current_projects').upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }
                
                window.closeCurrentProjectModal(); 
                await reloadAndPreserveScroll(loadCurrentProjects, isEdit, newlySavedId || null);
                showToast("Flagship Project Saved!");
            } catch (err) { 
                showToast("Error saving record.", "error"); 
            } finally { 
                btn.disabled = false; 
                btn.innerHTML = '<i class="fas fa-save"></i> Save Record'; 
            }
        };
    };

    window.deleteCurrentProject = async (id) => {
        window.customConfirm("Delete Flagship", "Delete this flagship project permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("current_projects", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("current_projects").delete().eq('id', id);
                    if (error) throw error;
                }
                await reloadAndPreserveScroll(loadCurrentProjects, false, null); 
                showToast("Deleted."); 
            } catch (err) {
                showToast("Failed to delete.", "error");
            }
        });
    };

    async function loadCurrentProjects(force = false) {
        const el = document.getElementById("currentProjectList");
        if (!el) return;
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;
        try {
            const fn = typeof window.CMS?.getCurrentProjects === 'function' ? window.CMS.getCurrentProjects : async () => { 
                const db = window.getDbClient();
                if (!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('current_projects').select('*').order('sort_order',{ascending:true}); 
                return data; 
            };
            const projects = await fn(force) || [];
            window.appState.currentProjects = projects;

            if (!projects.length) { el.innerHTML = `<p style="text-align:center; color: var(--text-muted); padding:3rem;">No flagship projects found.</p>`; return; }
            el.innerHTML = projects.map((p, index) => `
                <div class="item-row" data-id="${p.id}" style="${p.is_featured === false ? 'opacity: 0.6;' : ''} border-left-color: ${p.is_featured ? 'var(--brand-gold)' : 'var(--text-muted)'}; animation-delay: ${index * 0.03}s;">
                    <div class="list-item-content">
                        ${window.safeParseImages(p.image)?.[0] ? `<img loading="lazy" src="${window.safeParseImages(p.image)[0]}" class="list-thumbnail" onclick="openLightbox(this.src)">` : `<div class="empty-thumbnail"><i class="fas fa-star"></i></div>`}
                        <div class="item-info">
                            <h4>${p.title || "Untitled"} ${p.is_featured ? '<span class="badge success" style="margin-left:8px;">Active</span>' : '<span class="badge danger" style="margin-left:8px;">Hidden</span>'}</h4>
                            <p>
                                <i class="fas fa-map-marker-alt"></i> ${p.location || "—"}
                                ${p.detail_page ? `<span style="margin-left: 1rem;"><a href="${p.detail_page}" target="_blank" style="color:var(--info);"><i class="fas fa-external-link-alt"></i></a></span>` : ''}
                            </p>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openCurrentProjectModal('${p.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteCurrentProject('${p.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load featured projects.</p>`; }
    }
    window.loadCurrentProjects = loadCurrentProjects;

    // ================================================
    // CRUD Logic: CAREERS (Job Openings)
    // ================================================
    window.openCareerModal = async (id = null) => {
        showModal("careerModal");
        document.getElementById("careerModalTitle").textContent = id ? "Edit Position" : "New Position";
        document.getElementById("careerForm").reset();
        document.getElementById("careerId").value = id || "";

        if (id) {
            const item = window.appState.careers.find(p => p.id == id);
            if(item) {
                document.getElementById("careerItemNumber").value = item.item_number !== null ? item.item_number : "";
                document.getElementById("careerTitle").value = item.position_title || "";
                document.getElementById("careerAvailable").value = item.is_available ? "true" : "false";
                document.getElementById("careerSortOrder").value = item.sort_order ?? 0;
            } else {
                try {
                    const fn = typeof window.CMS?.getJobOpeningById === 'function' ? window.CMS.getJobOpeningById : async (i) => { 
                        const db = window.getDbClient();
                        if(!db) return null;
                        const {data} = await db.from('job_openings').select('*').eq('id',i).single(); 
                        return data; 
                    };
                    const fetchedItem = await fn(id);
                    if (fetchedItem) {
                        document.getElementById("careerItemNumber").value = fetchedItem.item_number !== null ? fetchedItem.item_number : "";
                        document.getElementById("careerTitle").value = fetchedItem.position_title || "";
                        document.getElementById("careerAvailable").value = fetchedItem.is_available ? "true" : "false";
                        document.getElementById("careerSortOrder").value = fetchedItem.sort_order ?? 0;
                    }
                } catch (err) {}
            }
        }

        document.getElementById("careerForm").onsubmit = async (e) => {
            e.preventDefault();
            if(!validateRequiredFields("careerForm")) return;

            const btn = document.getElementById("saveCareerBtn");
            btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            const isEdit = !!document.getElementById("careerId").value;
            const editId = document.getElementById("careerId").value;

            try {
                const uid = await getAuthUserId();
                const itemNumInput = parseInt(document.getElementById("careerItemNumber").value);
                const sortOrderInput = parseInt(document.getElementById("careerSortOrder").value);

                const data = {
                    item_number: !isNaN(itemNumInput) ? itemNumInput : null,
                    position_title: document.getElementById("careerTitle").value.trim(),
                    is_available: document.getElementById("careerAvailable").value === "true",
                    sort_order: !isNaN(sortOrderInput) ? sortOrderInput : 0,
                    created_by: uid
                };
                
                if (editId) data.id = editId;
                let newlySavedId = editId;

                if (typeof window.CMS?.saveJobOpening === 'function') {
                    const res = await window.CMS.saveJobOpening(data);
                    if (res && res.id) newlySavedId = res.id;
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { data: savedData, error } = await db.from('job_openings').upsert(data).select();
                    if (error) throw error;
                    if (savedData && savedData[0]) newlySavedId = savedData[0].id;
                }
                
                window.closeCareerModal(); 
                await reloadAndPreserveScroll(loadCareers, isEdit, newlySavedId || null);
                showToast("Position saved!");
            } catch (err) { 
                showToast("Error saving.", "error"); 
            } finally { 
                btn.disabled = false; 
                btn.innerHTML = '<i class="fas fa-save"></i> Save Position'; 
            }
        };
    };

    window.deleteCareer = async (id) => {
        window.customConfirm("Delete Job", "Delete this job position permanently?", async () => {
            try { 
                if (typeof window.CMS?.deleteItem === 'function') {
                    await window.CMS.deleteItem("job_openings", id);
                } else {
                    const db = window.getDbClient();
                    if (!db) throw new Error("Database client not found");
                    const { error } = await db.from("job_openings").delete().eq('id', id);
                    if (error) throw error;
                }
                await reloadAndPreserveScroll(loadCareers, false, null); 
                showToast("Position Deleted."); 
            } catch (err) {
                showToast("Failed to delete.", "error");
            }
        });
    };

    async function loadCareers(force = false) {
        const el = document.getElementById("careerList");
        if (!el) return;
        if(!document.querySelector('.highlight-item')) el.innerHTML = `<div class="loading-spinner"><i class="fa-solid fa-spinner fa-spin"></i><p>Loading...</p></div>`;
        try {
            const fn = typeof window.CMS?.getJobOpenings === 'function' ? window.CMS.getJobOpenings : async () => { 
                const db = window.getDbClient();
                if(!db) throw new Error("Database Client Not Initialized");
                const {data} = await db.from('job_openings').select('*').order('sort_order',{ascending:true}); 
                return data; 
            };
            const positions = await fn(force) || [];
            window.appState.careers = positions;

            if (!positions.length) { el.innerHTML = `<p style="text-align:center; padding:3rem; color:var(--text-muted);">No openings found.</p>`; return; }
            el.innerHTML = positions.map((p, index) => `
                <div class="item-row" data-id="${p.id}" style="${!p.is_available ? 'opacity:0.6;' : ''} border-left-color: ${p.is_available ? 'var(--success)' : 'var(--text-muted)'}; animation-delay: ${index * 0.03}s;">
                    <div class="item-info">
                        <h4><i class="fas fa-briefcase" style="color:var(--text-muted); margin-right:0.5rem;"></i> ${p.item_number ? p.item_number + ". " : ""}${p.position_title || "Untitled"}</h4>
                        <p style="color: ${p.is_available ? 'var(--success)' : 'var(--danger)'}; font-weight:600; margin-top:0.2rem;">${p.is_available ? "Active / Open" : "Closed"}</p>
                    </div>
                    <div class="actions">
                        <button class="btn-edit" onclick="window.openCareerModal('${p.id}')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn-delete" onclick="window.deleteCareer('${p.id}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `).join("");
        } catch (err) { el.innerHTML = `<p style="text-align:center; color:var(--danger); padding:3rem;">Failed to load careers.</p>`; }
    }
    window.loadCareers = loadCareers;

    // ================================================
    // DASHBOARD STATS & UNREAD BADGES
    // ================================================
    async function loadDashboardStats() {
        try {
            const getProjects = typeof window.CMS?.getProjects === 'function' ? window.CMS.getProjects : async () => {
                const db = window.getDbClient();
                if(!db) return [];
                const {data} = await db.from('projects').select('*');
                return data || [];
            };
            const projects = await getProjects() || [];
            
            if (document.getElementById('totalProjects')) document.getElementById('totalProjects').textContent = projects.length;
            if (document.getElementById('ongoingProjects')) document.getElementById('ongoingProjects').textContent = projects.filter(p => (p.status || '').toLowerCase() === 'ongoing').length;
            if (document.getElementById('upcomingProjects')) document.getElementById('upcomingProjects').textContent = projects.filter(p => (p.status || '').toLowerCase() === 'upcoming').length;

            const getAwards = typeof window.CMS?.getAwards === 'function' ? window.CMS.getAwards : async () => {
                const db = window.getDbClient();
                if(!db) return [];
                const {data} = await db.from('awards').select('*');
                return data || [];
            };
            const awards = await getAwards() || [];
            if (document.getElementById('totalAwards')) document.getElementById('totalAwards').textContent = awards.length;
        } catch (err) { console.error("Failed to load dashboard stats", err); }
    }

    async function refreshUnreadBadge() {
        try {
            const getInq = typeof window.CMS?.getInquiries === 'function' ? window.CMS.getInquiries : async () => { 
                const db = window.getDbClient();
                if(!db) return [];
                const {data} = await db.from('inquiries').select('id, status'); 
                return data; 
            };
            const inquiries = await getInq() || [];
            const unreadCount = inquiries.filter(i => (i.status || 'new').toLowerCase() === 'new').length;
            
            const badgeId = 'unreadInquiriesBadge';
            let badge = document.getElementById(badgeId);
            const menuLink = document.querySelector('.sidebar-menu a[data-page="inquiries"]');
            
            if (unreadCount > 0) {
                if (!badge && menuLink) {
                    badge = document.createElement('span');
                    badge.id = badgeId;
                    badge.style.cssText = 'background: var(--danger); color: white; border-radius: 12px; padding: 2px 8px; font-size: 0.75rem; margin-left: auto; font-weight: bold; line-height: 1;';
                    menuLink.appendChild(badge);
                }
                if (badge) badge.textContent = unreadCount;
            } else if (badge) { badge.remove(); }
        } catch (err) {}
    }

    // ================================================
    // PAGE SWITCHING ROUTER
    // ================================================
    async function switchPage(page, targetId = null) {
        saveScrollPosition();

        document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
        document.querySelectorAll(".sidebar-menu a").forEach(a => a.classList.remove("active"));

        const target = document.getElementById(`page-${page}`);
        const menuItem = document.querySelector(`.sidebar-menu a[data-page="${page}"]`);
        
        if (target) target.classList.add("active");
        if (menuItem) menuItem.classList.add("active");

        const isNewModule = state.currentModule !== page;
        state.currentModule = page;

        // Contextual FAB Button Switching
        const globalFab = document.getElementById("globalFab");
        const fabActions = {
            "projects": () => window.openProjectModalAction(),
            "awards": () => window.openAwardModal(),
            "news": () => window.openNewsModal(),
            "press": () => window.openPressModal(),
            "culture": () => window.openCultureModal(),
            "current-projects": () => window.openCurrentProjectModal(),
            "careers": () => window.openCareerModal()
        };

        if (fabActions[page] && globalFab) {
            globalFab.style.display = "flex";
            globalFab.onclick = fabActions[page];
        } else if (globalFab) {
            globalFab.style.display = "none";
        }

        const loaders = {
            "dashboard": () => loadDashboardStats(),
            "projects": () => loadProjects(false),
            "awards": () => loadAwards(false),
            "news": () => loadNews(false),
            "press": () => loadPress(false),
            "culture": () => loadCulture(false),
            "certifications": () => CertificationManager.init(),
            "inquiries": () => loadInquiries(false),
            "archived-inquiries": () => loadArchivedInquiries(false),
            "current-projects": () => loadCurrentProjects(false),
            "careers": () => loadCareers(false)
        };

        if (loaders[page]) await loaders[page](); 

        if (targetId) {
            restoreScrollPosition(targetId);
        } else if (isNewModule) {
            window.scrollTo({ top: 0, behavior: 'instant' });
        } else {
            restoreScrollPosition();
        }

        refreshUnreadBadge();
        if (window.innerWidth <= 1024) {
            const sb = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if(sb) sb.classList.remove('open');
            if(overlay) overlay.classList.remove('show');
        }
    }

    // ================================================
    // INITIALIZATION & EVENT LISTENERS
    // ================================================
    document.addEventListener("DOMContentLoaded", () => {
        try {
            const dateDisplay = document.getElementById('currentDateDisplay');
            if (dateDisplay) {
                dateDisplay.textContent = "System is fully operational and securely connected.";
            }

            const bannerDay = document.getElementById('bannerDay');
            const bannerMonthYear = document.getElementById('bannerMonthYear');
            if(bannerDay && bannerMonthYear) {
                const now = new Date();
                bannerDay.textContent = now.getDate();
                bannerMonthYear.textContent = now.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }

            if (typeof window.CMS !== 'undefined' && typeof window.CMS.isAuthenticated === 'function' && !window.CMS.isAuthenticated()) {
                window.location.href = "login.html";
                return;
            } else if (typeof window.CMS !== 'undefined' && window.CMS.getCurrentUser) {
                const user = window.CMS.getCurrentUser();
                if (user && user.role !== "admin") {
                    if(document.getElementById("mainContent")) document.getElementById("mainContent").style.display = "none";
                    if(document.getElementById("accessDenied")) document.getElementById("accessDenied").style.display = "block";
                    return;
                }
            }

            imgManagers.projects = new ImageManager("projectDragArea", "pImgFile", "projectPreviewContainer");
            imgManagers.culture = new ImageManager("cultureDragArea", "cImgFile", "culturePreviewContainer");
            imgManagers.awards = new ImageManager("awardDragArea", "aImgFile", "awardPreviewContainer");
            imgManagers.news = new ImageManager("newsDragArea", "nImgFile", "newsPreviewContainer");
            imgManagers.press = new SingleImageManager("pressDragArea", "pressImgFile", "pressPreviewContainer");
            imgManagers.currentProject = new SingleImageManager("cpDragArea", "cpImageInput", "cpPreviewContainer");

            document.querySelectorAll(".sidebar-menu a").forEach(link => {
                link.onclick = e => { e.preventDefault(); switchPage(link.dataset.page); };
            });

            const bindClick = (id, fn) => document.getElementById(id)?.addEventListener('click', fn);
            
            bindClick('btnNewProject', () => window.openProjectModalAction());
            bindClick('btnNewAward', () => window.openAwardModal());
            bindClick('btnNewNews', () => window.openNewsModal());
            bindClick('btnNewCulture', () => window.openCultureModal());
            
            bindClick('btnAddProjectPage', () => window.openProjectModalAction());
            bindClick('btnAddAwardPage', () => window.openAwardModal());
            bindClick('btnAddNewsPage', () => window.openNewsModal());
            bindClick('btnAddPressPage', () => window.openPressModal());
            bindClick('btnAddCulturePage', () => window.openCultureModal());
            bindClick('btnAddCurrentProjectPage', () => window.openCurrentProjectModal());
            bindClick('btnAddCareerPage', () => window.openCareerModal());

            // Add Logout Event Listeners
            document.getElementById('logoutButton')?.addEventListener('click', async () => {
                window.customConfirm("Sign Out", "Are you sure you want to log out of the Admin Portal?", async () => {
                    const db = window.getDbClient();
                    if (db && db.auth) await db.auth.signOut();
                    window.location.href = 'login.html';
                });
            });

            document.getElementById('accessDeniedLogout')?.addEventListener('click', async () => {
                 const db = window.getDbClient();
                 if (db && db.auth) await db.auth.signOut();
                 window.location.href = 'login.html';
            });

            // Mobile menu event listeners
            document.getElementById('sidebarToggle')?.addEventListener('click', () => { 
                document.getElementById('sidebar').classList.add('open');
                document.getElementById('sidebarOverlay')?.classList.add('show');
            });

            document.getElementById('sidebarOverlay')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            });

            document.getElementById('mobileSidebarClose')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            });

            document.querySelectorAll(".modal").forEach(modal => {
                modal.addEventListener('click', e => { if (e.target === modal) hideModal(modal.id); });
            });
            
            document.getElementById("lightboxModal")?.addEventListener('click', (e) => {
                if(e.target.id === 'lightboxModal') closeLightbox();
            });

            if (typeof window.CMS !== 'undefined' && typeof window.CMS.subscribeToInquiries === 'function') {
              window.CMS.subscribeToInquiries(payload => {
                if (payload.eventType === 'INSERT' || payload.eventType === 'UPDATE') {
                  refreshUnreadBadge(); showToast("New inquiry received!", "info");
                }
              });
            }

            setTimeout(() => {
                loadDashboardStats();
                refreshUnreadBadge();
            }, 400);

            switchPage("dashboard");

        } catch (err) {
            console.error("[CRITICAL] Error in DOMContentLoaded:", err);
        }
    });
  </script>
@endsection

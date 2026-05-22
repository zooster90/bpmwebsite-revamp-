const fs = require('fs');

const file = 'c:\\Users\\built\\Downloads\\Design (3) (2)\\Design (2) (2)\\Design (8)\\Design\\track-records.html';
let content = fs.readFileSync(file, 'utf8');

content = content.replace(/<style>[\s\S]*?<\/style>/, `<style>
    :root {
        --white:        #ffffff;
        --off-white:    #f8f6f2;
        --champagne:    #f4eee0;
        --gold:         #c5a059;
        --gold-dark:    #a68546;
        --gold-light:   #dfc8a0;
        --gold-alpha:   rgba(197, 160, 89, 0.10);
        --navy:         #1a242f;
        --navy-mid:     #243040;
        --text-main:    #2d3748;
        --text-light:   #718096;
        --gray-100:     #f7f8fa;
        --gray-200:     #e2e5eb;
        --transition:   all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        --shadow-sm:    0 4px 12px rgba(0,0,0,0.03);
        --shadow-md:    0 10px 30px rgba(0,0,0,0.06);
        --shadow-lg:    0 24px 50px rgba(0,0,0,0.08);
        --shadow-gold:  0 16px 40px rgba(197,160,89,0.25);
        --radius-sm:    6px;
        --radius-md:    12px;
        --radius-lg:    20px;
    }

    body { 
        font-family: 'Barlow', sans-serif;
        background-color: var(--white); 
        color: var(--text-main); 
        overflow-x: hidden;
    }

    /* Film Grain Texture */
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: url('https://grainy-gradients.vercel.app/noise.svg');
        opacity: 0.04;
        pointer-events: none;
        z-index: 9999;
        mix-blend-mode: overlay;
    }

    /* Parallax Blueprint Background */
    .blueprint-bg {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: 
            linear-gradient(rgba(197, 160, 89, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(197, 160, 89, 0.03) 1px, transparent 1px);
        background-size: 100px 100px;
        pointer-events: none;
        z-index: -1;
        transform: translateZ(0);
    }
    
    .font-barlow-condensed { font-family: 'Barlow Condensed', sans-serif; }
    .font-barlow { font-family: 'Barlow', sans-serif; }

    /* Hero Section */
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
        background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
        opacity: 0.15;
        filter: grayscale(100%);
    }
    .main-header::after {
        content: ''; 
        position: absolute; 
        inset: 0;
        background: linear-gradient(to top, rgba(26, 36, 47, 0.95) 0%, rgba(26, 36, 47, 0.5) 50%, rgba(26, 36, 47, 0.1) 100%);
    }
    .main-header .hero-bottom-line {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--navy), var(--gold), var(--navy));
        z-index: 2;
    }

    .glass-stats {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(197, 160, 89, 0.15);
        border-radius: var(--radius-md);
        box-shadow: 0 30px 60px rgba(0,0,0,0.2);
    }

    /* Filter Bar */
    .filter-bar {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 8px;
        margin: -50px auto 60px;
        max-width: 1150px;
        position: relative;
        z-index: 30;
        border: 1px solid var(--gray-200);
        border-bottom: 4px solid var(--gold);
    }

    .custom-select {
        appearance: none;
        background: transparent;
        border: none;
        width: 100%;
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        color: var(--navy);
        padding: 12px 40px 12px 16px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23c5a059' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 14px;
        cursor: pointer;
        letter-spacing: 0.05em;
        outline: none;
        text-transform: uppercase;
    }

    .filter-search-input {
        width: 100%;
        background: transparent;
        outline: none;
        color: var(--navy);
        font-family: 'Barlow', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
    }
    .filter-search-input::placeholder { color: var(--text-light); }

    /* Clean Project Card Design Update */
    .project-card { 
        position: relative;
        height: 480px;
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--navy);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        will-change: transform;
        cursor: pointer;
        border: 1px solid var(--gray-200);
    }

    .project-image-container {
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .project-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.2, 0, 0.2, 1), opacity 0.5s ease;
        opacity: 0.9;
    }

    /* Information Overlay - Initially Hidden */
    .project-info-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, 
            rgba(26, 36, 47, 0.98) 0%, 
            rgba(26, 36, 47, 0.6) 50%, 
            transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        opacity: 0;
        transform: translateY(20px);
        transition: var(--transition);
        z-index: 10;
    }
    
    .project-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gold);
        transform: scaleX(0);
        transform-origin: center;
        transition: transform 0.4s ease;
        z-index: 20;
    }

    /* Show Info on Hover */
    .project-card:hover .project-info-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    .project-card:hover .project-image {
        transform: scale(1.1);
        opacity: 0.5;
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
        border-color: var(--gold);
    }
    .project-card:hover::after { transform: scaleX(1); }

    /* Project UI Elements */
    .category-tag {
        display: inline-block;
        background: var(--gold);
        color: var(--white);
        padding: 6px 14px;
        border-radius: var(--radius-sm);
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .project-title {
        color: var(--white);
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .project-meta {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .project-meta i { color: var(--gold); }

    .status-pill {
        margin-top: 15px;
        padding: 6px 14px;
        border-radius: var(--radius-sm);
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(5px);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .pill-completed { background: rgba(134, 239, 172, 0.15); color: #86efac; border: 1px solid rgba(134,239,172,0.3); }
    .pill-ongoing   { background: rgba(253, 224, 71, 0.15); color: #fde047; border: 1px solid rgba(253,224,71,0.3); }
    .pill-coming-soon { background: rgba(186, 230, 253, 0.15); color: #bae6fd; border: 1px solid rgba(186,230,253,0.3); }

    .year-badge {
        position: absolute;
        top: 25px;
        right: 25px;
        background: var(--white);
        color: var(--navy);
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        font-weight: 800;
        font-size: 1rem;
        box-shadow: var(--shadow-md);
        z-index: 20;
        font-family: 'Barlow Condensed', sans-serif;
        transition: 0.3s ease;
    }
    
    .project-card:hover .year-badge {
        transform: scale(0.9);
        background: var(--gold);
        color: white;
    }

    /* Animations */
    .fade-in-up { animation: fadeInUp 0.8s ease backwards; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #backToTop {
        position: fixed;
        bottom: 40px;
        right: 40px;
        width: 60px;
        height: 60px;
        background: var(--gold);
        color: var(--white);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        box-shadow: 0 15px 30px rgba(197, 160, 89, 0.4);
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
        z-index: 9999;
    }
    #backToTop.show { opacity: 1; visibility: visible; transform: scale(1); }
</style>`);

content = content.replace('<div id="nav-placeholder"></div>', '<div id="nav-placeholder"></div>\\n    <div class="blueprint-bg"></div>');
content = content.replace('<header class="main-header">', '<header class="main-header">\\n        <div class="hero-bottom-line"></div>');
content = content.replace(/font-oswald/g, 'font-barlow-condensed');
content = content.replace(/Oswald/g, 'Barlow Condensed');
content = content.replace(/family=Barlow Condensed/g, 'family=Barlow+Condensed');

fs.writeFileSync(file, content, 'utf8');
console.log('Successfully updated file.');

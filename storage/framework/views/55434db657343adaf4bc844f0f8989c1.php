<?php $__env->startSection('title', 'Contact Builtech | CIDB Grade G7 Contractor — Penang, Malaysia'); ?>
<?php $__env->startSection('description', 'Get in touch with Builtech Project Management Sdn. Bhd. — Malaysia\'s trusted CIDB Grade G7 contractor in Jelutong, Penang. Call +604-659 3399 or email contact@builtech.com.my for project inquiries.'); ?>

<?php $__env->startPush('meta'); ?>
<meta name="robots" content="index, follow">
<meta property="og:title" content="Contact Builtech | Grade G7 Contractor — Penang">
<meta property="og:description" content="Reach out to Builtech Project Management for construction inquiries. Office: 17H Lebuhraya Batu Lanchang, 11600 Jelutong, Penang.">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo e(url('/contact')); ?>">
<link rel="canonical" href="<?php echo e(url('/contact')); ?>">
<?php $logoUrl = asset('img/logo.png'); $siteUrl = url('/'); ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Builtech Project Management Sdn. Bhd.",
  "image": "<?php echo e($logoUrl); ?>",
  "url": "<?php echo e($siteUrl); ?>",
  "telephone": "+60-4-659-3399",
  "email": "contact@builtech.com.my",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "17H Lebuhraya Batu Lanchang",
    "addressLocality": "Jelutong",
    "addressRegion": "Penang",
    "postalCode": "11600",
    "addressCountry": "MY"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": 5.3919, "longitude": 100.3039 },
  "openingHours": "Mo-Fr 08:00-17:30",
  "priceRange": "$$$$",
  "description": "CIDB Grade G7 certified contractor established in 1996, delivering engineering excellence across Malaysia."
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── CONTACT HERO ── */
.contact-hero {
    position: relative; min-height: 58vh;
    background: var(--navy);
    display: flex; align-items: flex-end;
    overflow: hidden; padding: 160px 5% 80px;
}
.contact-hero::before {
    content: ''; position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000') center/cover;
    opacity: 0.12; filter: grayscale(100%);
    animation: heroZoom 22s alternate infinite ease-in-out;
}
.contact-hero::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(10,20,35,0.98) 0%, rgba(26,36,47,0.88) 100%);
}
@keyframes heroZoom { 0%{transform:scale(1)} 100%{transform:scale(1.06)} }

/* ── STAT OVERLAP ── */
.contact-stat-row {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 1.5rem; margin: -55px auto 0;
    max-width: 1320px; padding: 0 5%;
    position: relative; z-index: 30;
}
.stat-box {
    background: white; border-radius: 14px;
    padding: 1.8rem 2rem; text-align: center;
    box-shadow: 0 20px 50px rgba(10,25,47,0.12);
    border: 1px solid var(--border);
    transition: var(--transition);
}
.stat-box:hover { transform: translateY(-4px); border-color: var(--border-gold); }
.stat-box .val {
    font-family: 'Oswald', sans-serif;
    font-size: 2.5rem; font-weight: 700;
    color: var(--navy); line-height: 1; display: block;
}
.stat-box .val span { color: var(--gold); }
.stat-box .lbl {
    font-size: 0.7rem; font-weight: 800;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 0.2em; display: block; margin-top: 0.4rem;
}

/* ── INFO CARDS ── */
.info-card {
    background: white; border-radius: 14px;
    padding: 1.4rem 1.6rem;
    display: flex; align-items: center; gap: 1.2rem;
    border: 1px solid var(--border);
    transition: var(--transition);
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    margin-bottom: 0.9rem;
}
.info-card:last-of-type { margin-bottom: 0; }
.info-card:hover { border-color: var(--gold); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(10,25,47,0.1); }
.info-icon {
    width: 52px; height: 52px; border-radius: 12px;
    background: rgba(197,160,89,0.08);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 1.3rem; flex-shrink: 0;
    transition: var(--transition);
    border: 1px solid rgba(197,160,89,0.12);
}
.info-card:hover .info-icon { background: var(--gold); color: white; }
.info-label {
    font-size: 0.68rem; font-weight: 800;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 0.2em; display: block; margin-bottom: 3px;
}
.info-value { font-size: 0.97rem; font-weight: 700; color: var(--navy); margin: 0; }

/* ── HQ BOX ── */
.hq-box {
    background: linear-gradient(145deg, #1a242f 0%, #0f1a28 100%);
    border-radius: 14px; padding: 1.8rem 2rem; margin-top: 1rem;
    border: 1px solid rgba(197,160,89,0.2); position: relative; overflow: hidden;
}
.hq-box::before {
    content: ''; position: absolute; top:-40px; right:-40px;
    width:150px; height:150px;
    background: radial-gradient(circle, rgba(197,160,89,0.08), transparent 70%);
}
.hq-box h3 {
    font-family: 'Oswald', sans-serif; font-size: 1rem; font-weight: 700;
    color: var(--gold); margin-bottom: 0.75rem;
    text-transform: uppercase; letter-spacing: 0.08em;
}
.hq-box address { font-style: normal; font-size: 0.95rem; color: rgba(255,255,255,0.75); line-height: 1.9; }
.hours-badge {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 0.9rem; background: rgba(197,160,89,0.12);
    padding: 4px 12px; border-radius: 50px;
    font-size: 0.72rem; font-weight: 700; color: var(--gold);
    text-transform: uppercase; letter-spacing: 0.1em;
}

/* ── FORM CARD ── */
.form-card {
    background: white; border-radius: 18px;
    padding: 3.5rem; box-shadow: 0 20px 60px rgba(10,25,47,0.08);
    border: 1px solid var(--border);
}
.field-wrap { margin-bottom: 1.6rem; }
.field-wrap label {
    display: block; font-size: 0.72rem; font-weight: 800;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 0.2em; margin-bottom: 0.5rem;
}
.field-wrap input, .field-wrap textarea, .field-wrap select {
    width: 100%; padding: 1rem 1.1rem;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-family: 'Montserrat', sans-serif; font-size: 0.97rem;
    color: var(--navy); background: #fafafa;
    transition: all 0.3s; outline: none;
    -webkit-appearance: none;
}
.field-wrap input:focus, .field-wrap textarea:focus, .field-wrap select:focus {
    border-color: var(--gold); background: white;
    box-shadow: 0 0 0 4px rgba(197,160,89,0.12);
}
.field-wrap textarea { min-height: 130px; resize: vertical; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }

/* ── MAP ── */
.map-wrapper {
    border-radius: 18px; overflow: hidden;
    box-shadow: 0 20px 60px rgba(10,25,47,0.1);
    border: 1px solid var(--border);
    display: grid; grid-template-columns: 340px 1fr;
    background: white;
}
.map-sidebar {
    padding: 2.5rem 2rem;
    display: flex; flex-direction: column; gap: 1.5rem;
    border-right: 1px solid var(--border);
}
.map-sidebar h3 {
    font-family: 'Oswald', sans-serif; font-size: 1.4rem;
    font-weight: 700; color: var(--navy);
    text-transform: uppercase; margin-bottom: 0.3rem;
}
.nav-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 0.85rem 1.2rem; border-radius: 10px;
    font-weight: 800; font-size: 0.8rem;
    text-transform: uppercase; letter-spacing: 0.1em;
    text-decoration: none; transition: var(--transition);
}
.nav-btn-waze { background: #33ccff; color: #000; }
.nav-btn-waze:hover { background: #00b8e0; transform: translateY(-2px); }
.nav-btn-gmaps { background: #4285f4; color: white; }
.nav-btn-gmaps:hover { background: #2b6ad6; transform: translateY(-2px); }

@media (max-width: 1024px) {
    .contact-stat-row { grid-template-columns: 1fr; margin-top: 0; }
    .contact-main-grid { grid-template-columns: 1fr !important; }
    .map-wrapper { grid-template-columns: 1fr; }
    .field-row { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .form-card { padding: 2rem; }
    .map-sidebar { border-right: none; border-bottom: 1px solid var(--border); }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bt-wrapper">

    
    <header class="contact-hero">
        <div class="bt-container" style="position:relative; z-index:10;">
            <div class="reveal">
                <span class="section-label"><i class="fas fa-map-marker-alt" style="margin-right:8px;"></i>Jelutong, Penang — Malaysia</span>
                <h1 style="font-family:'Oswald',sans-serif; font-size:clamp(3rem,6vw,5.5rem); font-weight:700; color:white; text-transform:uppercase; line-height:1.05; margin-bottom:1rem;">
                    Get In <span style="color:var(--gold);">Touch.</span>
                </h1>
                <p style="font-size:1.05rem; color:rgba(255,255,255,0.7); max-width:540px; line-height:1.85; margin-bottom:2rem;">
                    Ready to discuss your project? Our engineering team responds within one business day. Reach us directly or use the form below.
                </p>
                <div style="display:flex; flex-wrap:wrap; gap:1rem;">
                    <a href="tel:+60465933399" class="btn-primary">
                        <i class="fas fa-phone-alt"></i> +604-659 3399
                    </a>
                    <a href="mailto:contact@builtech.com.my" class="btn-primary btn-outline-white">
                        <i class="fas fa-envelope"></i> contact@builtech.com.my
                    </a>
                </div>
            </div>
        </div>
    </header>

    
    <div class="contact-stat-row">
        <div class="stat-box reveal stagger-1">
            <span class="val"><span class="counter" data-target="24">0</span><span>hr</span></span>
            <span class="lbl">Response Guarantee</span>
        </div>
        <div class="stat-box reveal stagger-2">
            <span class="val">G<span class="counter" data-target="7">0</span></span>
            <span class="lbl">CIDB Grade Certified</span>
        </div>
        <div class="stat-box reveal stagger-3">
            <span class="val"><span class="counter" data-target="<?php echo e(date('Y') - 1996); ?>">0</span><span>+</span></span>
            <span class="lbl">Years of Excellence</span>
        </div>
    </div>

    
    <section style="background:var(--off-white); padding:80px 5% 100px;">
        <div class="bt-container">
            <div class="contact-main-grid" style="display:grid; grid-template-columns:1fr 1.8fr; gap:4rem; align-items:start;">

                
                <aside class="reveal">
                    <span class="section-label">Direct Channels</span>
                    <h2 style="font-family:'Oswald',sans-serif; font-size:1.8rem; font-weight:700; color:var(--navy); text-transform:uppercase; margin-bottom:1.8rem;">
                        Contact <span style="color:var(--gold);">Info</span>
                    </h2>

                    <a href="tel:+60465933399" class="info-card">
                        <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <span class="info-label">Main Office Line</span>
                            <p class="info-value">+604-659 3399</p>
                        </div>
                    </a>

                    <a href="mailto:contact@builtech.com.my" class="info-card">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <span class="info-label">General Enquiries</span>
                            <p class="info-value">contact@builtech.com.my</p>
                        </div>
                    </a>

                    <a href="mailto:hr@builtech.com.my" class="info-card">
                        <div class="info-icon"><i class="fas fa-users"></i></div>
                        <div>
                            <span class="info-label">HR &amp; Recruitment</span>
                            <p class="info-value">hr@builtech.com.my</p>
                        </div>
                    </a>

                    <div class="hq-box">
                        <h3><i class="fas fa-building" style="margin-right:8px;"></i>Regional Headquarters</h3>
                        <address>
                            17H, Level 1 &ndash; Level 3,<br>
                            Lebuhraya Batu Lanchang,<br>
                            <strong style="color:white;">11600 Jelutong, Penang, Malaysia.</strong>
                        </address>
                        <div class="hours-badge">
                            <i class="fas fa-clock"></i> Mon &ndash; Fri: 8:30am &ndash; 6:00pm
                        </div>
                    </div>
                </aside>

                
                <section class="form-card reveal" aria-label="Project Inquiry Form">
                    <span class="section-label">Send a Message</span>
                    <h2 style="font-family:'Oswald',sans-serif; font-size:2rem; font-weight:700; color:var(--navy); text-transform:uppercase; margin-bottom:0.5rem;">
                        Project <span style="color:var(--gold);">Inquiry</span>
                    </h2>
                    <p style="font-size:0.97rem; color:var(--text-muted); margin-bottom:2.5rem; line-height:1.75;">
                        Tell us about your project and we will respond within one business day.
                    </p>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                        <div style="background:rgba(56,161,105,0.1); border:1px solid rgba(56,161,105,0.3); border-radius:10px; padding:1.2rem 1.5rem; margin-bottom:2rem; display:flex; align-items:center; gap:12px;" role="alert">
                            <i class="fas fa-check-circle" style="color:#38a169; font-size:1.4rem;"></i>
                            <p style="color:#276749; font-weight:700; margin:0;"><?php echo e(session('success')); ?></p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                        <div style="background:rgba(220,38,38,0.07); border:1px solid rgba(220,38,38,0.2); border-radius:10px; padding:1.2rem 1.5rem; margin-bottom:2rem;" role="alert">
                            <p style="color:#dc2626; font-weight:700; margin:0 0 0.5rem;"><i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>Please correct the following:</p>
                            <ul style="margin:0; padding-left:1.2rem; color:#dc2626; font-size:0.88rem;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><li><?php echo e($error); ?></li><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form action="<?php echo e(route('contact.store')); ?>" method="POST" novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="field-row">
                            <div class="field-wrap">
                                <label for="full_name">Full Name <span style="color:#e53e3e;">*</span></label>
                                <input type="text" id="full_name" name="full_name" placeholder="e.g. Ahmad bin Ali" required value="<?php echo e(old('full_name')); ?>" autocomplete="name">
                            </div>
                            <div class="field-wrap">
                                <label for="company">Company / Organisation</label>
                                <input type="text" id="company" name="company" placeholder="Your company name" value="<?php echo e(old('company')); ?>" autocomplete="organization">
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-wrap">
                                <label for="email">Email Address <span style="color:#e53e3e;">*</span></label>
                                <input type="email" id="email" name="email" placeholder="you@company.com" required value="<?php echo e(old('email')); ?>" autocomplete="email">
                            </div>
                            <div class="field-wrap">
                                <label for="phone">Phone Number <span style="color:#e53e3e;">*</span></label>
                                <input type="tel" id="phone" name="phone" placeholder="+60 12-345 6789" required value="<?php echo e(old('phone')); ?>" autocomplete="tel">
                            </div>
                        </div>
                        <div class="field-wrap">
                            <label for="service_type">Type of Inquiry</label>
                            <select id="service_type" name="service_type">
                                <option value="">— Select a service type —</option>
                                <option value="project_management" <?php echo e(old('service_type')=='project_management'?'selected':''); ?>>Project Management</option>
                                <option value="building_civil" <?php echo e(old('service_type')=='building_civil'?'selected':''); ?>>Building &amp; Civil Works</option>
                                <option value="industrial" <?php echo e(old('service_type')=='industrial'?'selected':''); ?>>Industrial Building</option>
                                <option value="maintenance" <?php echo e(old('service_type')=='maintenance'?'selected':''); ?>>Maintenance Services</option>
                                <option value="property" <?php echo e(old('service_type')=='property'?'selected':''); ?>>Property Development</option>
                                <option value="safety_training" <?php echo e(old('service_type')=='safety_training'?'selected':''); ?>>Safety &amp; Health Training</option>
                                <option value="general" <?php echo e(old('service_type')=='general'?'selected':''); ?>>General Inquiry</option>
                            </select>
                        </div>
                        <div class="field-wrap">
                            <label for="message">Project Description <span style="color:#e53e3e;">*</span></label>
                            <textarea id="message" name="message" placeholder="Briefly describe your project: location, scale, scope, and timeline..." required><?php echo e(old('message')); ?></textarea>
                        </div>
                        <button type="submit" class="btn-primary btn-attention" style="width:100%; justify-content:center; padding:1.2rem; font-size:0.95rem;">
                            <i class="fas fa-paper-plane"></i> Send Inquiry
                        </button>
                        <p style="font-size:0.78rem; color:var(--text-muted); text-align:center; margin-top:1rem;">
                            <i class="fas fa-lock" style="color:var(--gold); margin-right:4px;"></i>
                            Your information is kept strictly confidential and never shared with third parties.
                        </p>
                    </form>
                </section>
            </div>

            
            <div class="map-wrapper reveal" style="margin-top:5rem;">
                <div class="map-sidebar">
                    <div>
                        <span class="section-label">Find Us</span>
                        <h3>Our Location</h3>
                        <address style="font-style:normal; font-size:0.95rem; color:var(--text-body); line-height:2;">
                            <strong style="color:var(--navy);">Builtech Project Management Sdn. Bhd.</strong><br>
                            17H, Level 1 &ndash; Level 3,<br>
                            Lebuhraya Batu Lanchang,<br>
                            11600 Jelutong, Penang, Malaysia.
                        </address>
                    </div>

                    <div style="border-top:1px solid var(--border); padding-top:1.5rem;">
                        <p style="font-size:0.72rem; font-weight:800; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.2em; margin-bottom:0.8rem;">Office Hours</p>
                        <div style="display:flex; justify-content:space-between; font-size:0.93rem; margin-bottom:0.4rem;">
                            <span style="color:var(--navy); font-weight:600;">Monday – Friday</span>
                            <span style="color:var(--gold); font-weight:700;">8:30am – 6:00pm</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.93rem;">
                            <span style="color:var(--navy); font-weight:600;">Saturday – Sunday</span>
                            <span style="color:var(--text-muted);">Closed</span>
                        </div>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:0.6rem;">
                        <a href="https://waze.com/ul?ll=5.39190,100.30330&navigate=yes" target="_blank" rel="noopener noreferrer" class="nav-btn nav-btn-waze">
                            <i class="fab fa-waze"></i> Open in Waze
                        </a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=Builtech+Project+Management+Sdn+Bhd&destination_place_id=ChIJ4TwXkQpDRjER4KkNQmb5wmM&travelmode=driving" target="_blank" rel="noopener noreferrer" class="nav-btn nav-btn-gmaps">
                            <i class="fab fa-google"></i> Get Directions
                        </a>
                    </div>

                    <div style="background:rgba(197,160,89,0.07); border:1px solid var(--border-gold); border-radius:10px; padding:1rem 1.2rem;">
                        <p style="font-size:0.83rem; color:var(--text-muted); margin:0; line-height:1.7;">
                            <i class="fas fa-circle-parking" style="color:var(--gold); margin-right:6px;"></i>
                            Parking available on-site. Look for the Builtech signage along Lebuhraya Batu Lanchang.
                        </p>
                    </div>
                </div>

                <div style="min-height:480px;">
                    
                    
                    <iframe
                        src="https://maps.google.com/maps?q=Builtech+Project+Management+Sdn+Bhd,+17H+Lebuhraya+Batu+Lanchang,+11600+Jelutong,+Penang,+Malaysia&t=&z=17&ie=UTF8&iwloc=&output=embed"
                        width="100%" height="100%"
                        style="border:0; display:block; min-height:480px;"
                        allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Builtech Project Management Sdn. Bhd. — 17H Lebuhraya Batu Lanchang, 11600 Jelutong, Penang, Malaysia">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/contact.blade.php ENDPATH**/ ?>
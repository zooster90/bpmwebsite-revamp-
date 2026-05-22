<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Maintenance | Builtech Strategic Bureau</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        :root {
            --navy: #1a242f;
            --gold: #c5a059;
            --stone: #fafaf9;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Barlow', sans-serif;
            background-color: var(--stone);
            background-image: 
                radial-gradient(circle at 80% 20%, rgba(197, 160, 89, 0.08), transparent 40%),
                radial-gradient(circle at 20% 80%, rgba(26, 36, 47, 0.04), transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            overflow: hidden;
        }

        .maintenance-container {
            position: relative;
            z-index: 10;
            max-width: 600px;
            width: 90%;
            margin: 0 auto;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(26, 36, 47, 0.05);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.04);
            border-radius: 2.5rem;
            padding: 4rem 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: cardFloat 6s ease-in-out infinite alternate;
        }

        @keyframes cardFloat {
            0% { transform: translateY(0); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.04); }
            100% { transform: translateY(-10px); box-shadow: 0 30px 70px rgba(197, 160, 89, 0.08); }
        }

        .icon-wrapper {
            width: 100px;
            height: 100px;
            background: rgba(197, 160, 89, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: var(--gold);
            position: relative;
        }

        .icon-wrapper .material-icons {
            font-size: 48px;
            animation: spinSlow 8s linear infinite;
        }

        .icon-wrapper::after {
            content: '';
            position: absolute;
            inset: -10px;
            border: 2px dashed rgba(197, 160, 89, 0.3);
            border-radius: 50%;
            animation: spinSlowReverse 12s linear infinite;
        }

        @keyframes spinSlow { 100% { transform: rotate(360deg); } }
        @keyframes spinSlowReverse { 100% { transform: rotate(-360deg); } }

        .brand-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(26, 36, 47, 0.05);
            border-radius: 2rem;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--navy);
            margin-bottom: 1.5rem;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin: 0 0 1.5rem 0;
            letter-spacing: -0.02em;
        }

        p {
            font-size: 1rem;
            line-height: 1.7;
            color: #57534e;
            margin: 0 0 2.5rem 0;
            font-weight: 500;
        }

        .contact-info {
            border-top: 1px solid rgba(26, 36, 47, 0.08);
            padding-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--navy);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-item:hover {
            color: var(--gold);
        }

        .contact-item .material-icons {
            font-size: 18px;
            color: var(--gold);
        }

        /* Decorative Background Elements */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 1;
        }
        .deco-1 {
            width: 400px; height: 400px;
            background: rgba(197, 160, 89, 0.15);
            top: -100px; right: -100px;
        }
        .deco-2 {
            width: 500px; height: 500px;
            background: rgba(26, 36, 47, 0.08);
            bottom: -150px; left: -150px;
        }
    </style>
</head>
<body>

    <div class="deco-circle deco-1"></div>
    <div class="deco-circle deco-2"></div>

    <div class="maintenance-container">
        <div class="glass-card">
            
            <div class="icon-wrapper">
                <span class="material-icons">engineering</span>
            </div>

            <div class="brand-badge">Builtech Strategic Bureau</div>
            
            <h1>System Maintenance <br> <span style="color: var(--gold);">in Progress.</span></h1>
            
            <p>Our engineering portal is currently undergoing scheduled infrastructure upgrades to enhance your experience. We expect our systems to be fully operational shortly. Thank you for your patience.</p>

            <div class="contact-info">
                <a href="tel:+60465933399" class="contact-item">
                    <span class="material-icons">phone</span>
                    +604-659 3399
                </a>
                <a href="mailto:contact@builtech.com.my" class="contact-item">
                    <span class="material-icons">email</span>
                    contact@builtech.com.my
                </a>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\Users\built\Herd\builtech-app\resources\views/maintenance.blade.php ENDPATH**/ ?>
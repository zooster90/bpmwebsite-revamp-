<?php
$content = file_get_contents('c:/Users/built/Downloads/Design (3) (2)/Design (2) (2)/Design (8)/Design/track-records.html');

// 1. Top Section
$topTarget = '<!doctype html>
<html lang="en" class="scroll-smooth antialiased">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Explore Builtech\'s verified portfolio of high-quality construction projects." />
    <title>Track Records | Builtech Project Management</title>

    <link rel="apple-touch-icon" href="images/logo.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="images/61da7874-55a9-46d1-b71c-32ddac2a7740.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script src="js/cms.js"></script>
    <link rel="stylesheet" href="navbar.css" />';

$topReplace = "@extends('layouts.app')\n@section('title', 'Track Records | Builtech Project Management')\n\n@push('styles')";
$content = str_replace($topTarget, $topReplace, $content);

// 2. Head to Body
$headTarget = '</head>

<body class="min-h-screen flex flex-col">

    <div id="nav-placeholder"></div>';
$headReplace = "@endpush\n\n@section('content')";
$content = str_replace($headTarget, $headReplace, $content);

// 3. JS Data Injection
$jsTarget = 'if (typeof CMS === \'undefined\') return;
                const raw = await CMS.getProjects(true);';
$jsReplace = 'const raw = @json(\App\Models\Project::all());';
$content = str_replace($jsTarget, $jsReplace, $content);

// 4. Remove Footer and Navbar.js script
$footerPos = strpos($content, '<footer class="footer-main"');
if ($footerPos !== false) {
    // Keep everything up to the footer
    $content = substr($content, 0, $footerPos);
    
    // Add the scripts that were after the footer manually
    $content .= '
    <button id="backToTop" onclick="window.scrollTo({top:0, behavior:\'smooth\'})">
        <i class="fas fa-chevron-up"></i>
    </button>
    ';
    
    // Wait, the javascript block is below the footer in the original file! 
    // I should extract the script block.
}

// Actually, safer approach for script:
// Read from original file
$original = file_get_contents('c:/Users/built/Downloads/Design (3) (2)/Design (2) (2)/Design (8)/Design/track-records.html');
$scriptStart = strpos($original, '<script>');
$scriptEnd = strpos($original, '</script>', $scriptStart);
if ($scriptStart !== false && $scriptEnd !== false) {
    $scriptBlock = substr($original, $scriptStart, $scriptEnd - $scriptStart + 9);
    
    // Modify script block
    $scriptBlock = str_replace('if (typeof CMS === \'undefined\') return;
                const raw = await CMS.getProjects(true);', 'const raw = @json(\App\Models\Project::all());', $scriptBlock);
    
    // Combine everything
    $finalContent = substr($content, 0, $footerPos) . "\n@push('scripts')\n" . $scriptBlock . "\n@endpush\n@endsection\n";
    file_put_contents('c:/Users/built/Herd/builtech-app/resources/views/projects.blade.php', $finalContent);
} else {
    echo "Script block not found!";
}

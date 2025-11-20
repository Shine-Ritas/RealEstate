<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="theme-color" content="#15131E">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- SEO Meta Tags -->
<meta name="description" content="{{ $seoDescription ?? 'Professional reseller platform for game packages and digital products. Buy and sell gaming items, top-up cards, and digital services with JTG Store.' }}">
<meta name="keywords" content="{{ $seoKeywords ?? 'game reseller, digital products, gaming packages, top-up cards, mobile gaming, online gaming, game items, digital marketplace, JTG store' }}">
<meta name="author" content="JTG Store">
<meta name="robots" content="{{ $robots ?? 'index, follow' }}">
<link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

<!-- Open Graph Meta Tags -->
<meta property="og:type" content="{{ $ogType ?? 'website' }}">
<meta property="og:title" content="{{ $ogTitle ?? ($title ?? 'JTG Store - Professional Gaming Platform') }}">
<meta property="og:description" content="{{ $ogDescription ?? ($seoDescription ?? 'Professional reseller platform for game packages and digital products. Buy and sell gaming items, top-up cards, and digital services with JTG Store.') }}">
<meta property="og:image" content="{{ $ogImage ?? asset('assets/app/icon-512x512.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $ogImageAlt ?? 'JTG Store Platform' }}">
<meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
<meta property="og:site_name" content="JTG Store">
<meta property="og:locale" content="{{ app()->getLocale() }}">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $twitterTitle ?? ($ogTitle ?? ($title ?? 'JTG Store - Professional Gaming Platform')) }}">
<meta name="twitter:description" content="{{ $twitterDescription ?? ($ogDescription ?? ($seoDescription ?? 'Professional reseller platform for game packages and digital products.')) }}">
<meta name="twitter:image" content="{{ $twitterImage ?? ($ogImage ?? asset('assets/app/icon-512x512.png')) }}">
<meta name="twitter:image:alt" content="{{ $twitterImageAlt ?? ($ogImageAlt ?? 'JTG Store Platform') }}">

<!-- Additional SEO Meta Tags -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="JTG Store">
<meta name="application-name" content="JTG Store">
<meta name="msapplication-TileColor" content="#15131E">
<meta name="msapplication-config" content="/browserconfig.xml">
<meta name="format-detection" content="telephone=no">

<!-- Language and Region -->
<meta name="language" content="{{ app()->getLocale() }}">
<meta name="geo.region" content="MM">
<meta name="geo.country" content="Myanmar">
<meta name="geo.placename" content="Yangon">

<!-- PWA Manifest -->
<link rel="manifest" crossorigin="use-credentials" href="/manifest.json">
<link rel="assetlinks" href="/public/.well-known/assetlinks.json">

<!-- Apple Touch Icons -->
<link rel="apple-touch-icon" href="/assets/app/icon-192x192-1.png">
<link rel="apple-touch-icon" sizes="72x72" href="/assets/app/icon-72x72-1.png">
<link rel="apple-touch-icon" sizes="96x96" href="/assets/app/icon-96x96-1.png">
<link rel="apple-touch-icon" sizes="128x128" href="/assets/app/icon-128x128-1.png">
<link rel="apple-touch-icon" sizes="144x144" href="/assets/app/icon-144x144-1.png">
<link rel="apple-touch-icon" sizes="192x192" href="/assets/app/icon-192x192-1.png">
<link rel="apple-touch-icon" sizes="512x512" href="/assets/app/icon-512x512-1.png">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="48x48" href="/assets/app/icon-48x48-1.png">
<link rel="icon" type="image/png" sizes="72x72" href="/assets/app/icon-72x72-1.png">
<link rel="icon" type="image/png" sizes="96x96" href="/assets/app/icon-96x96-1.png">
<link rel="icon" type="image/png" sizes="128x128" href="/assets/app/icon-128x128-1.png">
<link rel="icon" type="image/png" sizes="144x144" href="/assets/app/icon-144x144-1.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/app/icon-192x192-1.png">
<link rel="icon" type="image/png" sizes="512x512" href="/assets/app/icon-512x512-1.png">
<link rel="shortcut icon" href="/favicon.ico">

<title>{{ $title ?? 'Real estate' }}</title>
<!-- Performance Optimizations -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="dns-prefetch" href="https://fonts.bunny.net">
<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&family=barlow-condensed:400,500,600,700" rel="stylesheet" />
<link href="{{ asset('assets/css/daisy.min.css') }}" rel="stylesheet" type="text/css" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Chart.js CDN (global) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@fluxAppearance

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Acryluxe') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        :root {
            --gold: #c9a96e;
            --gold-light: #e8d5b0;
            --gold-dark: #8c6d3f;
            --ink: #1a1612;
            --cream: #faf7f2;
            --blush: #f2e8df;
            --warm-gray: #9c948a;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'DM Sans', sans-serif;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            font-family: var(--font-body);
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.35;
        }

        .page-shell {
            position: relative;
            z-index: 1;
        }

        .navbar-acryluxe {
            position: sticky;
            top: 0;
            z-index: 20;
            padding: 1.15rem 2rem;
            background: rgba(250, 247, 242, 0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(201, 169, 110, 0.15);
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .nav-logo {
            font-family: var(--font-display);
            font-size: 1.6rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink);
            text-decoration: none;
        }

        .nav-logo span {
            color: var(--gold);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links a,
        .nav-actions a {
            font-size: 0.74rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            text-decoration: none;
        }

        .nav-links a {
            color: var(--ink);
            opacity: 0.72;
        }

        .nav-links a:hover {
            opacity: 1;
        }

        .nav-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-nav,
        .btn-primary-gold,
        .btn-outline-ink,
        .btn-ghost,
        .product-action,
        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .btn-nav {
            padding: 0.55rem 1rem;
            border: 1px solid rgba(26, 22, 18, 0.16);
            color: var(--ink);
            background: transparent;
        }

        .cart-pill {
            display: inline-flex;
            min-width: 1.4rem;
            height: 1.4rem;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: var(--gold);
            color: var(--cream);
            font-size: 0.66rem;
            margin-left: 0.45rem;
            padding: 0 0.35rem;
        }

        .btn-nav:hover,
        .btn-primary-gold:hover,
        .btn-outline-ink:hover,
        .btn-ghost:hover,
        .product-action:hover,
        .cta-button:hover {
            transform: translateY(-1px);
        }

        .btn-primary-gold {
            padding: 0.95rem 1.6rem;
            background: var(--gold);
            color: var(--cream);
            border: 1px solid var(--gold);
        }

        .btn-primary-gold:hover {
            background: var(--gold-dark);
            border-color: var(--gold-dark);
            color: var(--cream);
        }

        .btn-outline-ink {
            padding: 0.95rem 1.6rem;
            color: var(--ink);
            border: 1px solid rgba(26, 22, 18, 0.2);
            background: transparent;
        }

        .hero {
            max-width: 1280px;
            margin: 0 auto;
            padding: 5rem 2rem 2.5rem;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 2rem;
            align-items: stretch;
        }

        .hero-panel,
        .catalog-panel,
        .cta-panel,
        .footer-panel {
            border: 1px solid rgba(201, 169, 110, 0.18);
            background: rgba(250, 247, 242, 0.82);
            box-shadow: 0 20px 60px rgba(26, 22, 18, 0.05);
            backdrop-filter: blur(8px);
        }

        .hero-panel {
            padding: 3.2rem;
            border-radius: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 520px;
        }

        .eyebrow {
            font-size: 0.74rem;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--gold-dark);
            margin-bottom: 1rem;
        }

        .hero-title,
        .section-title,
        .cta-title {
            font-family: var(--font-display);
            font-weight: 300;
            line-height: 1.05;
        }

        .hero-title {
            font-size: clamp(3.2rem, 6vw, 5.6rem);
            margin-bottom: 1.1rem;
        }

        .hero-title em,
        .section-title em,
        .cta-title em {
            font-style: italic;
            color: var(--gold);
        }

        .hero-copy,
        .section-copy,
        .cta-copy,
        .footer-copy {
            color: var(--warm-gray);
            line-height: 1.8;
        }

        .hero-copy {
            max-width: 36rem;
            margin-bottom: 1.8rem;
            font-size: 1rem;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .hero-metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            padding-top: 1.8rem;
            border-top: 1px solid rgba(201, 169, 110, 0.2);
        }

        .metric-value {
            display: block;
            font-family: var(--font-display);
            font-size: 2rem;
            color: var(--ink);
            line-height: 1;
            margin-bottom: 0.35rem;
        }

        .metric-label {
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--warm-gray);
        }

        .hero-visual {
            border-radius: 2rem;
            padding: 2.2rem;
            min-height: 520px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #ecd7c7 0%, #f8f2e9 46%, #d7c0ad 100%);
        }

        .hero-visual::before,
        .hero-visual::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            border: 1px solid rgba(140, 109, 63, 0.18);
        }

        .hero-visual::before {
            width: 420px;
            height: 420px;
            top: -140px;
            right: -110px;
        }

        .hero-visual::after {
            width: 560px;
            height: 560px;
            bottom: -260px;
            left: -120px;
        }

        .visual-card {
            position: absolute;
            left: 2rem;
            right: 2rem;
            bottom: 2rem;
            padding: 1.2rem 1.4rem;
            border-radius: 1.25rem;
            background: rgba(250, 247, 242, 0.78);
            border: 1px solid rgba(26, 22, 18, 0.08);
            backdrop-filter: blur(8px);
        }

        .hero-art {
            position: relative;
            height: 330px;
            display: grid;
            place-items: center;
            perspective: 900px;
        }

        .hero-art::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 42px;
            bottom: 20px;
            border-radius: 50%;
            background: rgba(70, 46, 31, 0.18);
            filter: blur(18px);
            transform: rotate(-8deg);
        }

        .hero-bangle {
            position: absolute;
            width: 260px;
            height: 106px;
            border: 22px solid var(--bangle-color);
            border-radius: 50%;
            box-shadow: inset 0 5px 8px rgba(255, 255, 255, 0.5), 0 10px 16px rgba(79, 46, 30, 0.13);
            transform: rotateX(62deg) rotateZ(-10deg) translateZ(var(--bangle-depth));
            opacity: 0.9;
        }

        .hero-bangle::after {
            content: '';
            position: absolute;
            inset: 5px 16px auto;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            filter: blur(2px);
        }

        .hero-bangle.one { --bangle-color: #c76e55; --bangle-depth: 20px; }
        .hero-bangle.two { --bangle-color: #d8b55c; transform: rotateX(62deg) rotateZ(-10deg) translate(18px, -12px) translateZ(10px); }
        .hero-bangle.three { --bangle-color: #6d9a7e; transform: rotateX(62deg) rotateZ(-10deg) translate(-20px, -26px) translateZ(-10px); }
        .hero-bangle.four { --bangle-color: #a9bdd1; transform: rotateX(62deg) rotateZ(-10deg) translate(2px, -40px) translateZ(-20px); }

        .hero-stamp {
            position: absolute;
            top: 1.7rem;
            right: 1.7rem;
            width: 82px;
            height: 82px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(140, 109, 63, 0.4);
            border-radius: 50%;
            color: var(--gold-dark);
            font-size: 0.62rem;
            letter-spacing: 0.15em;
            line-height: 1.4;
            text-align: center;
            text-transform: uppercase;
            transform: rotate(12deg);
        }

        .visual-kicker {
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold-dark);
            margin-bottom: 0.4rem;
        }

        .visual-title {
            font-family: var(--font-display);
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
        }

        .section-block {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem 3rem;
        }

        .catalog-panel {
            border-radius: 1.8rem;
            padding: 2.2rem;
        }

        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.8rem;
        }

        .catalog-note {
            color: var(--warm-gray);
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .section-title {
            font-size: clamp(2rem, 3vw, 3rem);
            margin: 0;
        }

        .section-copy {
            margin: 0.55rem 0 0;
        }

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1.2rem;
        }

        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            border-radius: 1.35rem;
            background: #fff;
            border: 1px solid rgba(26, 22, 18, 0.08);
        }

        .product-media {
            position: relative;
            aspect-ratio: 3 / 4;
            background: linear-gradient(160deg, #f8eee4, #efe4d7);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .product-media::after {
            content: '';
            position: absolute;
            inset: 0.85rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 1rem;
            pointer-events: none;
        }

        .product-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 1rem;
        }

        .product-gallery {
            position: absolute;
            inset: 1rem;
            display: flex;
            flex-direction: column;
            gap: .7rem;
            z-index: 1;
        }

        .product-gallery-main {
            min-height: 0;
            flex: 1;
            overflow: hidden;
            border-radius: 1rem;
        }

        .product-gallery-main img {
            display: block;
            width: 100%;
            height: 100%;
            transition: opacity .25s ease, transform .35s ease;
        }

        .product-gallery-main img.is-changing {
            opacity: .35;
            transform: scale(1.03);
        }

        .product-thumbnails {
            display: flex;
            gap: .4rem;
            overflow-x: auto;
            padding-bottom: .1rem;
        }

        .product-thumbnail {
            flex: 0 0 2.8rem;
            width: 2.8rem;
            height: 2.8rem;
            padding: .15rem;
            border: 1px solid rgba(26, 22, 18, .16);
            border-radius: .55rem;
            background: rgba(250, 247, 242, .72);
            cursor: pointer;
        }

        .product-thumbnail.is-active {
            border-color: var(--gold-dark);
            box-shadow: 0 0 0 1px var(--gold-dark);
        }

        .product-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: .35rem;
        }

        .product-placeholder {
            position: relative;
            width: 72%;
            height: 62%;
            display: grid;
            place-items: center;
            text-align: center;
            color: rgba(26, 22, 18, 0.52);
            font-family: var(--font-display);
            font-size: 1.1rem;
            letter-spacing: 0.03em;
        }

        .product-placeholder::before,
        .product-placeholder::after {
            content: '';
            position: absolute;
            width: 82%;
            height: 45%;
            border: 16px solid var(--placeholder-color);
            border-radius: 50%;
            transform: rotateX(64deg) rotateZ(-12deg);
            box-shadow: inset 0 4px 5px rgba(255, 255, 255, 0.55), 0 8px 12px rgba(79, 46, 30, 0.12);
        }

        .product-placeholder::before { --placeholder-color: #d49a83; transform: rotateX(64deg) rotateZ(-12deg) translate(-7px, 20px); }
        .product-placeholder::after { --placeholder-color: #d6b768; transform: rotateX(64deg) rotateZ(-12deg) translate(8px, -11px); }

        .product-placeholder span {
            position: relative;
            z-index: 1;
            margin-top: 7rem;
            background: rgba(248, 238, 228, 0.75);
            padding: 0.25rem 0.65rem;
        }

        .product-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            background: var(--ink);
            color: var(--cream);
            font-size: 0.68rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .product-badge.low {
            background: #8a5634;
        }

        .product-body {
            padding: 1.1rem 1.1rem 1.2rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            flex: 1;
        }

        .product-name {
            font-family: var(--font-display);
            font-size: 1.1rem;
            margin: 0;
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--warm-gray);
        }

        .product-description {
            margin: 0;
            color: var(--warm-gray);
            line-height: 1.7;
            font-size: 0.88rem;
            min-height: 3.1rem;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
            margin-top: auto;
            padding-top: 0.25rem;
        }

        .product-price {
            font-family: var(--font-display);
            font-size: 1.25rem;
            color: var(--gold-dark);
        }

        .product-price del {
            font-size: 0.82rem;
            color: var(--warm-gray);
            margin-right: 0.35rem;
        }

        .product-action {
            padding: 0.6rem 0.9rem;
            border: 1px solid rgba(26, 22, 18, 0.12);
            color: var(--ink);
            background: #fff;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .cta-panel {
            margin-top: 1.5rem;
            border-radius: 1.8rem;
            padding: 2.4rem;
            text-align: center;
            background: linear-gradient(160deg, #1a1612 0%, #201a14 100%);
            color: var(--cream);
        }

        .cta-title {
            font-size: clamp(2rem, 4vw, 3.2rem);
            margin: 0 0 0.75rem;
        }

        .cta-copy {
            color: rgba(250, 247, 242, 0.65);
            margin: 0 auto 1.5rem;
            max-width: 42rem;
        }

        .cta-actions {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .cta-button {
            padding: 0.95rem 1.45rem;
            border: 1px solid rgba(201, 169, 110, 0.35);
            color: var(--cream);
            background: transparent;
        }

        .cta-button.primary {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--cream);
        }

        .footer-panel {
            margin: 1.5rem 2rem 2rem;
            border-radius: 1.5rem;
            padding: 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr;
            gap: 1.5rem;
        }

        .footer-brand {
            font-family: var(--font-display);
            font-size: 1.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 0.85rem;
        }

        .footer-brand span {
            color: var(--gold);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 0.55rem;
        }

        .footer-links a {
            color: var(--warm-gray);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--ink);
        }

        .footer-bottom {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(201, 169, 110, 0.16);
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        @media (max-width: 992px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .catalog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .navbar-acryluxe,
            .hero,
            .section-block,
            .footer-panel {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .nav-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-actions {
                width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 0.2rem;
            }

            .nav-links {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .hero-panel,
            .hero-visual,
            .catalog-panel,
            .cta-panel {
                border-radius: 1.25rem;
            }

            .hero-panel,
            .hero-visual {
                min-height: auto;
            }

            .hero-panel {
                padding: 2rem;
            }

            .hero-art {
                height: 270px;
            }

            .hero-bangle {
                width: 210px;
                height: 86px;
                border-width: 18px;
            }

            .hero-metrics,
            .catalog-grid {
                grid-template-columns: 1fr;
            }

            .section-head,
            .product-footer,
            .footer-bottom {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    @php
        $setting = fn (string $key, string $default) => $settings[$key] ?? $default;
        $isAdmin = auth()->check() && auth()->user()->isAdmin();
    @endphp
    <div class="page-shell">
        <header class="navbar-acryluxe">
            <div class="nav-inner">
                <a href="{{ route('home') }}" class="nav-logo">Acr<span>y</span>luxe</a>

                <ul class="nav-links">
                    <li><a href="{{ $setting('header.products.url', '#products') }}">{{ $setting('header.products.label', 'Products') }}</a></li>
                    <li><a href="{{ $setting('header.catalog.url', '#catalog') }}">{{ $setting('header.catalog.label', 'Catalog') }}</a></li>
                    <li><a href="{{ $setting('header.about.url', '#about') }}">{{ $setting('header.about.label', 'About') }}</a></li>
                </ul>

                <div class="nav-actions">
                    <a href="{{ route('cart.index') }}" class="btn-nav">Cart<span class="cart-pill">{{ $cartCount }}</span></a>
                    @auth
                        <a href="{{ route('profile.edit') }}" class="btn-nav">My Account</a>
                        @if($isAdmin)
                            <a href="{{ route('admin.products.index') }}" class="btn-nav">Admin</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-nav">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nav">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        <main>
            @if ($errors->any())
                <div class="section-block pt-4 pb-0">
                    <div class="alert alert-danger mb-0">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="section-block pt-4 pb-0">
                    <div class="alert alert-success mb-0">{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="section-block pt-4 pb-0">
                    <div class="alert alert-danger mb-0">{{ session('error') }}</div>
                </div>
            @endif

            <section class="hero">
                <div class="hero-panel">
                    <div class="eyebrow">{{ $setting('landing.hero.eyebrow', 'Acrylic bangles for every occasion') }}</div>
                    <h1 class="hero-title">{{ $setting('landing.hero.title', 'Wear the art of colour.') }}</h1>
                    <p class="hero-copy">
                        {{ $setting('landing.hero.copy', 'Browse the live product catalog below. Every product shown here comes directly from the project database, with image, price, stock, color, and size details maintained from the admin panel.') }}
                    </p>
                    <div class="hero-actions">
                        <a href="#products" class="btn-primary-gold">Shop Products</a>
                        @if($isAdmin)
                            <a href="{{ route('admin.products.index') }}" class="btn-outline-ink">Manage Catalog</a>
                        @elseif(auth()->check())
                            <a href="{{ route('profile.edit') }}" class="btn-outline-ink">My Account</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline-ink">Sign in</a>
                        @endif
                    </div>

                    <div class="hero-metrics">
                        <div>
                            <span class="metric-value">{{ $products->count() }}</span>
                            <span class="metric-label">Products</span>
                        </div>
                        <div>
                            <span class="metric-value">{{ $products->sum(fn ($product) => $product->totalStock()) }}</span>
                            <span class="metric-label">Units in stock</span>
                        </div>
                        <div>
                            <span class="metric-value">{{ $products->whereNotNull('image')->count() }}</span>
                            <span class="metric-label">With images</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-stamp">Hand<br>finished</div>
                    <div class="hero-art" aria-hidden="true">
                        <div class="hero-bangle one"></div>
                        <div class="hero-bangle two"></div>
                        <div class="hero-bangle three"></div>
                        <div class="hero-bangle four"></div>
                    </div>

                    <div class="visual-card">
                        <div class="visual-kicker">{{ $setting('landing.visual.kicker', 'The colour edit') }}</div>
                        <div class="visual-title">{{ $setting('landing.visual.title', 'A little joy for every wrist.') }}</div>
                        <div class="section-copy mb-0">{{ $setting('landing.visual.copy', 'Translucent colour, polished edges, and easy pieces made to layer.') }}</div>
                    </div>
                </div>
            </section>

            <section class="section-block" id="catalog">
                <div class="catalog-panel">
                    <div class="section-head">
                        <div>
                            <p class="eyebrow mb-2">Catalog</p>
                            <h2 class="section-title">{{ $setting('landing.catalog.title', 'Live product list') }}</h2>
                        </div>
                        <div class="catalog-note">{{ $products->count() }} styles | Ships in 2-4 days</div>
                    </div>

                    <div class="catalog-grid" id="products">
                        @forelse($products as $product)
                            <article class="product-card">
                                @php($sizeInventory = $product->sizeInventory())
                                <div class="product-media">
                                    @if($product->totalStock() <= 5)
                                        <span class="product-badge low">Low stock</span>
                                    @endif

                                    @if($product->imagePaths())
                                        <div class="product-gallery" data-gallery>
                                            <div class="product-gallery-main">
                                                <img src="{{ asset('storage/' . $product->imagePaths()[0]) }}" alt="{{ $product->name }}" data-gallery-main>
                                            </div>
                                            @if(count($product->imagePaths()) > 1)
                                                <div class="product-thumbnails" aria-label="More photos of {{ $product->name }}">
                                                    @foreach($product->imagePaths() as $galleryImage)
                                                        <button type="button" class="product-thumbnail {{ $loop->first ? 'is-active' : '' }}" data-gallery-thumb data-image="{{ asset('storage/' . $galleryImage) }}" aria-label="View photo {{ $loop->iteration }}">
                                                            <img src="{{ asset('storage/' . $galleryImage) }}" alt="">
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="product-placeholder">
                                            <span>{{ $product->color ?: 'Acryluxe' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="product-body">
                                    <h3 class="product-name">{{ $product->name }}</h3>
                                    <div class="product-meta">
                                        @if($product->color)
                                            <span>Color: {{ $product->color }}</span>
                                        @endif
                                        <span>Sizes: {{ implode(', ', array_keys($sizeInventory)) }}</span>
                                    </div>
                                    <p class="product-description">
                                        {{ $product->description ?: 'A polished piece designed to bring colour to your everyday stack.' }}
                                    </p>

                                    <div class="product-footer">
                                        <div class="product-price">₹{{ number_format($product->price, 2) }}</div>
                                        @if($product->totalStock() > 0)
                                            @if($isAdmin)
                                                <div class="d-flex gap-2 flex-wrap justify-content-end">
                                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                                        @csrf
                                                        <select name="size" class="form-select form-select-sm" required aria-label="Choose a size for {{ $product->name }}">
                                                            <option value="" disabled selected>Choose size</option>
                                                            @foreach($sizeInventory as $size => $quantity)
                                                                @if($quantity > 0)
                                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="product-action">Add to cart</button>
                                                    </form>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="product-action">Edit</a>
                                                </div>
                                            @else
                                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                                    @csrf
                                                    <select name="size" class="form-select form-select-sm" required aria-label="Choose a size for {{ $product->name }}">
                                                        <option value="" disabled selected>Choose size</option>
                                                        @foreach($sizeInventory as $size => $quantity)
                                                            @if($quantity > 0)
                                                                <option value="{{ $size }}">{{ $size }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="product-action">Add to cart</button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="product-action" aria-disabled="true">Out of stock</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="col-12">
                                <div class="p-4 p-md-5 text-center border rounded-4 bg-white">
                                    <h3 class="section-title mb-2">No products yet</h3>
                                    <p class="section-copy mb-3">Add products from the admin panel so the homepage can show the live catalog.</p>
                                    @if($isAdmin)
                                        <a href="{{ route('admin.products.create') }}" class="btn-primary-gold">Create product</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-primary-gold">Sign in</a>
                                    @endif
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="section-block" id="about">
                <div class="cta-panel">
                    <h2 class="cta-title">{{ $setting('landing.cta.title', 'Keep the catalog current.') }}</h2>
                    <p class="cta-copy">
                        {{ $setting('landing.cta.copy', 'The storefront, cart, checkout, and admin order views run on the same database records. Product updates and stock changes are reflected automatically across the flow.') }}
                    </p>
                    <div class="cta-actions">
                        <a href="#products" class="cta-button primary">Browse products</a>
                        @if($isAdmin)
                            <a href="{{ route('admin.products.index') }}" class="cta-button">Open admin</a>
                        @elseif(auth()->check())
                            <a href="{{ route('profile.edit') }}" class="cta-button">My account</a>
                        @else
                            <a href="{{ route('login') }}" class="cta-button">Sign in</a>
                        @endif
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer-panel">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">Acr<span>y</span>luxe</div>
                    <p class="footer-copy mb-0">{{ $setting('landing.footer.copy', 'Acrylic bangle catalog built around the product model in this project. The homepage only shows data and actions that exist in the current Laravel app.') }}</p>
                </div>

                <div>
                    <h3 class="eyebrow">Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ $setting('footer.collection.url', '#products') }}">{{ $setting('footer.collection.label', 'Collection') }}</a></li>
                        <li><a href="{{ $setting('footer.legal.url', route('terms')) }}">{{ $setting('footer.legal.label', 'Legal') }}</a></li>
                        <li><a href="{{ $setting('footer.contact.url', 'mailto:hello@example.com') }}">{{ $setting('footer.contact.label', 'Contact') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="eyebrow">Account</h3>
                    <ul class="footer-links">
                        @auth
                            <li><a href="{{ route('profile.edit') }}">My account</a></li>
                            @if($isAdmin)
                                <li><a href="{{ route('admin.products.index') }}">Admin products</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('login') }}">Sign in</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span class="footer-copy">&copy; {{ date('Y') }} Acryluxe. All rights reserved.</span>
                <span class="footer-copy">{{ $setting('landing.footer.note', '') }}</span>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[data-gallery]').forEach((gallery) => {
            const mainImage = gallery.querySelector('[data-gallery-main]');
            const thumbnails = Array.from(gallery.querySelectorAll('[data-gallery-thumb]'));
            let activeIndex = 0;

            const showImage = (index) => {
                activeIndex = index;
                mainImage.classList.add('is-changing');
                window.setTimeout(() => {
                    mainImage.src = thumbnails[index].dataset.image;
                    mainImage.classList.remove('is-changing');
                }, 120);
                thumbnails.forEach((thumbnail, thumbnailIndex) => thumbnail.classList.toggle('is-active', thumbnailIndex === index));
            };

            thumbnails.forEach((thumbnail, index) => thumbnail.addEventListener('click', () => showImage(index)));

            if (thumbnails.length > 1) {
                window.setInterval(() => showImage((activeIndex + 1) % thumbnails.length), 5000);
            }
        });
    </script>
</body>
</html>
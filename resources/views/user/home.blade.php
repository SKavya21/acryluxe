@extends('layouts.app')

@section('content')

<!-- 🔥 HERO / BANNER -->
<div class="bg-dark text-white text-center p-5 rounded mb-5">
    <h1 class="display-5 fw-bold">Acryluxe</h1>
    <p class="lead">Elegant Acrylic Bangles for Every Occasion</p>
    <a href="#products" class="btn btn-light mt-3 px-4">Shop Now</a>
</div>

<!-- 🎯 FEATURE SECTION -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Acryluxe — Acrylic Bangles</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<style>
  :root {
    --gold: #C9A96E;
    --gold-light: #E8D5B0;
    --gold-dark: #8C6D3F;
    --ink: #1A1612;
    --cream: #FAF7F2;
    --blush: #F2E8DF;
    --warm-gray: #9C948A;
    --font-display: 'Cormorant Garamond', Georgia, serif;
    --font-body: 'DM Sans', sans-serif;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  html { scroll-behavior: smooth; }

  body {
    background: var(--cream);
    color: var(--ink);
    font-family: var(--font-body);
    font-weight: 300;
    overflow-x: hidden;
  }

  /* ── NOISE TEXTURE OVERLAY ── */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 9999;
    opacity: 0.4;
  }

  /* ── NAVBAR ── */
  .navbar-acryluxe {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
    padding: 1.25rem 3rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: transparent;
    transition: background 0.4s, backdrop-filter 0.4s, box-shadow 0.4s;
  }
  .navbar-acryluxe.scrolled {
    background: rgba(250,247,242,0.92);
    backdrop-filter: blur(12px);
    box-shadow: 0 1px 0 rgba(201,169,110,0.2);
  }
  .nav-logo {
    font-family: var(--font-display);
    font-size: 1.75rem;
    font-weight: 400;
    letter-spacing: 0.18em;
    color: var(--ink);
    text-decoration: none;
    text-transform: uppercase;
  }
  .nav-logo span { color: var(--gold); }
  .nav-links {
    display: flex;
    gap: 2.5rem;
    list-style: none;
  }
  .nav-links a {
    font-family: var(--font-body);
    font-size: 0.78rem;
    font-weight: 400;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--ink);
    text-decoration: none;
    opacity: 0.75;
    transition: opacity 0.2s;
  }
  .nav-links a:hover { opacity: 1; }
  .nav-actions { display: flex; gap: 1rem; align-items: center; }
  .btn-nav-login {
    font-family: var(--font-body);
    font-size: 0.75rem;
    font-weight: 400;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--ink);
    text-decoration: none;
    padding: 0.5rem 1.5rem;
    border: 1px solid rgba(26,22,18,0.3);
    border-radius: 0;
    transition: all 0.25s;
    background: transparent;
  }
  .btn-nav-login:hover { background: var(--ink); color: var(--cream); border-color: var(--ink); }
  .btn-nav-register {
    font-family: var(--font-body);
    font-size: 0.75rem;
    font-weight: 400;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--cream);
    text-decoration: none;
    padding: 0.5rem 1.5rem;
    background: var(--gold);
    border: 1px solid var(--gold);
    border-radius: 0;
    transition: all 0.25s;
  }
  .btn-nav-register:hover { background: var(--gold-dark); border-color: var(--gold-dark); color: var(--cream); }

  /* ── HERO ── */
  .hero {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    position: relative;
    overflow: hidden;
  }
  .hero-left {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 8rem 4rem 5rem 5rem;
    position: relative;
    z-index: 2;
  }
  .hero-eyebrow {
    font-family: var(--font-body);
    font-size: 0.72rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 1.5rem;
    opacity: 0;
    animation: fadeUp 0.8s 0.2s forwards;
  }
  .hero-title {
    font-family: var(--font-display);
    font-size: clamp(3.5rem, 5vw, 5.5rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--ink);
    margin-bottom: 1.75rem;
    opacity: 0;
    animation: fadeUp 0.8s 0.4s forwards;
  }
  .hero-title em {
    font-style: italic;
    color: var(--gold);
  }
  .hero-subtitle {
    font-family: var(--font-body);
    font-size: 0.95rem;
    line-height: 1.75;
    color: var(--warm-gray);
    max-width: 380px;
    margin-bottom: 2.75rem;
    opacity: 0;
    animation: fadeUp 0.8s 0.6s forwards;
  }
  .hero-cta-group {
    display: flex;
    gap: 1.25rem;
    align-items: center;
    opacity: 0;
    animation: fadeUp 0.8s 0.8s forwards;
  }
  .btn-primary-gold {
    font-family: var(--font-body);
    font-size: 0.78rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    font-weight: 400;
    color: var(--cream);
    background: var(--gold);
    border: 1.5px solid var(--gold);
    padding: 1rem 2.5rem;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
  }
  .btn-primary-gold::after {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gold-dark);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    z-index: -1;
  }
  .btn-primary-gold:hover { color: var(--cream); border-color: var(--gold-dark); }
  .btn-primary-gold:hover::after { transform: translateX(0); }
  .btn-outline-ink {
    font-family: var(--font-body);
    font-size: 0.78rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    font-weight: 400;
    color: var(--ink);
    background: transparent;
    border: none;
    padding: 1rem 0;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: gap 0.25s;
  }
  .btn-outline-ink:hover { color: var(--ink); gap: 1rem; }
  .btn-outline-ink svg { width: 18px; }

  .hero-stats {
    display: flex;
    gap: 3rem;
    margin-top: 4rem;
    padding-top: 2.5rem;
    border-top: 1px solid rgba(201,169,110,0.25);
    opacity: 0;
    animation: fadeUp 0.8s 1.0s forwards;
  }
  .stat-num {
    font-family: var(--font-display);
    font-size: 2.2rem;
    font-weight: 300;
    color: var(--ink);
    line-height: 1;
  }
  .stat-label {
    font-size: 0.72rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--warm-gray);
    margin-top: 0.3rem;
  }

  /* ── HERO RIGHT (visual) ── */
  .hero-right {
    position: relative;
    overflow: hidden;
    background: var(--blush);
  }
  .hero-right::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 60% 40%, rgba(201,169,110,0.18) 0%, transparent 70%);
  }
  .bangle-display {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  /* Decorative SVG bangles */
  .bangle-svg-wrap {
    animation: floatSlow 6s ease-in-out infinite;
    opacity: 0;
    animation-fill-mode: forwards;
    animation-delay: 0.3s;
  }
  @keyframes floatSlow {
    0%   { transform: translateY(0px); opacity: 0; }
    10%  { opacity: 1; }
    50%  { transform: translateY(-14px); opacity: 1; }
    100% { transform: translateY(0px); opacity: 1; }
  }
  .hero-deco-line {
    position: absolute;
    width: 1px;
    background: linear-gradient(to bottom, transparent, var(--gold), transparent);
    opacity: 0.4;
  }
  .hero-deco-line-1 { left: 20%; top: 10%; height: 80%; }
  .hero-deco-line-2 { right: 20%; top: 15%; height: 70%; }
  .hero-label-float {
    position: absolute;
    font-family: var(--font-display);
    font-style: italic;
    font-size: 0.85rem;
    color: var(--gold-dark);
    letter-spacing: 0.05em;
    opacity: 0;
    animation: fadeIn 1s 1.2s forwards;
  }
  .hero-label-float-1 { top: 22%; right: 12%; }
  .hero-label-float-2 { bottom: 28%; left: 10%; }

  /* ── MARQUEE STRIP ── */
  .marquee-strip {
    background: var(--ink);
    padding: 0.9rem 0;
    overflow: hidden;
  }
  .marquee-track {
    display: flex;
    gap: 0;
    white-space: nowrap;
    animation: marquee 28s linear infinite;
  }
  .marquee-item {
    font-family: var(--font-display);
    font-style: italic;
    font-size: 0.95rem;
    font-weight: 300;
    color: var(--gold-light);
    padding: 0 3rem;
    letter-spacing: 0.08em;
  }
  .marquee-dot {
    color: var(--gold);
    font-size: 1.2rem;
    line-height: 0;
    vertical-align: middle;
  }
  @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }

  /* ── FEATURED PRODUCTS ── */
  .section-products {
    padding: 7rem 5rem;
    background: var(--cream);
  }
  .section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 4rem;
  }
  .section-eyebrow {
    font-size: 0.72rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 0.6rem;
  }
  .section-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 300;
    line-height: 1.1;
    color: var(--ink);
  }
  .section-title em { font-style: italic; color: var(--gold); }
  .view-all-link {
    font-size: 0.75rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--warm-gray);
    text-decoration: none;
    border-bottom: 1px solid var(--warm-gray);
    padding-bottom: 2px;
    transition: color 0.2s, border-color 0.2s;
    white-space: nowrap;
    margin-bottom: 0.25rem;
  }
  .view-all-link:hover { color: var(--gold); border-color: var(--gold); }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
  }
  .product-card {
    position: relative;
    cursor: pointer;
    group: true;
  }
  .product-img-wrap {
    position: relative;
    overflow: hidden;
    aspect-ratio: 3/4;
    background: var(--blush);
    margin-bottom: 1.2rem;
  }
  .product-img-inner {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94);
  }
  .product-card:hover .product-img-inner { transform: scale(1.04); }
  .product-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    font-size: 0.65rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    background: var(--gold);
    color: var(--cream);
    padding: 0.3rem 0.8rem;
  }
  .product-badge.new { background: var(--ink); }
  .product-wishlist {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 32px; height: 32px;
    background: rgba(250,247,242,0.85);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateY(-4px);
    transition: opacity 0.25s, transform 0.25s;
  }
  .product-card:hover .product-wishlist { opacity: 1; transform: translateY(0); }
  .product-name {
    font-family: var(--font-display);
    font-size: 1.05rem;
    font-weight: 400;
    color: var(--ink);
    margin-bottom: 0.25rem;
  }
  .product-sub {
    font-size: 0.72rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--warm-gray);
    margin-bottom: 0.5rem;
  }
  .product-price {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 300;
    color: var(--gold-dark);
  }
  .product-price del {
    font-size: 0.85rem;
    color: var(--warm-gray);
    margin-right: 0.4rem;
    text-decoration-color: var(--warm-gray);
  }
  .product-add-btn {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: var(--ink);
    color: var(--cream);
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    border: none;
    padding: 0.75rem;
    cursor: pointer;
    transform: translateY(100%);
    transition: transform 0.3s ease;
    font-family: var(--font-body);
  }
  .product-card:hover .product-add-btn { transform: translateY(0); }

  /* ── BRAND STRIP ── */
  .brand-strip {
    background: var(--blush);
    padding: 5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
  }
  .brand-left {
    padding-right: 5rem;
    border-right: 1px solid rgba(201,169,110,0.3);
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .brand-right {
    padding-left: 5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2.5rem;
  }
  .brand-quote {
    font-family: var(--font-display);
    font-size: clamp(1.6rem, 2.8vw, 2.4rem);
    font-weight: 300;
    font-style: italic;
    line-height: 1.4;
    color: var(--ink);
    margin-bottom: 1.5rem;
  }
  .brand-desc {
    font-size: 0.88rem;
    line-height: 1.8;
    color: var(--warm-gray);
    margin-bottom: 2rem;
  }
  .feature-item {}
  .feature-icon {
    width: 36px;
    height: 2px;
    background: var(--gold);
    margin-bottom: 1rem;
  }
  .feature-title {
    font-family: var(--font-display);
    font-size: 1.05rem;
    font-weight: 400;
    color: var(--ink);
    margin-bottom: 0.4rem;
  }
  .feature-desc {
    font-size: 0.82rem;
    line-height: 1.7;
    color: var(--warm-gray);
  }

  /* ── CATEGORIES ── */
  .section-categories {
    padding: 7rem 5rem;
  }
  .categories-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 1.25rem;
    margin-top: 3.5rem;
  }
  .cat-card {
    position: relative;
    overflow: hidden;
    cursor: pointer;
  }
  .cat-card-inner {
    aspect-ratio: auto;
    padding: 3rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 280px;
    position: relative;
  }
  .cat-card-1 { background: var(--ink); }
  .cat-card-2 { background: #3D2B1F; }
  .cat-card-3 { background: #1F2D3D; }
  .cat-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 60%);
    transition: opacity 0.3s;
    opacity: 0;
  }
  .cat-card:hover::after { opacity: 1; }
  .cat-tag {
    font-size: 0.68rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 0.5rem;
    position: relative; z-index: 2;
  }
  .cat-name {
    font-family: var(--font-display);
    font-size: 1.7rem;
    font-weight: 300;
    color: var(--cream);
    line-height: 1.15;
    margin-bottom: 0.5rem;
    position: relative; z-index: 2;
  }
  .cat-count {
    font-size: 0.75rem;
    color: rgba(250,247,242,0.5);
    position: relative; z-index: 2;
  }
  /* Decorative bangle in categories */
  .cat-bangle-deco {
    position: absolute;
    top: 50%;
    right: 2rem;
    transform: translateY(-50%);
    opacity: 0.12;
    transition: opacity 0.3s, transform 0.4s;
  }
  .cat-card:hover .cat-bangle-deco { opacity: 0.2; transform: translateY(-50%) scale(1.05); }

  /* ── NEWSLETTER / CTA ── */
  .section-cta {
    padding: 7rem 5rem;
    background: var(--ink);
    position: relative;
    overflow: hidden;
    text-align: center;
  }
  .section-cta::before {
    content: '';
    position: absolute;
    top: -50%; left: 50%;
    width: 600px; height: 600px;
    border: 1px solid rgba(201,169,110,0.1);
    border-radius: 50%;
    transform: translateX(-50%);
  }
  .section-cta::after {
    content: '';
    position: absolute;
    top: -20%; left: 50%;
    width: 900px; height: 900px;
    border: 1px solid rgba(201,169,110,0.05);
    border-radius: 50%;
    transform: translateX(-50%);
  }
  .cta-eyebrow {
    font-size: 0.72rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 1rem;
    position: relative; z-index: 2;
  }
  .cta-title {
    font-family: var(--font-display);
    font-size: clamp(2.2rem, 4vw, 3.5rem);
    font-weight: 300;
    color: var(--cream);
    line-height: 1.15;
    margin-bottom: 1.2rem;
    position: relative; z-index: 2;
  }
  .cta-title em { font-style: italic; color: var(--gold); }
  .cta-sub {
    font-size: 0.88rem;
    color: rgba(250,247,242,0.5);
    margin-bottom: 3rem;
    position: relative; z-index: 2;
  }
  .cta-form {
    display: flex;
    gap: 0;
    max-width: 460px;
    margin: 0 auto;
    position: relative; z-index: 2;
  }
  .cta-form input {
    flex: 1;
    background: rgba(250,247,242,0.06);
    border: 1px solid rgba(201,169,110,0.3);
    border-right: none;
    padding: 1rem 1.5rem;
    font-family: var(--font-body);
    font-size: 0.85rem;
    color: var(--cream);
    outline: none;
    transition: border-color 0.2s;
  }
  .cta-form input::placeholder { color: rgba(250,247,242,0.3); }
  .cta-form input:focus { border-color: var(--gold); }
  .cta-form button {
    background: var(--gold);
    color: var(--cream);
    border: 1px solid var(--gold);
    padding: 1rem 2rem;
    font-family: var(--font-body);
    font-size: 0.75rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.25s;
  }
  .cta-form button:hover { background: var(--gold-dark); border-color: var(--gold-dark); }

  /* ── FOOTER ── */
  footer {
    background: #120F0C;
    padding: 5rem 5rem 2.5rem;
    color: rgba(250,247,242,0.5);
  }
  .footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 3rem;
    margin-bottom: 4rem;
  }
  .footer-brand-name {
    font-family: var(--font-display);
    font-size: 1.5rem;
    font-weight: 300;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--cream);
    margin-bottom: 1rem;
  }
  .footer-brand-name span { color: var(--gold); }
  .footer-tagline {
    font-size: 0.82rem;
    line-height: 1.8;
    margin-bottom: 1.5rem;
  }
  .footer-col-title {
    font-size: 0.7rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 1.2rem;
  }
  .footer-links { list-style: none; }
  .footer-links li { margin-bottom: 0.7rem; }
  .footer-links a {
    font-size: 0.83rem;
    color: rgba(250,247,242,0.45);
    text-decoration: none;
    transition: color 0.2s;
  }
  .footer-links a:hover { color: var(--cream); }
  .footer-bottom {
    border-top: 1px solid rgba(201,169,110,0.12);
    padding-top: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .footer-copy { font-size: 0.75rem; }
  .footer-legal { display: flex; gap: 2rem; }
  .footer-legal a { font-size: 0.75rem; color: rgba(250,247,242,0.35); text-decoration: none; transition: color 0.2s; }
  .footer-legal a:hover { color: var(--cream); }

  /* ── ANIMATIONS ── */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
  }

  /* ── MOBILE ── */
  @media (max-width: 991px) {
    .hero { grid-template-columns: 1fr; min-height: auto; }
    .hero-left { padding: 7rem 2rem 3rem; }
    .hero-right { display: none; }
    .navbar-acryluxe { padding: 1.25rem 1.5rem; }
    .nav-links { display: none; }
    .section-products { padding: 4rem 1.5rem; }
    .products-grid { grid-template-columns: repeat(2, 1fr); }
    .brand-strip { grid-template-columns: 1fr; padding: 3rem 1.5rem; }
    .brand-left { padding-right: 0; border-right: none; border-bottom: 1px solid rgba(201,169,110,0.3); padding-bottom: 2.5rem; margin-bottom: 2.5rem; }
    .brand-right { padding-left: 0; }
    .section-categories { padding: 4rem 1.5rem; }
    .categories-grid { grid-template-columns: 1fr; }
    .section-cta { padding: 5rem 1.5rem; }
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    footer { padding: 3.5rem 1.5rem 2rem; }
    .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
  }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-acryluxe" id="mainNav">
  <a href="#" class="nav-logo">Acr<span>y</span>luxe</a>
  <ul class="nav-links">
    <li><a href="#collections">Collections</a></li>
    <li><a href="#categories">Categories</a></li>
    <li><a href="#">New Arrivals</a></li>
    <li><a href="#">About</a></li>
  </ul>
  <div class="nav-actions">
    <a href="{{ route('login') }}" class="btn-nav-login">Sign In</a>
    <a href="{{ route('register') }}" class="btn-nav-register">Register</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-left">
    <p class="hero-eyebrow">New Collection — Monsoon 2025</p>
    <h1 class="hero-title">
      Wear the<br><em>Art of</em><br>Colour
    </h1>
    <p class="hero-subtitle">
      Handcrafted acrylic bangles in vibrant hues and refined forms — designed for women who celebrate every moment.
    </p>
    <div class="hero-cta-group">
      <a href="#collections" class="btn-primary-gold">Shop Now</a>
      <a href="#categories" class="btn-outline-ink">
        Explore collections
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
    <div class="hero-stats">
      <div>
        <div class="stat-num">500+</div>
        <div class="stat-label">Designs</div>
      </div>
      <div>
        <div class="stat-num">12K+</div>
        <div class="stat-label">Happy customers</div>
      </div>
      <div>
        <div class="stat-num">Pan-India</div>
        <div class="stat-label">Delivery</div>
      </div>
    </div>
  </div>

  <div class="hero-right">
    <div class="hero-deco-line hero-deco-line-1"></div>
    <div class="hero-deco-line hero-deco-line-2"></div>
    <div class="bangle-display">
      <div class="bangle-svg-wrap">
        <svg width="380" height="400" viewBox="0 0 380 400" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Back bangles -->
          <ellipse cx="190" cy="210" rx="130" ry="40" stroke="#C9A96E" stroke-width="18" opacity="0.18"/>
          <ellipse cx="190" cy="225" rx="130" ry="40" stroke="#B8860B" stroke-width="16" opacity="0.12"/>
          <!-- Mid bangles -->
          <ellipse cx="190" cy="200" rx="128" ry="38" stroke="#C9A96E" stroke-width="20" opacity="0.35"/>
          <ellipse cx="190" cy="182" rx="120" ry="36" stroke="#E8A090" stroke-width="18" opacity="0.55"/>
          <ellipse cx="190" cy="165" rx="116" ry="34" stroke="#90B8D8" stroke-width="20" opacity="0.6"/>
          <!-- Front bangles -->
          <ellipse cx="190" cy="150" rx="112" ry="32" stroke="#C9A96E" stroke-width="22" opacity="0.85"/>
          <ellipse cx="190" cy="136" rx="108" ry="30" stroke="#D4A4C0" stroke-width="18" opacity="0.75"/>
          <ellipse cx="190" cy="122" rx="102" ry="28" stroke="#7EC8A4" stroke-width="20" opacity="0.7"/>
          <!-- Top bangle highlight -->
          <ellipse cx="190" cy="110" rx="96" ry="26" stroke="#C9A96E" stroke-width="24" opacity="0.95"/>
          <!-- Shimmer dots on top bangle -->
          <circle cx="100" cy="106" r="3" fill="#FAF7F2" opacity="0.9"/>
          <circle cx="280" cy="106" r="3" fill="#FAF7F2" opacity="0.9"/>
          <circle cx="190" cy="84" r="2.5" fill="#FAF7F2" opacity="0.7"/>
          <!-- Reflection arc on top bangle -->
          <path d="M110 100 Q190 78 270 100" stroke="rgba(255,255,255,0.35)" stroke-width="3" stroke-linecap="round"/>
          <!-- Label lines -->
          <line x1="286" y1="110" x2="330" y2="80" stroke="#C9A96E" stroke-width="0.75" opacity="0.5"/>
          <circle cx="286" cy="110" r="2" fill="#C9A96E" opacity="0.5"/>
          <text x="333" y="78" font-family="'DM Sans', sans-serif" font-size="11" fill="#8C6D3F" letter-spacing="1" opacity="0.8">Handcrafted</text>
        </svg>
      </div>
    </div>
    <div class="hero-label-float hero-label-float-1">Artisan crafted</div>
    <div class="hero-label-float hero-label-float-2">Premium acrylic</div>
  </div>
</section>

<!-- MARQUEE -->
<div class="marquee-strip">
  <div class="marquee-track">
    <span class="marquee-item">Free shipping above ₹599 <span class="marquee-dot">·</span></span>
    <span class="marquee-item">Handcrafted in India <span class="marquee-dot">·</span></span>
    <span class="marquee-item">500+ designs in stock <span class="marquee-dot">·</span></span>
    <span class="marquee-item">Pan-India delivery <span class="marquee-dot">·</span></span>
    <span class="marquee-item">Easy returns within 7 days <span class="marquee-dot">·</span></span>
    <span class="marquee-item">New arrivals every week <span class="marquee-dot">·</span></span>
    <span class="marquee-item">Free shipping above ₹599 <span class="marquee-dot">·</span></span>
    <span class="marquee-item">Handcrafted in India <span class="marquee-dot">·</span></span>
    <span class="marquee-item">500+ designs in stock <span class="marquee-dot">·</span></span>
    <span class="marquee-item">Pan-India delivery <span class="marquee-dot">·</span></span>
    <span class="marquee-item">Easy returns within 7 days <span class="marquee-dot">·</span></span>
    <span class="marquee-item">New arrivals every week <span class="marquee-dot">·</span></span>
  </div>
</div>

<!-- FEATURED PRODUCTS -->
<section class="section-products" id="collections">
  <div class="section-header">
    <div>
      <p class="section-eyebrow">Featured pieces</p>
      <h2 class="section-title">Most <em>loved</em><br>this season</h2>
    </div>
    <a href="#" class="view-all-link">View all products →</a>
  </div>
  <div class="products-grid">

    <!-- Product 1 -->
    <div class="product-card">
      <div class="product-img-wrap">
        <div class="product-img-inner">
          <svg width="120" height="160" viewBox="0 0 120 160" fill="none">
            <ellipse cx="60" cy="90" rx="48" ry="14" stroke="#C9A96E" stroke-width="14" opacity="0.9"/>
            <ellipse cx="60" cy="78" rx="46" ry="13" stroke="#E8A090" stroke-width="12" opacity="0.8"/>
            <ellipse cx="60" cy="67" rx="43" ry="12" stroke="#C9A96E" stroke-width="14" opacity="0.95"/>
            <path d="M18 82 Q60 64 102 82" stroke="rgba(255,255,255,0.4)" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <span class="product-badge new">New</span>
        <button class="product-wishlist">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1A1612" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
        <button class="product-add-btn">Add to Cart</button>
      </div>
      <p class="product-sub">Set of 4</p>
      <h3 class="product-name">Blush Garden Set</h3>
      <p class="product-price">₹399</p>
    </div>

    <!-- Product 2 -->
    <div class="product-card">
      <div class="product-img-wrap">
        <div class="product-img-inner">
          <svg width="120" height="160" viewBox="0 0 120 160" fill="none">
            <ellipse cx="60" cy="95" rx="48" ry="14" stroke="#7EC8A4" stroke-width="16" opacity="0.7"/>
            <ellipse cx="60" cy="80" rx="46" ry="13" stroke="#5BA886" stroke-width="14" opacity="0.8"/>
            <ellipse cx="60" cy="66" rx="43" ry="12" stroke="#7EC8A4" stroke-width="16" opacity="0.9"/>
            <ellipse cx="60" cy="53" rx="40" ry="11" stroke="#3D8F68" stroke-width="14" opacity="0.85"/>
            <path d="M19 62 Q60 44 101 62" stroke="rgba(255,255,255,0.45)" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <span class="product-badge">Sale</span>
        <button class="product-wishlist">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1A1612" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
        <button class="product-add-btn">Add to Cart</button>
      </div>
      <p class="product-sub">Set of 6</p>
      <h3 class="product-name">Emerald Mist Stack</h3>
      <p class="product-price"><del>₹599</del>₹449</p>
    </div>

    <!-- Product 3 -->
    <div class="product-card">
      <div class="product-img-wrap">
        <div class="product-img-inner">
          <svg width="120" height="160" viewBox="0 0 120 160" fill="none">
            <ellipse cx="60" cy="88" rx="48" ry="14" stroke="#D4A4C0" stroke-width="14" opacity="0.75"/>
            <ellipse cx="60" cy="74" rx="46" ry="13" stroke="#C9A96E" stroke-width="12" opacity="0.9"/>
            <ellipse cx="60" cy="61" rx="43" ry="12" stroke="#E8B0CC" stroke-width="14" opacity="0.85"/>
            <path d="M17 70 Q60 52 103 70" stroke="rgba(255,255,255,0.4)" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <button class="product-wishlist">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1A1612" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
        <button class="product-add-btn">Add to Cart</button>
      </div>
      <p class="product-sub">Set of 3</p>
      <h3 class="product-name">Rose Petal Trio</h3>
      <p class="product-price">₹329</p>
    </div>

    <!-- Product 4 -->
    <div class="product-card">
      <div class="product-img-wrap">
        <div class="product-img-inner">
          <svg width="120" height="160" viewBox="0 0 120 160" fill="none">
            <ellipse cx="60" cy="100" rx="48" ry="14" stroke="#90B8D8" stroke-width="16" opacity="0.65"/>
            <ellipse cx="60" cy="85" rx="46" ry="13" stroke="#6899C0" stroke-width="14" opacity="0.75"/>
            <ellipse cx="60" cy="71" rx="43" ry="12" stroke="#C9A96E" stroke-width="16" opacity="0.9"/>
            <ellipse cx="60" cy="57" rx="40" ry="11" stroke="#90B8D8" stroke-width="14" opacity="0.8"/>
            <ellipse cx="60" cy="44" rx="37" ry="10" stroke="#4A7FA8" stroke-width="14" opacity="0.85"/>
            <path d="M22 52 Q60 34 98 52" stroke="rgba(255,255,255,0.45)" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <span class="product-badge new">New</span>
        <button class="product-wishlist">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1A1612" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
        <button class="product-add-btn">Add to Cart</button>
      </div>
      <p class="product-sub">Set of 5</p>
      <h3 class="product-name">Sapphire Cascade</h3>
      <p class="product-price">₹549</p>
    </div>

  </div>
</section>

<!-- BRAND STRIP -->
<section class="brand-strip">
  <div class="brand-left">
    <p class="section-eyebrow">Our craft</p>
    <p class="brand-quote">"Every bangle tells a story of colour, craft &amp; confidence."</p>
    <p class="brand-desc">At Acryluxe, we design each piece with precision using premium acrylic materials that are lightweight, durable, and brilliant in colour — built for everyday wear and festive moments alike.</p>
    <a href="register.html" class="btn-primary-gold" style="display:inline-block;width:fit-content;">Join Acryluxe</a>
  </div>
  <div class="brand-right">
    <div class="feature-item">
      <div class="feature-icon"></div>
      <h4 class="feature-title">Premium Acrylic</h4>
      <p class="feature-desc">Lightweight, hypoallergenic material that retains colour brilliance wash after wash.</p>
    </div>
    <div class="feature-item">
      <div class="feature-icon"></div>
      <h4 class="feature-title">Artisan Made</h4>
      <p class="feature-desc">Each piece crafted by skilled artisans blending traditional forms with modern finishes.</p>
    </div>
    <div class="feature-item">
      <div class="feature-icon"></div>
      <h4 class="feature-title">Fast Shipping</h4>
      <p class="feature-desc">Pan-India delivery within 3–5 days. Free shipping on orders above ₹599.</p>
    </div>
    <div class="feature-item">
      <div class="feature-icon"></div>
      <h4 class="feature-title">Easy Returns</h4>
      <p class="feature-desc">Not in love? Return within 7 days, no questions asked. Customer happiness first.</p>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="section-categories" id="categories">
  <div class="section-header">
    <div>
      <p class="section-eyebrow">Browse by style</p>
      <h2 class="section-title">Shop by <em>Category</em></h2>
    </div>
  </div>
  <div class="categories-grid">
    <div class="cat-card cat-card-1">
      <div class="cat-card-inner">
        <svg class="cat-bangle-deco" width="160" height="140" viewBox="0 0 160 140" fill="none">
          <ellipse cx="80" cy="80" rx="70" ry="22" stroke="#C9A96E" stroke-width="20"/>
          <ellipse cx="80" cy="60" rx="66" ry="20" stroke="#E8D5B0" stroke-width="16"/>
        </svg>
        <p class="cat-tag">Bestseller</p>
        <h3 class="cat-name">Festive<br>Collection</h3>
        <p class="cat-count">48 designs</p>
      </div>
    </div>
    <div class="cat-card cat-card-2">
      <div class="cat-card-inner">
        <svg class="cat-bangle-deco" width="120" height="100" viewBox="0 0 120 100" fill="none">
          <ellipse cx="60" cy="60" rx="50" ry="16" stroke="#E8A090" stroke-width="16"/>
          <ellipse cx="60" cy="44" rx="46" ry="14" stroke="#D4A4C0" stroke-width="14"/>
        </svg>
        <p class="cat-tag">Trending</p>
        <h3 class="cat-name">Pastel<br>Series</h3>
        <p class="cat-count">32 designs</p>
      </div>
    </div>
    <div class="cat-card cat-card-3">
      <div class="cat-card-inner">
        <svg class="cat-bangle-deco" width="120" height="100" viewBox="0 0 120 100" fill="none">
          <ellipse cx="60" cy="60" rx="50" ry="16" stroke="#90B8D8" stroke-width="16"/>
          <ellipse cx="60" cy="44" rx="46" ry="14" stroke="#7EC8A4" stroke-width="14"/>
        </svg>
        <p class="cat-tag">New</p>
        <h3 class="cat-name">Everyday<br>Wear</h3>
        <p class="cat-count">64 designs</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA / NEWSLETTER -->
<section class="section-cta">
  <p class="cta-eyebrow">Stay in the loop</p>
  <h2 class="cta-title">Get early access to<br><em>new arrivals</em></h2>
  <p class="cta-sub">Subscribe for exclusive drops, styling tips, and members-only offers.</p>
  <div class="cta-form">
    <input type="email" placeholder="Your email address"/>
    <button type="button">Subscribe</button>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div>
      <div class="footer-brand-name">Acr<span>y</span>luxe</div>
      <p class="footer-tagline">Handcrafted acrylic bangles designed for women who celebrate colour, craft, and confidence — every single day.</p>
    </div>
    <div>
      <p class="footer-col-title">Shop</p>
      <ul class="footer-links">
        <li><a href="#">New Arrivals</a></li>
        <li><a href="#">Festive Collection</a></li>
        <li><a href="#">Pastel Series</a></li>
        <li><a href="#">Everyday Wear</a></li>
        <li><a href="#">Bridal Sets</a></li>
      </ul>
    </div>
    <div>
      <p class="footer-col-title">Account</p>
      <ul class="footer-links">
        <li><a href="login.html">Sign In</a></li>
        <li><a href="register.html">Register</a></li>
        <li><a href="#">My Orders</a></li>
        <li><a href="#">Wishlist</a></li>
        <li><a href="#">Track Delivery</a></li>
      </ul>
    </div>
    <div>
      <p class="footer-col-title">Help</p>
      <ul class="footer-links">
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">FAQs</a></li>
        <li><a href="#">Shipping Policy</a></li>
        <li><a href="#">Returns</a></li>
        <li><a href="#">Size Guide</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p class="footer-copy">© 2025 Acryluxe. All rights reserved.</p>
    <div class="footer-legal">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Use</a>
      <a href="#">Cookie Policy</a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Navbar scroll effect
  const nav = document.getElementById('mainNav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
  });
</script>
</body>
</html>

<!-- 🛍️ PRODUCTS SECTION -->
<h3 id="products" class="mb-4 text-center">Our Collection</h3>

<div class="row">

    @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">

                <!-- ✅ PRODUCT IMAGE -->
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="card-img-top"
                         style="height:200px; object-fit:cover;">
                @else
                    <img src="https://via.placeholder.com/200"
                         class="card-img-top">
                @endif

                <div class="card-body text-center d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>

                    <p class="text-muted mb-2">
                        ₹{{ $product->price }}
                    </p>

                    <p class="small text-success">
                        In Stock: {{ $product->stock }}
                    </p>

                    <!-- 🛒 ADD TO CART BUTTON -->
                    <button class="btn btn-dark mt-auto">
                        Add to Cart
                    </button>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center">
            <p>No products available right now.</p>
        </div>
    @endforelse

</div>

<!-- 📢 CALL TO ACTION -->
<div class="bg-light text-center p-5 mt-5 rounded">
    <h4>Discover Your Perfect Style</h4>
    <p>Explore our exclusive collection of acrylic bangles.</p>
    <a href="#products" class="btn btn-dark">Browse Now</a>
</div>

@endsection
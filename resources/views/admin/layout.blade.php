<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | {{ config('app.name', 'Acryluxe') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root { --ink:#1a1612; --cream:#faf7f2; --gold:#c9a96e; --gold-dark:#8c6d3f; --warm:#9c948a; --line:rgba(26,22,18,.1); --display:'Cormorant Garamond', Georgia, serif; --body:'DM Sans', sans-serif; }
        * { box-sizing:border-box; }
        body { margin:0; background:var(--cream); color:var(--ink); font-family:var(--body); font-size:.9rem; }
        .admin-shell { min-height:100vh; display:grid; grid-template-columns:250px minmax(0,1fr); }
        .admin-sidebar { padding:1.7rem 1.15rem; background:var(--ink); color:var(--cream); }
        .admin-brand { display:block; margin:0 .7rem 2.5rem; color:var(--cream); font:300 1.65rem var(--display); letter-spacing:.16em; text-decoration:none; text-transform:uppercase; }
        .admin-brand span { color:var(--gold); }
        .admin-label { margin:0 .75rem .7rem; color:rgba(250,247,242,.38); font-size:.64rem; letter-spacing:.18em; text-transform:uppercase; }
        .admin-nav { display:grid; gap:.3rem; }
        .admin-nav a { display:flex; align-items:center; gap:.65rem; padding:.75rem .8rem; border-radius:.55rem; color:rgba(250,247,242,.68); text-decoration:none; font-size:.8rem; }
        .admin-nav a:hover, .admin-nav a.active { background:rgba(201,169,110,.15); color:var(--cream); }
        .admin-nav .nav-mark { width:1.25rem; color:var(--gold); text-align:center; font-family:var(--display); font-size:1.1rem; }
        .admin-main { min-width:0; }
        .admin-topbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:1.2rem clamp(1.25rem,3vw,3rem); border-bottom:1px solid var(--line); background:rgba(250,247,242,.9); }
        .admin-topbar small { color:var(--warm); }
        .admin-content { max-width:1400px; margin:0 auto; padding:clamp(1.5rem,3vw,3rem); }
        .admin-eyebrow { margin:0 0 .5rem; color:var(--gold-dark); font-size:.68rem; letter-spacing:.2em; text-transform:uppercase; }
        .admin-title { margin:0; font:300 clamp(2.4rem,4vw,4rem)/1 var(--display); }
        .admin-muted { color:var(--warm); line-height:1.7; }
        .admin-panel { border:1px solid rgba(201,169,110,.2); border-radius:1rem; background:rgba(255,255,255,.72); box-shadow:0 15px 40px rgba(26,22,18,.04); }
        .stat-card { height:100%; padding:1.25rem; }
        .stat-label { color:var(--warm); font-size:.68rem; letter-spacing:.12em; text-transform:uppercase; }
        .stat-value { margin:.5rem 0 0; font:400 2rem var(--display); }
        .stat-note { color:var(--gold-dark); font-size:.75rem; }
        .admin-table th { color:var(--warm); font-size:.66rem; letter-spacing:.12em; text-transform:uppercase; font-weight:500; }
        .admin-table td, .admin-table th { padding:1rem; border-color:var(--line); vertical-align:middle; }
        .admin-table a { color:var(--gold-dark); text-decoration:none; }
        .admin-table a:hover { color:var(--ink); }
        .admin-button { border:1px solid var(--gold); background:var(--gold); color:var(--cream); padding:.7rem 1rem; font-size:.7rem; letter-spacing:.1em; text-transform:uppercase; text-decoration:none; }
        .admin-button:hover { background:var(--gold-dark); border-color:var(--gold-dark); color:var(--cream); }
        .admin-button.secondary { border-color:var(--line); background:transparent; color:var(--ink); }
        .admin-button.secondary:hover { background:var(--ink); color:var(--cream); }
        .status-pill { display:inline-block; padding:.3rem .55rem; border-radius:99px; background:rgba(201,169,110,.16); color:var(--gold-dark); font-size:.66rem; letter-spacing:.08em; text-transform:uppercase; }
        .alert { border-radius:.6rem; }
        @media (max-width:900px) { .admin-shell { display:block; } .admin-sidebar { padding:1rem; } .admin-brand { margin-bottom:1rem; } .admin-nav { display:flex; overflow-x:auto; padding-bottom:.2rem; } .admin-nav a { white-space:nowrap; } .admin-label { display:none; } }
    </style>
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}">Acr<span>y</span>luxe</a>
        <p class="admin-label">Workspace</p>
        <nav class="admin-nav">
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="nav-mark">+</span>Overview</a>
            <a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><span class="nav-mark">@</span>Customers</a>
            <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><span class="nav-mark">#</span>Products</a>
            <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><span class="nav-mark">=</span>Orders</a>
            <a class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}"><span class="nav-mark">&gt;</span>Reports</a>
            <a class="{{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}" href="{{ route('admin.site-settings.edit') }}"><span class="nav-mark">*</span>Site content</a>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <small>Admin workspace / @yield('section', 'Overview')</small>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="admin-button secondary">View storefront</a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">@csrf<button type="submit" class="admin-button secondary">Sign out</button></form>
            </div>
        </header>
        <main class="admin-content">
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
            @if($errors->any()) <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            @yield('content')
        </main>
    </div>
</div>
@if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080">
        <div id="adminSuccessToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        bootstrap.Toast.getOrCreateInstance(document.getElementById('adminSuccessToast'), { delay: 3500 }).show();
    </script>
@endif
</body>
</html>

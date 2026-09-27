<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin sign in | {{ config('app.name', 'Acryluxe') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#1a1612; --cream:#faf7f2; --gold:#c9a96e; --gold-dark:#8c6d3f; --warm:#9c948a; --display:'Cormorant Garamond', Georgia, serif; --body:'DM Sans', sans-serif; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; display:grid; place-items:center; background:var(--cream); color:var(--ink); font-family:var(--body); }
        body::before { content:''; position:fixed; inset:0; pointer-events:none; opacity:.3; background-image:radial-gradient(rgba(26,22,18,.12) .6px, transparent .6px); background-size:8px 8px; }
        .login-shell { position:relative; z-index:1; display:grid; grid-template-columns:minmax(280px,.8fr) minmax(320px,1fr); width:min(900px, calc(100% - 2rem)); min-height:560px; overflow:hidden; border:1px solid rgba(201,169,110,.25); box-shadow:0 24px 80px rgba(26,22,18,.1); }
        .login-art { display:flex; flex-direction:column; justify-content:space-between; padding:2rem; background:var(--ink); color:var(--cream); }
        .brand { color:var(--cream); text-decoration:none; font:300 1.55rem var(--display); letter-spacing:.18em; text-transform:uppercase; }
        .brand span, em { color:var(--gold); }
        .art-copy { margin:auto 0; }
        .art-copy h1 { margin:0; font:300 clamp(2.8rem,5vw,4.5rem)/.95 var(--display); }
        .art-copy p { max-width:18rem; color:rgba(250,247,242,.55); line-height:1.7; }
        .art-note { color:rgba(250,247,242,.38); font-size:.7rem; letter-spacing:.1em; text-transform:uppercase; }
        .login-form { display:flex; align-items:center; padding:3rem clamp(2rem,5vw,4rem); background:rgba(255,255,255,.55); }
        .form-inner { width:100%; max-width:360px; margin:auto; }
        .eyebrow { margin:0 0 .65rem; color:var(--gold-dark); font-size:.68rem; letter-spacing:.2em; text-transform:uppercase; }
        h2 { margin:0; font:300 2.8rem/1 var(--display); }
        .sub { margin:.75rem 0 2rem; color:var(--warm); line-height:1.6; }
        label { display:block; margin:1.25rem 0 .45rem; color:var(--warm); font-size:.7rem; letter-spacing:.12em; text-transform:uppercase; }
        input { width:100%; padding:.8rem 0; border:0; border-bottom:1px solid rgba(26,22,18,.2); outline:0; background:transparent; color:var(--ink); font:300 .95rem var(--body); }
        input:focus { border-color:var(--gold); }
        .remember { display:flex; align-items:center; gap:.5rem; margin:1.2rem 0; color:var(--warm); font-size:.8rem; }
        .remember input { width:auto; accent-color:var(--gold); }
        .submit { width:100%; margin-top:1rem; padding:1rem; border:1px solid var(--gold); background:var(--gold); color:var(--cream); cursor:pointer; font:500 .72rem var(--body); letter-spacing:.14em; text-transform:uppercase; }
        .submit:hover { background:var(--gold-dark); border-color:var(--gold-dark); }
        .error { padding:.75rem; border:1px solid rgba(138,86,52,.28); color:#8a5634; font-size:.8rem; }
        .back { display:inline-block; margin-top:1.5rem; color:var(--gold-dark); font-size:.78rem; text-decoration:none; }
        .back:hover { text-decoration:underline; }
        @media (max-width:700px) { .login-shell { display:block; } .login-art { min-height:220px; } .art-copy { margin:2rem 0 0; } .login-form { min-height:420px; } }
    </style>
</head>
<body>
<div class="login-shell">
    <section class="login-art">
        <a href="{{ route('home') }}" class="brand">Acr<span>y</span>luxe</a>
        <div class="art-copy"><p class="eyebrow">Private workspace</p><h1>Shape the<br><em>storefront.</em></h1><p>Manage the collection, customers, orders, reports, and every public-facing detail.</p></div>
        <div class="art-note">Admin access only</div>
    </section>
    <section class="login-form">
        <div class="form-inner">
            <p class="eyebrow">Acryluxe administration</p>
            <h2>Admin sign in</h2>
            <p class="sub">Use your administrator credentials to enter the control room.</p>
            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf
                <label for="identifier">Admin username</label>
                <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" placeholder="admin" autocomplete="username" required autofocus>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" autocomplete="current-password" required>
                <label class="remember"><input type="checkbox" name="remember"> Remember this device</label>
                <button class="submit" type="submit">Enter admin</button>
            </form>
            <a class="back" href="{{ route('home') }}">Back to storefront</a>
        </div>
    </section>
</div>
</body>
</html>

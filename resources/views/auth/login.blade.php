<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Sign In — Acryluxe</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
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
  body {
    font-family: var(--font-body);
    font-weight: 300;
    background: var(--cream);
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

  /* ── LEFT PANEL ── */
  .auth-visual {
    background: var(--ink);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 3rem;
    min-height: 100vh;
  }
  .auth-visual::before {
    content: '';
    position: absolute;
    top: -30%; left: -20%;
    width: 600px; height: 600px;
    border: 1px solid rgba(201,169,110,0.08);
    border-radius: 50%;
  }
  .auth-visual::after {
    content: '';
    position: absolute;
    bottom: -20%; right: -20%;
    width: 500px; height: 500px;
    border: 1px solid rgba(201,169,110,0.06);
    border-radius: 50%;
  }
  .visual-logo {
    font-family: var(--font-display);
    font-size: 1.6rem;
    font-weight: 300;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--cream);
    text-decoration: none;
    position: relative; z-index: 2;
  }
  .visual-logo span { color: var(--gold); }
  .visual-center {
    position: relative; z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    padding: 4rem 0;
  }
  .visual-tagline {
    font-family: var(--font-display);
    font-size: 2.4rem;
    font-weight: 300;
    font-style: italic;
    color: var(--cream);
    text-align: center;
    line-height: 1.3;
    margin-top: 2.5rem;
  }
  .visual-tagline em { color: var(--gold); font-style: normal; }
  .visual-sub {
    font-size: 0.83rem;
    color: rgba(250,247,242,0.4);
    text-align: center;
    margin-top: 0.8rem;
    line-height: 1.7;
  }
  .visual-footer {
    font-size: 0.72rem;
    color: rgba(250,247,242,0.25);
    letter-spacing: 0.08em;
    position: relative; z-index: 2;
  }

  /* ── RIGHT PANEL ── */
  .auth-form-panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 4rem;
    background: var(--cream);
    min-height: 100vh;
  }
  .auth-form-inner {
    width: 100%;
    max-width: 400px;
    opacity: 0;
    animation: fadeUp 0.7s 0.15s forwards;
  }
  .auth-heading {
    font-family: var(--font-display);
    font-size: 2.4rem;
    font-weight: 300;
    color: var(--ink);
    line-height: 1.1;
    margin-bottom: 0.5rem;
  }
  .auth-heading em { font-style: italic; color: var(--gold); }
  .auth-sub {
    font-size: 0.85rem;
    color: var(--warm-gray);
    margin-bottom: 2.5rem;
  }
  .auth-sub a { color: var(--gold-dark); text-decoration: none; }
  .auth-sub a:hover { text-decoration: underline; }

  .form-group { margin-bottom: 1.4rem; }
  .form-label {
    display: block;
    font-size: 0.7rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--warm-gray);
    margin-bottom: 0.5rem;
    font-weight: 400;
  }
  .form-control-acryluxe {
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1.5px solid rgba(26,22,18,0.18);
    padding: 0.7rem 0;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 300;
    color: var(--ink);
    outline: none;
    transition: border-color 0.2s;
    border-radius: 0;
  }
  .form-control-acryluxe::placeholder { color: rgba(26,22,18,0.25); }
  .form-control-acryluxe:focus { border-bottom-color: var(--gold); }
  .form-control-acryluxe.is-invalid { border-bottom-color: #C0392B; }

  .form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    margin-top: -0.3rem;
  }
  .form-check-acryluxe {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
  }
  .form-check-acryluxe input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: var(--gold);
    cursor: pointer;
  }
  .form-check-acryluxe label {
    font-size: 0.78rem;
    color: var(--warm-gray);
    cursor: pointer;
  }
  .forgot-link {
    font-size: 0.78rem;
    color: var(--gold-dark);
    text-decoration: none;
    transition: color 0.2s;
  }
  .forgot-link:hover { color: var(--gold); }

  .btn-submit {
    width: 100%;
    background: var(--gold);
    color: var(--cream);
    border: 1.5px solid var(--gold);
    padding: 1rem;
    font-family: var(--font-body);
    font-size: 0.78rem;
    font-weight: 400;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.25s, border-color 0.25s;
    position: relative;
    overflow: hidden;
  }
  .btn-submit:hover { background: var(--gold-dark); border-color: var(--gold-dark); }
  .btn-submit:active { transform: scale(0.99); }

  .auth-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.75rem 0;
  }
  .auth-divider::before, .auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(26,22,18,0.1);
  }
  .auth-divider span { font-size: 0.72rem; color: var(--warm-gray); letter-spacing: 0.08em; }

  .btn-social {
    width: 100%;
    background: transparent;
    border: 1.5px solid rgba(26,22,18,0.15);
    padding: 0.85rem;
    font-family: var(--font-body);
    font-size: 0.82rem;
    font-weight: 400;
    color: var(--ink);
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
  }
  .btn-social:hover { border-color: var(--gold); background: rgba(201,169,110,0.04); }

  .auth-signup-cta {
    text-align: center;
    margin-top: 2.5rem;
    font-size: 0.82rem;
    color: var(--warm-gray);
  }
  .auth-signup-cta a { color: var(--gold-dark); text-decoration: none; font-weight: 400; }
  .auth-signup-cta a:hover { text-decoration: underline; }

  /* Error state */
  .form-error {
    display: none;
    font-size: 0.75rem;
    color: #C0392B;
    margin-top: 0.35rem;
  }
  .form-control-acryluxe.is-invalid + .form-error { display: block; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 767px) {
    body { grid-template-columns: 1fr; }
    .auth-visual { display: none; }
    .auth-form-panel { padding: 2.5rem 1.75rem; align-items: flex-start; padding-top: 3.5rem; }
  }
</style>
</head>
<body>

<!-- LEFT: Visual Panel -->
<div class="auth-visual">
  <a href="/" class="visual-logo">Acr<span>y</span>luxe</a>
  <div class="visual-center">
    <svg width="200" height="180" viewBox="0 0 200 180" fill="none" xmlns="http://www.w3.org/2000/svg">
      <ellipse cx="100" cy="130" rx="82" ry="24" stroke="#C9A96E" stroke-width="18" opacity="0.2"/>
      <ellipse cx="100" cy="112" rx="78" ry="22" stroke="#E8D5B0" stroke-width="16" opacity="0.3"/>
      <ellipse cx="100" cy="96" rx="74" ry="21" stroke="#C9A96E" stroke-width="20" opacity="0.55"/>
      <ellipse cx="100" cy="80" rx="70" ry="19" stroke="#E8A090" stroke-width="18" opacity="0.65"/>
      <ellipse cx="100" cy="64" rx="66" ry="18" stroke="#90B8D8" stroke-width="20" opacity="0.75"/>
      <ellipse cx="100" cy="48" rx="62" ry="17" stroke="#C9A96E" stroke-width="22" opacity="0.95"/>
      <path d="M42 46 Q100 24 158 46" stroke="rgba(255,255,255,0.3)" stroke-width="2.5" stroke-linecap="round"/>
      <circle cx="48" cy="44" r="3.5" fill="#E8D5B0" opacity="0.8"/>
      <circle cx="152" cy="44" r="3.5" fill="#E8D5B0" opacity="0.8"/>
    </svg>
    <p class="visual-tagline">Welcome<br><em>Back</em></p>
    <p class="visual-sub">Sign in to explore our latest<br>collections &amp; track your orders.</p>
  </div>
  <p class="visual-footer">© 2025 Acryluxe · Handcrafted in India</p>
</div>

<!-- RIGHT: Form Panel -->
<div class="auth-form-panel">
  <div class="auth-form-inner">
    <h1 class="auth-heading">Sign <em>in</em></h1>
    <p class="auth-sub">New to Acryluxe? <a href="{{ route('register') }}">Create an account →</a></p>

    @if ($errors->any())
    <div class="alert alert-danger mb-3">
      <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

     @if (session('status')) 
    <div class="alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
      @csrf
      @if($backurl)
        <input type="hidden" name="backurl" value="{{ $backurl }}">
      @endif

      <div class="form-group">
        <label class="form-label" for="email">Email address</label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          class="form-control-acryluxe @error('email') is-invalid @enderror"
          placeholder="you@example.com"
          autocomplete="email"
          required
        />
        @error('email') 
        <p class="form-error" id="emailError">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div style="position:relative;">
          <input
            type="password"
            id="password"
            name="password"
            class="form-control-acryluxe @error('email') is-invalid @enderror"
            placeholder="Your password"
            autocomplete="current-password"
            required
            style="padding-right:2.5rem;"
          />
          <button type="button" id="togglePwd" style="position:absolute;right:0;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:var(--warm-gray);" aria-label="Toggle password visibility">
            <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
        <p class="form-error" id="pwdError">Password is required.</p>
      </div>

      <div class="form-options">
        <label class="form-check-acryluxe">
          <input type="checkbox" name="remember" id="remember"/>
          <label for="remember">Remember me</label>
        </label>
        <a href="/forgot-password" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" class="btn-submit">Sign In</button>
    </form>

    <div class="auth-divider"><span>or continue with</span></div>

    <button class="btn-social" type="button">
      <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
      Continue with Google
    </button>

    <p class="auth-signup-cta">
      Don't have an account? <a href="{{ route('register') }}">Register for free</a>
    </p>
  </div>
</div>

<script>
  // Toggle password visibility
  const togglePwd = document.getElementById('togglePwd');
  const pwdInput  = document.getElementById('password');
  togglePwd.addEventListener('click', () => {
    const isText = pwdInput.type === 'text';
    pwdInput.type = isText ? 'password' : 'text';
    togglePwd.querySelector('svg').style.opacity = isText ? '1' : '0.45';
  });

  // Client-side validation preview (server does real validation)
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    let valid = true;
    const email = document.getElementById('email');
    const pwd   = document.getElementById('password');

    if (!email.value || !/\S+@\S+\.\S+/.test(email.value)) {
      email.classList.add('is-invalid');
      valid = false;
    } else { email.classList.remove('is-invalid'); }

    if (!pwd.value) {
      pwd.classList.add('is-invalid');
      valid = false;
    } else { pwd.classList.remove('is-invalid'); }

    if (!valid) e.preventDefault();
  });
</script>
</body>
</html>

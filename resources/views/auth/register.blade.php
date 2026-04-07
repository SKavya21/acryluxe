<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Create Account — Acryluxe</title>
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

  /* ── LEFT: Form ── */
  .auth-form-panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 4rem;
    min-height: 100vh;
    overflow-y: auto;
  }
  .auth-form-inner {
    width: 100%;
    max-width: 420px;
    padding: 0.5rem 0 2rem;
    opacity: 0;
    animation: fadeUp 0.7s 0.1s forwards;
  }
  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--warm-gray);
    text-decoration: none;
    margin-bottom: 2.5rem;
    transition: color 0.2s;
  }
  .back-link:hover { color: var(--gold-dark); }
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

  /* Step indicator */
  .step-indicator {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 2.5rem;
  }
  .step-dot {
    width: 28px; height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    font-weight: 400;
    letter-spacing: 0;
    transition: all 0.3s;
    flex-shrink: 0;
  }
  .step-dot.active { background: var(--gold); color: var(--cream); }
  .step-dot.done { background: var(--ink); color: var(--cream); }
  .step-dot.inactive { background: transparent; border: 1.5px solid rgba(26,22,18,0.2); color: var(--warm-gray); }
  .step-line { flex: 1; height: 1px; background: rgba(26,22,18,0.12); margin: 0 0.5rem; }
  .step-line.done { background: var(--gold); }
  .step-label-row {
    display: flex;
    justify-content: space-between;
    margin-top: 0.5rem;
    margin-bottom: 2rem;
  }
  .step-label {
    font-size: 0.65rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--warm-gray);
    text-align: center;
    flex: 1;
  }
  .step-label.active { color: var(--gold-dark); }

  .form-group { margin-bottom: 1.4rem; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
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

  .form-error {
    display: none;
    font-size: 0.72rem;
    color: #C0392B;
    margin-top: 0.3rem;
  }
  .form-control-acryluxe.is-invalid + .form-error,
  .is-invalid ~ .form-error { display: block; }

  /* Password strength */
  .pwd-strength-bar {
    display: flex;
    gap: 4px;
    margin-top: 0.6rem;
  }
  .pwd-seg {
    flex: 1;
    height: 3px;
    background: rgba(26,22,18,0.1);
    border-radius: 2px;
    transition: background 0.3s;
  }
  .pwd-seg.weak   { background: #C0392B; }
  .pwd-seg.fair   { background: #E67E22; }
  .pwd-seg.strong { background: #27AE60; }
  .pwd-hint {
    font-size: 0.72rem;
    color: var(--warm-gray);
    margin-top: 0.35rem;
  }

  /* Phone with country code */
  .phone-wrap { display: flex; gap: 0; }
  .phone-code {
    background: transparent;
    border: none;
    border-bottom: 1.5px solid rgba(26,22,18,0.18);
    padding: 0.7rem 0.75rem 0.7rem 0;
    font-family: var(--font-body);
    font-size: 0.9rem;
    font-weight: 300;
    color: var(--ink);
    outline: none;
    cursor: pointer;
    width: 68px;
    flex-shrink: 0;
    transition: border-color 0.2s;
  }
  .phone-code:focus { border-bottom-color: var(--gold); }

  /* Terms checkbox */
  .terms-check {
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;
    margin-bottom: 2rem;
    margin-top: 0.5rem;
  }
  .terms-check input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: var(--gold);
    cursor: pointer;
    margin-top: 2px;
    flex-shrink: 0;
  }
  .terms-check label {
    font-size: 0.8rem;
    color: var(--warm-gray);
    line-height: 1.6;
    cursor: pointer;
  }
  .terms-check label a { color: var(--gold-dark); text-decoration: none; }
  .terms-check label a:hover { text-decoration: underline; }

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
  }
  .btn-submit:hover { background: var(--gold-dark); border-color: var(--gold-dark); }

  .auth-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.75rem 0;
  }
  .auth-divider::before, .auth-divider::after {
    content: ''; flex: 1; height: 1px; background: rgba(26,22,18,0.1);
  }
  .auth-divider span { font-size: 0.72rem; color: var(--warm-gray); }

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

  /* ── RIGHT: Visual ── */
  .auth-visual {
    background: var(--blush);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 4rem 3rem;
    min-height: 100vh;
  }
  .auth-visual::before {
    content: '';
    position: absolute;
    top: 10%; right: -15%;
    width: 500px; height: 500px;
    border: 1px solid rgba(201,169,110,0.2);
    border-radius: 50%;
  }
  .auth-visual::after {
    content: '';
    position: absolute;
    bottom: 5%; left: -20%;
    width: 400px; height: 400px;
    border: 1px solid rgba(201,169,110,0.15);
    border-radius: 50%;
  }
  .visual-content { position: relative; z-index: 2; text-align: center; }
  .visual-tagline {
    font-family: var(--font-display);
    font-size: 2.2rem;
    font-weight: 300;
    font-style: italic;
    color: var(--ink);
    line-height: 1.3;
    margin-top: 2rem;
  }
  .visual-tagline em { color: var(--gold); font-style: normal; }
  .visual-perks {
    margin-top: 2.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    text-align: left;
  }
  .perk-item { display: flex; align-items: flex-start; gap: 1rem; }
  .perk-icon {
    width: 32px; height: 32px;
    background: var(--gold);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .perk-text-title {
    font-family: var(--font-display);
    font-size: 0.95rem;
    font-weight: 400;
    color: var(--ink);
    margin-bottom: 0.15rem;
  }
  .perk-text-sub {
    font-size: 0.78rem;
    color: var(--warm-gray);
    line-height: 1.5;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 767px) {
    body { grid-template-columns: 1fr; }
    .auth-visual { display: none; }
    .auth-form-panel { padding: 2.5rem 1.75rem; align-items: flex-start; }
    .form-row { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>

<!-- LEFT: Registration Form -->
<div class="auth-form-panel">
  <div class="auth-form-inner">

    <a href="acryluxe_landing.html" class="back-link">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
      Back to home
    </a>

    <h1 class="auth-heading">Create<br><em>Account</em></h1>
    <p class="auth-sub">Already have an account? <a href="acryluxe_login.html">Sign in →</a></p>

    <!-- Step indicator -->
    <div class="step-indicator">
      <div class="step-dot active" id="s1">1</div>
      <div class="step-line" id="line1"></div>
      <div class="step-dot inactive" id="s2">2</div>
      <div class="step-line" id="line2"></div>
      <div class="step-dot inactive" id="s3">3</div>
    </div>
    <div class="step-label-row">
      <span class="step-label active" id="sl1">Your info</span>
      <span class="step-label" id="sl2">Contact</span>
      <span class="step-label" id="sl3">Password</span>
    </div>

    <form method="POST" action="/register" id="registerForm" novalidate>
      <!-- @csrf -->

      <!-- STEP 1: Basic info -->
      <div id="step1">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="first_name">First name</label>
            <input type="text" id="first_name" name="first_name" class="form-control-acryluxe" placeholder="Priya" required/>
            <p class="form-error">First name is required.</p>
          </div>
          <div class="form-group">
            <label class="form-label" for="last_name">Last name</label>
            <input type="text" id="last_name" name="last_name" class="form-control-acryluxe" placeholder="Sharma" required/>
            <p class="form-error">Last name is required.</p>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Email address</label>
          <input type="email" id="email" name="email" class="form-control-acryluxe" placeholder="priya@example.com" required/>
          <p class="form-error">Please enter a valid email address.</p>
        </div>
        <button type="button" class="btn-submit" onclick="goStep(2)">Continue →</button>
      </div>

      <!-- STEP 2: Contact -->
      <div id="step2" style="display:none;">
        <div class="form-group">
          <label class="form-label" for="phone">Mobile number</label>
          <div class="phone-wrap">
            <select class="phone-code" name="phone_code">
              <option value="+91">🇮🇳 +91</option>
              <option value="+1">🇺🇸 +1</option>
              <option value="+44">🇬🇧 +44</option>
            </select>
            <input type="tel" id="phone" name="phone" class="form-control-acryluxe" placeholder="98765 43210" required style="flex:1;"/>
          </div>
          <p class="form-error" id="phoneError">Please enter a valid mobile number.</p>
        </div>
        <div class="form-group">
          <label class="form-label" for="city">City</label>
          <input type="text" id="city" name="city" class="form-control-acryluxe" placeholder="Ahmedabad"/>
        </div>
        <div class="form-group">
          <label class="form-label" for="pincode">PIN code</label>
          <input type="text" id="pincode" name="pincode" class="form-control-acryluxe" placeholder="380001" maxlength="6"/>
        </div>
        <div style="display:flex; gap:1rem;">
          <button type="button" class="btn-submit" style="background:transparent;color:var(--ink);border-color:rgba(26,22,18,0.2);flex:0 0 auto;width:auto;padding:1rem 1.5rem;" onclick="goStep(1)">← Back</button>
          <button type="button" class="btn-submit" style="flex:1;" onclick="goStep(3)">Continue →</button>
        </div>
      </div>

      <!-- STEP 3: Password -->
      <div id="step3" style="display:none;">
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <div style="position:relative;">
            <input type="password" id="password" name="password" class="form-control-acryluxe" placeholder="Min. 8 characters" required oninput="checkStrength(this.value)" style="padding-right:2.5rem;"/>
            <button type="button" id="togglePwd" style="position:absolute;right:0;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:var(--warm-gray);" aria-label="Toggle visibility">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <div class="pwd-strength-bar">
            <div class="pwd-seg" id="seg1"></div>
            <div class="pwd-seg" id="seg2"></div>
            <div class="pwd-seg" id="seg3"></div>
            <div class="pwd-seg" id="seg4"></div>
          </div>
          <p class="pwd-hint" id="pwdHint">Use 8+ characters with letters and numbers.</p>
          <p class="form-error" id="pwdError">Password must be at least 8 characters.</p>
        </div>
        <div class="form-group">
          <label class="form-label" for="password_confirmation">Confirm password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-acryluxe" placeholder="Repeat password" required/>
          <p class="form-error" id="pwdConfirmError">Passwords do not match.</p>
        </div>

        <div class="terms-check">
          <input type="checkbox" id="terms" name="terms" required/>
          <label for="terms">
            I agree to the <a href="#">Terms &amp; Conditions</a> and <a href="#">Privacy Policy</a> of Acryluxe.
          </label>
        </div>

        <div style="display:flex; gap:1rem;">
          <button type="button" class="btn-submit" style="background:transparent;color:var(--ink);border-color:rgba(26,22,18,0.2);flex:0 0 auto;width:auto;padding:1rem 1.5rem;" onclick="goStep(2)">← Back</button>
          <button type="submit" class="btn-submit" style="flex:1;">Create Account</button>
        </div>
      </div>

    </form>

    <div class="auth-divider"><span>or register with</span></div>
    <button class="btn-social" type="button">
      <svg width="18" height="18" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
      Continue with Google
    </button>
  </div>
</div>

<!-- RIGHT: Visual Panel -->
<div class="auth-visual">
  <div class="visual-content">
    <svg width="180" height="160" viewBox="0 0 180 160" fill="none" xmlns="http://www.w3.org/2000/svg">
      <ellipse cx="90" cy="120" rx="74" ry="22" stroke="#C9A96E" stroke-width="18" opacity="0.2"/>
      <ellipse cx="90" cy="102" rx="70" ry="20" stroke="#E8D5B0" stroke-width="15" opacity="0.35"/>
      <ellipse cx="90" cy="85"  rx="66" ry="18" stroke="#E8A090" stroke-width="18" opacity="0.6"/>
      <ellipse cx="90" cy="68"  rx="62" ry="17" stroke="#C9A96E" stroke-width="20" opacity="0.8"/>
      <ellipse cx="90" cy="52"  rx="58" ry="15" stroke="#7EC8A4" stroke-width="18" opacity="0.75"/>
      <ellipse cx="90" cy="37"  rx="54" ry="14" stroke="#C9A96E" stroke-width="22" opacity="0.95"/>
      <path d="M38 35 Q90 14 142 35" stroke="rgba(255,255,255,0.5)" stroke-width="2.5" stroke-linecap="round"/>
    </svg>
    <p class="visual-tagline">Join the<br><em>Acryluxe</em><br>family</p>
    <div class="visual-perks">
      <div class="perk-item">
        <div class="perk-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
          <p class="perk-text-title">Exclusive member offers</p>
          <p class="perk-text-sub">Get early access to new drops and flash sales.</p>
        </div>
      </div>
      <div class="perk-item">
        <div class="perk-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <p class="perk-text-title">Order tracking</p>
          <p class="perk-text-sub">Real-time delivery updates to your doorstep.</p>
        </div>
      </div>
      <div class="perk-item">
        <div class="perk-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <div>
          <p class="perk-text-title">Wishlist &amp; saved items</p>
          <p class="perk-text-sub">Save your favourite pieces and shop later.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Step navigation
  function goStep(n) {
    for (let i = 1; i <= 3; i++) {
      document.getElementById('step' + i).style.display = i === n ? 'block' : 'none';
      const dot = document.getElementById('s' + i);
      const lbl = document.getElementById('sl' + i);
      dot.className = 'step-dot ' + (i < n ? 'done' : i === n ? 'active' : 'inactive');
      lbl.className = 'step-label ' + (i === n ? 'active' : '');
    }
    document.getElementById('line1').className = 'step-line' + (n > 1 ? ' done' : '');
    document.getElementById('line2').className = 'step-line' + (n > 2 ? ' done' : '');
  }

  // Password strength checker
  function checkStrength(val) {
    const segs = [document.getElementById('seg1'),document.getElementById('seg2'),document.getElementById('seg3'),document.getElementById('seg4')];
    const hint = document.getElementById('pwdHint');
    segs.forEach(s => { s.className = 'pwd-seg'; });
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const cls = score <= 1 ? 'weak' : score <= 2 ? 'fair' : 'strong';
    const labels = ['', 'Weak', 'Fair', 'Strong', 'Very strong'];
    hint.textContent = val.length ? labels[score] : 'Use 8+ characters with letters and numbers.';
    hint.style.color = score <= 1 ? '#C0392B' : score <= 2 ? '#E67E22' : '#27AE60';
    for (let i = 0; i < score; i++) segs[i].classList.add(cls);
  }

  // Toggle password
  document.getElementById('togglePwd').addEventListener('click', function() {
    const p = document.getElementById('password');
    p.type = p.type === 'password' ? 'text' : 'password';
  });

  // Form submit validation
  document.getElementById('registerForm').addEventListener('submit', function(e) {
    const pwd = document.getElementById('password');
    const conf = document.getElementById('password_confirmation');
    let valid = true;
    if (pwd.value.length < 8) {
      pwd.classList.add('is-invalid');
      valid = false;
    } else { pwd.classList.remove('is-invalid'); }
    if (pwd.value !== conf.value) {
      conf.classList.add('is-invalid');
      document.getElementById('pwdConfirmError').style.display = 'block';
      valid = false;
    } else {
      conf.classList.remove('is-invalid');
      document.getElementById('pwdConfirmError').style.display = 'none';
    }
    if (!document.getElementById('terms').checked) {
      valid = false;
      alert('Please accept the Terms & Conditions to continue.');
    }
    if (!valid) e.preventDefault();
  });
</script>
</body>
</html>

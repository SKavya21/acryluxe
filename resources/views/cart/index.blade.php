<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Cart | Acryluxe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --gold:#c9a96e; --gold-dark:#8c6d3f; --ink:#1a1612; --cream:#faf7f2; --warm-gray:#9c948a; --blush:#f2e8df; --line:rgba(26,22,18,.11); --display:'Cormorant Garamond', Georgia, serif; --body:'DM Sans', sans-serif; }
        *,*::before,*::after { box-sizing:border-box; }
        body { margin:0; color:var(--ink); background:var(--cream); font-family:var(--body); font-weight:300; }
        body::before { content:''; position:fixed; inset:0; pointer-events:none; opacity:.3; background-image:radial-gradient(rgba(26,22,18,.12) .6px, transparent .6px); background-size:8px 8px; }
        a { color:inherit; }
        .shell { position:relative; z-index:1; min-height:100vh; }
        .nav { position:sticky; top:0; z-index:5; display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:1.15rem clamp(1rem,4vw,3rem); background:rgba(250,247,242,.93); border-bottom:1px solid rgba(201,169,110,.2); backdrop-filter:blur(14px); }
        .logo { font-family:var(--display); font-size:1.55rem; letter-spacing:.18em; text-transform:uppercase; text-decoration:none; }
        .logo span { color:var(--gold); }
        .nav-links { display:flex; align-items:center; gap:1rem; font-size:.72rem; letter-spacing:.14em; text-transform:uppercase; }
        .nav-links a { text-decoration:none; color:var(--warm-gray); }
        .nav-links a:hover { color:var(--ink); }
        .cart-count { display:inline-grid; place-items:center; min-width:1.35rem; height:1.35rem; margin-left:.25rem; padding:0 .3rem; border-radius:50%; background:var(--gold); color:var(--cream); font-size:.65rem; }
        .page { max-width:1180px; margin:0 auto; padding:4.5rem 1.25rem 4rem; }
        .eyebrow { margin:0 0 .7rem; color:var(--gold-dark); font-size:.7rem; letter-spacing:.22em; text-transform:uppercase; }
        h1,h2 { font-family:var(--display); font-weight:300; line-height:1; }
        h1 { margin:0; font-size:clamp(3rem,6vw,5rem); }
        h2 { margin:0; font-size:2rem; }
        .intro { display:flex; align-items:end; justify-content:space-between; gap:1rem; margin-bottom:2rem; }
        .intro-copy { max-width:33rem; margin:.8rem 0 0; color:var(--warm-gray); line-height:1.7; }
        .button { display:inline-flex; align-items:center; justify-content:center; padding:.75rem 1rem; border:1px solid var(--line); background:transparent; color:var(--ink); font:500 .7rem var(--body); letter-spacing:.12em; text-transform:uppercase; text-decoration:none; cursor:pointer; transition:transform .2s, background .2s, color .2s; }
        .button:hover { transform:translateY(-1px); background:var(--ink); color:var(--cream); }
        .button.primary { border-color:var(--gold); background:var(--gold); color:var(--cream); }
        .button.primary:hover { background:var(--gold-dark); }
        .button.danger { color:#8a5634; border-color:rgba(138,86,52,.25); }
        .notice { margin-bottom:1.5rem; padding:1rem 1.1rem; border:1px solid var(--line); background:#fff; color:var(--warm-gray); }
        .notice.success { border-color:rgba(102,137,102,.28); color:#557255; }
        .notice.error { border-color:rgba(138,86,52,.3); color:#8a5634; }
        .cart-layout { display:grid; grid-template-columns:minmax(0,1.55fr) minmax(280px,.8fr); gap:1.5rem; align-items:start; }
        .panel { border:1px solid rgba(201,169,110,.22); border-radius:1.35rem; background:rgba(255,255,255,.7); box-shadow:0 18px 50px rgba(26,22,18,.05); }
        .items-panel { padding:1.4rem; }
        .item { display:grid; grid-template-columns:86px minmax(0,1fr) auto; gap:1rem; align-items:center; padding:1rem 0; border-bottom:1px solid var(--line); }
        .item:first-child { padding-top:0; }
        .item:last-child { padding-bottom:0; border-bottom:0; }
        .item-media { position:relative; width:86px; aspect-ratio:1; display:grid; place-items:center; overflow:hidden; border-radius:1rem; background:linear-gradient(145deg,#f5e5d8,#ead5c5); }
        .item-media img { width:100%; height:100%; object-fit:cover; }
        .item-fallback { width:56px; height:30px; border:9px solid #d39a83; border-radius:50%; transform:rotateX(62deg) rotateZ(-12deg); box-shadow:16px -7px 0 -2px #d5b460; }
        .item-name { margin:0 0 .35rem; font:400 1.35rem var(--display); }
        .item-meta { margin:0; color:var(--warm-gray); font-size:.72rem; letter-spacing:.08em; text-transform:uppercase; }
        .item-price { margin-top:.55rem; color:var(--gold-dark); font:400 1.1rem var(--display); }
        .item-controls { display:flex; align-items:center; gap:.75rem; }
        .quantity-form { display:flex; align-items:center; gap:.45rem; }
        .quantity { width:62px; padding:.55rem .35rem; border:1px solid var(--line); background:transparent; color:var(--ink); text-align:center; font:400 .85rem var(--body); }
        .quantity[readonly] { border-color:transparent; pointer-events:none; }
        .mini-button { display:inline-grid; place-items:center; width:32px; height:32px; padding:0; border:1px solid var(--line); border-radius:50%; background:transparent; color:var(--ink); cursor:pointer; transition:background .2s, color .2s, transform .2s; }
        .mini-button:hover { background:var(--ink); color:var(--cream); transform:translateY(-1px); }
        .mini-button.is-saving { pointer-events:none; opacity:.7; }
        .mini-button svg { width:14px; height:14px; }
        .save-icon { display:none; }
        .save-spinner { display:none; width:13px; height:13px; border:1.5px solid currentColor; border-top-color:transparent; border-radius:50%; animation:spin .7s linear infinite; }
        .mini-button.is-saving .save-spinner { display:block; }
        .summary-value { transition:color .2s, transform .2s; }
        .summary-value.is-refreshing { color:var(--gold-light); transform:translateX(-2px); }
        @keyframes spin { to { transform:rotate(360deg); } }
        .line-total { min-width:6rem; text-align:right; font:400 1.25rem var(--display); }
        .remove { display:block; margin-top:.4rem; padding:0; border:0; background:none; color:var(--warm-gray); font:500 .62rem var(--body); letter-spacing:.1em; text-transform:uppercase; cursor:pointer; }
        .remove:hover { color:#8a5634; }
        .summary { position:sticky; top:5.5rem; padding:1.5rem; background:var(--ink); color:var(--cream); }
        .summary .eyebrow { color:var(--gold-light); }
        .summary h2 { margin-bottom:1.5rem; }
        .summary-row { display:flex; justify-content:space-between; gap:1rem; padding:.7rem 0; color:rgba(250,247,242,.68); font-size:.85rem; }
        .summary-row.total { margin-top:.7rem; padding-top:1rem; border-top:1px solid rgba(201,169,110,.28); color:var(--cream); font:400 1.45rem var(--display); }
        .summary select { width:100%; margin-top:.35rem; padding:.8rem; border:1px solid rgba(250,247,242,.25); background:#29221b; color:var(--cream); font:300 .82rem var(--body); }
        .summary .button { width:100%; margin-top:1.25rem; }
        .summary-note { margin:1rem 0 0; color:rgba(250,247,242,.45); font-size:.75rem; line-height:1.6; }
        .empty { padding:4rem 1.5rem; text-align:center; }
        .empty p { margin:1rem auto 1.5rem; max-width:28rem; color:var(--warm-gray); line-height:1.7; }
        @media (max-width:760px) { .nav { align-items:flex-start; flex-direction:column; } .nav-links { width:100%; justify-content:space-between; } .page { padding-top:3rem; } .intro { align-items:flex-start; flex-direction:column; } .cart-layout { grid-template-columns:1fr; } .summary { position:static; } .item { grid-template-columns:70px minmax(0,1fr); } .item-media { width:70px; } .item-controls { grid-column:2; justify-content:space-between; } .line-total { min-width:0; } }
    </style>
</head>
<body>
<div class="shell">
    <nav class="nav">
        <a href="{{ route('home') }}" class="logo">Acr<span>y</span>luxe</a>
        <div class="nav-links">
            <a href="{{ route('home') }}#products">Continue shopping</a>
            @auth
                <a href="{{ route('profile.edit') }}">My account</a>
            @else
                <a href="{{ route('login') }}">Sign in</a>
            @endauth
            <a href="{{ route('cart.index') }}">Bag <span class="cart-count">{{ $items->sum('quantity') }}</span></a>
        </div>
    </nav>

    <main class="page">
        @if (session('success')) <div class="notice success">{{ session('success') }}</div> @endif
        @if (session('error')) <div class="notice error">{{ session('error') }}</div> @endif

        <div class="intro">
            <div>
                <p class="eyebrow">Your edit</p>
                <h1>Your bag</h1>
                <p class="intro-copy">Pieces selected for your everyday stack. Review your order before it makes its way to you.</p>
            </div>
            @if($items->isNotEmpty())
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="button danger">Clear bag</button>
                </form>
            @endif
        </div>

        @if($items->isEmpty())
            <section class="panel empty">
                <p class="eyebrow">Nothing here yet</p>
                <h2>Your bag is waiting.</h2>
                <p>Browse the collection and find a little colour for your wrist.</p>
                <a href="{{ route('home') }}#products" class="button primary">Browse the collection</a>
            </section>
        @else
            <div class="cart-layout">
                <section class="panel items-panel" aria-label="Cart items">
                    @foreach($items as $item)
                        <article class="item" data-unit-price="{{ $item['product']->price }}">
                            <div class="item-media">
                                @if($item['product']->image)
                                    <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}">
                                @else
                                    <div class="item-fallback" aria-hidden="true"></div>
                                @endif
                            </div>
                            <div>
                                <h2 class="item-name">{{ $item['product']->name }}</h2>
                                <p class="item-meta">{{ $item['product']->color ?: 'Acryluxe original' }} | Size {{ $item['size'] }}</p>
                                <div class="item-price">₹{{ number_format($item['product']->price, 2) }} each</div>
                            </div>
                            <div class="item-controls">
                                <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="quantity-form">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="size" value="{{ $item['size'] }}">
                                    <input class="quantity" type="number" name="quantity" min="1" max="100" value="{{ $item['quantity'] }}" readonly aria-label="Quantity for {{ $item['product']->name }}">
                                    <button class="mini-button" type="button" aria-label="Edit quantity">
                                        <svg class="pencil-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                        </svg>
                                        <svg class="save-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="m5 12 4 4L19 6"/>
                                        </svg>
                                        <span class="save-spinner" aria-hidden="true"></span>
                                    </button>
                                </form>
                                <div class="line-total">
                                    <span class="line-total-value">₹{{ number_format($item['line_total'], 2) }}</span>
                                    <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <input type="hidden" name="size" value="{{ $item['size'] }}">
                                        <button class="remove" type="submit">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </section>

                <aside class="panel summary">
                    <p class="eyebrow">Almost yours</p>
                    <h2>Order summary</h2>
                    <div class="summary-row"><span>Subtotal</span><span class="summary-value" id="cart-subtotal" data-value="{{ $subtotal }}" aria-live="polite">₹{{ number_format($subtotal, 2) }}</span></div>
                    <div class="summary-row"><span>Shipping</span><span class="summary-value" id="cart-shipping" data-free-threshold="599" aria-live="polite">{{ $subtotal >= 599 ? 'Free' : '₹49.00' }}</span></div>
                    <div class="summary-row total"><span>Total</span><span class="summary-value" id="cart-total" aria-live="polite">₹{{ number_format($subtotal >= 599 ? $subtotal : $subtotal + 49, 2) }}</span></div>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <label for="payment_method" class="eyebrow">Payment method</label>
                        <select name="payment_method" id="payment_method">
                            <option value="cod">Cash on Delivery</option>
                            <option value="stripe">Online payment</option>
                        </select>
                        <button type="submit" class="button primary">Place order</button>
                    </form>
                    <p class="summary-note">Free shipping on orders over ₹599. Cash on delivery places your order immediately.</p>
                </aside>
            </div>
        @endif
    </main>
</div>
<script>
    (() => {
        const currency = new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const itemRows = document.querySelectorAll('.item');
        const subtotalElement = document.getElementById('cart-subtotal');
        const shippingElement = document.getElementById('cart-shipping');
        const totalElement = document.getElementById('cart-total');

        function formatPrice(value) {
            return `₹${currency.format(value)}`;
        }

        function refreshSummary() {
            let subtotal = 0;

            itemRows.forEach((row) => {
                const quantity = row.querySelector('.quantity');
                const lineTotal = row.querySelector('.line-total-value');
                const unitPrice = Number(quantity.dataset.unitPrice);
                const lineValue = Math.max(1, Number(quantity.value) || 1) * unitPrice;
                subtotal += lineValue;
                lineTotal.textContent = formatPrice(lineValue);
            });

            const shipping = subtotal >= Number(shippingElement.dataset.freeThreshold) ? 0 : 49;
            subtotalElement.dataset.value = subtotal;
            [subtotalElement, shippingElement, totalElement].forEach((element) => element.classList.add('is-refreshing'));
            subtotalElement.textContent = formatPrice(subtotal);
            shippingElement.textContent = shipping === 0 ? 'Free' : formatPrice(shipping);
            totalElement.textContent = formatPrice(subtotal + shipping);
            window.setTimeout(() => {
                [subtotalElement, shippingElement, totalElement].forEach((element) => element.classList.remove('is-refreshing'));
            }, 220);
        }

        itemRows.forEach((row) => {
            const form = row.querySelector('.quantity-form');
            const quantity = row.querySelector('.quantity');
            const editButton = row.querySelector('.mini-button');
            const pencilIcon = editButton.querySelector('.pencil-icon');
            const saveIcon = editButton.querySelector('.save-icon');
            const spinner = editButton.querySelector('.save-spinner');

            quantity.dataset.unitPrice = row.dataset.unitPrice;
            quantity.addEventListener('input', refreshSummary);

            editButton.addEventListener('click', (event) => {
                if (quantity.readOnly) {
                    event.preventDefault();
                    quantity.readOnly = false;
                    quantity.focus();
                    quantity.select();
                    pencilIcon.style.display = 'none';
                    saveIcon.style.display = 'block';
                    editButton.setAttribute('aria-label', 'Save quantity');
                    return;
                }

                refreshSummary();
                editButton.classList.add('is-saving');
                editButton.setAttribute('aria-label', 'Saving quantity');
                spinner.setAttribute('aria-label', 'Saving');
                form.submit();
            });
        });
    })();
</script>
</body>
</html>

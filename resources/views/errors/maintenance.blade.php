<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We'll be back soon | {{ config('app.name', 'Acryluxe') }}</title>
    <style>
        :root { --ink:#1a1612; --cream:#faf7f2; --gold:#c9a96e; --warm:#9c948a; }
        * { box-sizing:border-box; }
        body { display:grid; min-height:100vh; place-items:center; margin:0; padding:2rem; background:var(--cream); color:var(--ink); font-family:Georgia, serif; text-align:center; }
        main { max-width:34rem; }
        p { color:var(--warm); font:1rem/1.7 Arial, sans-serif; }
        .brand { color:var(--gold); font:1rem Arial, sans-serif; letter-spacing:.2em; text-transform:uppercase; }
    </style>
</head>
<body>
    <main>
        <div class="brand">{{ config('app.name', 'Acryluxe') }}</div>
        <h1>We’ll be back soon.</h1>
        <p>We’re performing a little maintenance and will be back shortly. Thank you for your patience.</p>
    </main>
</body>
</html>
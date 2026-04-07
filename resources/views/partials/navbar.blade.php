<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/">Acryluxe</a>

        <div class="ms-auto">

            @auth
                <span class="text-white me-2">
                    {{ auth()->user()->name }}
                </span>

                <a href="/admin/products" class="btn btn-warning btn-sm">
                    Admin
                </a>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>

            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                    Login
                </a>

                <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                    Register
                </a>
            @endauth

        </div>

    </div>
</nav>
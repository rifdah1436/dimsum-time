<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dimsum Time')</title>
    <!-- Tambahkan link CSS dan JS yang diperlukan -->
</head>
<body>
    @if(auth()->check())
        <!-- Navbar untuk user yang sudah login -->
        <nav>
            Welcome, {{ auth()->user()->nama_lengkap }}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
    @endif
    
    @yield('content')
</body>
</html>
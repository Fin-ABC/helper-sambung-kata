<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ehem, Sambung Kata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        /* Sedikit kustomisasi agar kursor berbentuk tangan saat hover kata */
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">🎮 Sambung Kata</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('admin.index') }}">⚙️ Pengaturan Admin</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

</body>

</html>

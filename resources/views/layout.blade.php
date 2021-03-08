<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'TIMOCOM' }}</title>
    <link href="{{ mix('css/main.css') }}" rel="stylesheet">
</head>
<body>
<header class="container-lg">
    <nav class="page-nav">
        <ul class="nav my-3">
            <li class="nav-item"><a href="{{route('dashboard')}}" aria-current="page" class="nav-link active">Dashboard</a></li>
            <li class="nav-item"><a href="{{route('company')}}" class="nav-link">Company info</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Email blacklist</a></li>
        </ul>
        <div class="px-3">{{ $user ?? 'LOGIN' }}</div>
    </nav>
</header>
<main class="container-lg">
    @hasSection('content')
        <div class="border border-2 rounded p-3">
            @yield('content')
        </div>
    @endif
</main>
</body>
</html>

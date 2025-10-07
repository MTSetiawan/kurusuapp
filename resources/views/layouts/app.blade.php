<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Teacher Dashboard' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
  <header class="navbar">
    <div class="nav-wrap container">
      <a href="{{ route('teacher.dashboard') }}" class="brand">Teacher</a>
      <div style="display:flex;gap:10px;align-items:center">
        <a href="{{ route('listings.create') }}" class="btn primary">+ New Listing</a>
        <a href="{{ route('teacher.profile.edit') }}">
          <img src="{{ Auth::user()->avatar_url ?? 'https://i.pravatar.cc/64' }}" alt="" style="width:36px;height:36px;border-radius:999px">
        </a>
      </div>
    </div>
  </header>
  <main class="container">
    @yield('content')
  </main>
</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salon Cantik — Sistem Manajemen</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Playfair+Display:wght@500&display=swap"
    rel="stylesheet">
</head>

<body>

  <div class="app">
    @include('partials.sidebar')

    <!-- MAIN -->
    <div class="main">
      @include('partials.topbar')

      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>

  @include('partials.modals')
  @include('partials.scripts')

</body>

</html>
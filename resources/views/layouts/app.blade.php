<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Melly Salon — Sistem Manajemen</title>
  <meta name="description" content="Sistem Manajemen Salon Kecantikan Melly Salon">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-sans flex h-screen overflow-hidden selection:bg-brand-purple selection:text-white">

  <div class="flex w-full h-full">
    @include('partials.sidebar')
    <div id="sidebar-overlay" class="sidebar-overlay" onclick="SalonApp.toggleSidebar()"></div>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
      @include('partials.topbar')

      <div class="flex-1 overflow-y-auto p-5 lg:p-8" id="main-content">
        @yield('content')
      </div>
    </div>
  </div>

  @include('partials.modals')
  @include('partials.scripts')

</body>

</html>
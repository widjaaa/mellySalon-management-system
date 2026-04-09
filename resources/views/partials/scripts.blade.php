{{--
  scripts.blade.php — Jembatan data dari Laravel ke JavaScript

  File ini HANYA bertugas mengirim data server (services, members)
  ke JavaScript modules via SalonApp.initialize().

  Semua logika JavaScript sudah dipindahkan ke:
    resources/js/modules/
      ├── state.js        → State management
      ├── utils.js        → Helper functions
      ├── api.js          → AJAX calls
      ├── navigation.js   → Navigasi halaman
      ├── dashboard.js    → Chart dashboard
      ├── payment.js      → Logika kasir
      ├── members.js      → CRUD member
      ├── services.js     → CRUD layanan
      └── reports.js      → Laporan & export
--}}

<script>
    // Kirim data dari Laravel ke JavaScript modules
    document.addEventListener('DOMContentLoaded', function () {
        window.SalonApp.initialize({
            services: @json($services),
            members: @json($members),
        });
    });
</script>

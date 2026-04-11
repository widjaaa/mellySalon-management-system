<script>
    // Kirim data dari Laravel ke JavaScript modules
    document.addEventListener('DOMContentLoaded', function () {
        window.SalonApp.initialize({
            services: @json($services),
            members: @json($members),
        });
    });
</script>
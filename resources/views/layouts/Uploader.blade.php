@php 
    $logo = App\Models\Logo::first();
@endphp

<!DOCTYPE html>
<html lang="en" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 800,
        once: true,
      });
    </script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>

    <title>paperflow9 |</title>

    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon2.ico') }}">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
        /* ================= PRELOADER ================= */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0a1a3f;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .preloader-logo {
            width: 80px;
            height: 80px;
            animation: blinkZoom 1s infinite alternate;
        }

        @keyframes blinkZoom {
            0% {
                opacity: 0.3;
                transform: scale(0.8);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
            100% {
                opacity: 0.3;
                transform: scale(0.8);
            }
        }
    </style>

</head>

<body class="min-h-screen flex flex-col">

<!-- ================= PRELOADER ================= -->
<div id="preloader">
    @if($logo && $logo->picture2)
        <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture2) }}"
             alt="logo"
             class="preloader-logo">
    @else
        <div class="text-white text-xl font-bold">Loading...</div>
    @endif
</div>

<!-- ================= NAV ================= -->
{{-- Optional navbar --}}
{{-- <x-navbar /> --}}

<!-- ================= CONTENT ================= -->
<main class="p-6">
    @yield('content')
</main>

<!-- ================= FOOTER ================= -->
{{-- Optional footer --}}
{{-- <x-footer /> --}}

<!-- ================= PRELOADER SCRIPT ================= -->
<script>
    window.addEventListener('load', function () {
        const preloader = document.getElementById('preloader');

        if (preloader) {
            preloader.style.opacity = '0';

            setTimeout(() => {
                preloader.style.display = 'none';
            }, 300);
        }
    });
</script>

</body>
</html>
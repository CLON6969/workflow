@php 
    $logo = App\Models\Logo::first(); // Changed from $icons = ... to $logo = ...
    // Set your launch date here (year, month-1, day, hour, minute, second)
    // Note: JavaScript months are 0-indexed (0 = January, 11 = December)
    $launchDate = "2026-05-10 00:00:00"; // Change this to your actual launch date
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Launch</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">

    <link href="{{ asset('/public/resources/css/loading.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Orbitron', sans-serif;
            background: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .logo {
            width: 200px;
            animation: fadeInOut 2s infinite ease-in-out;
        }

        h1 {
            margin-top: 20px;
            font-size: 2rem;
            color: #00ffcc;
        }

        .countdown-container {
            display: flex;
            gap: 30px;
            margin-top: 30px;
            text-align: center;
        }

        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .countdown-number {
            font-size: 3rem;
            font-weight: 700;
            color: #00ffcc;
        }

        .countdown-label {
            font-size: 1rem;
            color: #aaa;
            margin-top: 5px;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.1; }
            50% { opacity: 1; }
        }

        .notify-btn {
            margin-top: 30px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #00ffcc;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .notify-btn:hover {
            background-color: #00cca8;
        }
        
        .launch-message {
            display: none;
            font-size: 2.5rem;
            color: #00ffcc;
            font-weight: 700;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture2) }}" alt="logo" class="logo">
        
        <h1>Page being worked on...</h1>
        <h1>Next Launch</h1>
        
        <div class="countdown-container" id="countdown">
            <div class="countdown-item">
                <span class="countdown-number" id="days">00</span>
                <span class="countdown-label">Days</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="hours">00</span>
                <span class="countdown-label">Hours</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="minutes">00</span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="seconds">00</span>
                <span class="countdown-label">Seconds</span>
            </div>
        </div>
        
        <div class="launch-message" id="launch-message">
           Comming soon!😊
        </div>
        
        <button class="notify-btn" id="notify-btn">
           <a href="/"> HOME</a>
        </button>
    </div>

    <script>
        // Set the launch date (update this with your actual launch date)
        const launchDate = new Date('{{ $launchDate }}').getTime();

        // Update the count down every 1 second
        const x = setInterval(function() {

            // Get today's date and time
            const now = new Date().getTime();

            // Find the distance between now and the count down date
            const distance = launchDate - now;

            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the elements
            document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
            document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');

            // If the count down is finished, display a message
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").style.display = "none";
                document.getElementById("launch-message").style.display = "block";
            }
        }, 1000);
    </script>
</body>
</html>
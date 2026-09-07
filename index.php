<?php

// echo "test";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLE1 | Experimenteren</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        #map {
            height: 100%;
            width: 100%;
            z-index: 1;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: #ffffff;
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
            color: #333;
            text-decoration: none;
        }

        .nav-item i {
            font-size: 24px;
            margin-bottom: 2px;
        }

        /* Hide nav on desktop if needed, but user said "Don't need laptop support" 
           implying it's primarily for mobile. We'll keep it visible for now. */
    </style>
</head>

<body>
    <div id="map"></div>

    <nav class="bottom-nav">
        <a href="#" class="nav-item">
            <span>🏠</span>
            <span>Home</span>
        </a>
        <a href="#" class="nav-item">
            <span>🐾</span>
            <span>Animals</span>
        </a>
        <a href="#" class="nav-item">
            <span>⚠️</span>
            <span>Alerts</span>
        </a>
        <a href="#" class="nav-item">
            <span>👤</span>
            <span>Profile</span>
        </a>
    </nav>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script>
        // Initialize the map
        const map = L.map('map').setView([52.3676, 4.9041], 13); // Default to Amsterdam

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Placeholder for wild animal markers
        const animals = [{
                name: "Wild Boar",
                lat: 52.37,
                lng: 4.91,
                status: "Danger"
            },
            {
                name: "Deer",
                lat: 52.36,
                lng: 4.89,
                status: "Safe"
            }
        ];

        animals.forEach(animal => {
            L.marker([animal.lat, animal.lng]).addTo(map)
                .bindPopup(`<b>${animal.name}</b><br>Status: ${animal.status}`);
        });
    </script>
</body>

</html>
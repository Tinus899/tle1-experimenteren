<?php

// echo "test";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLE1 | Experimenteren</title>
    <link rel="stylesheet" href="./css/main.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
</head>

<body>
<div id="map"></div>

<nav class="bottom-nav">
    <a href="#" class="nav-item">
        <span>
            <img src="images/profile.svg" alt="Profile Icon">
        </span>
        <span>Profile</span>
    </a>
    <a href="#" class="nav-item right-gap">
        <span>
            <img src="images/family.svg" alt="Family Icon">
        </span>
        <span>Family</span>
    </a>
    <a href="#" class="rounded-nav-item">
        <span>
            <img src="images/map.svg" alt="Map Icon">
        </span>
        <span>Map</span>
    </a>
    <a href="#" class="nav-item left-gap">
        <span>
            <img src="images/animal-icon.svg" alt="Animal Icon">
        </span>
        <span>Animals</span>
    </a>
    <a href="#" class="nav-item">
        <span>
            <img src="images/settings.svg" alt="Settings Icon">
        </span>
        <span>Settings</span>
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
<?php

session_start();
//might need later when login page is available
//if (!isset($_SESSION['user_id'])) {
//    header("Location: login.php");
//    exit;
//}

// Connect to database
require_once 'includes/database.php';
/** @var mysqli $connection */


$query = "INSERT INTO animals (animal_type, danger_level, location, amount, reported_time)
VALUES
('Wild boar', 'dangerous', POINT(4.91, 52.37), 2, '2026-09-09 10:00:00'),
('Deer', 'safe', POINT(4.89, 52.36), 1, '2026-09-09 12:00:00')";
$result = mysqli_query($connection, $query);

$query = "SELECT
            animal_type,
            danger_level,
            ST_Y(location) AS lat,
            ST_X(location) AS lng,
            amount,
            reported_time
          FROM animals";
$result = mysqli_query($connection, $query);

$animals = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLE1 | Experimenteren</title>
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
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
    <script src="./js/main.js"></script>
    <script>
        const map = L.map('map').setView([52.3676, 4.9041], 9).locate({
            setView: true,
            maxZoom: 16
        }); // Default to Amsterdam
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function onLocationFound(e) {
            var radius = e.accuracy;
            L.marker(e.latlng).addTo(map)
                .bindPopup("You are within " + radius + " meters from this point").openPopup();
            L.circle(e.latlng, radius).addTo(map);

            addAnimalsToMap(e.latlng);
        }

        async function addAnimalsToMap(latlng) {
            console.log(latlng.lat);
            console.log(latlng.lng);
            const animals = [];
            const response = await fetchAnimals(latlng.lat, latlng.lng, 10000);

            for (const animal of response) {
                animals.push({
                    animal_type: animal.animal_type,
                    latitude: animal.latitude,
                    longitude: animal.longitude,
                    danger_level: animal.danger_level,
                    reported_time: animal.reported_time
                });
            }

            animals.forEach(animal => {
                L.marker([animal.latitude, animal.longitude], {
                        alt: `animal type: ${animal.animal_type}, danger level ${animal.danger_level}`
                    }).addTo(map)
                    .bindPopup(`<b>${animal.animal_type}</b><br><i>${animal.reported_time}</i><br>Status: ${animal.danger_level}`);
            });
        }

        function onLocationError(e) {
            alert(e.message);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);
    </script>
</body>

</html>
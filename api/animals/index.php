<?php
require_once('../settings.php');

header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$query = "SELECT id, animal_type, danger_level, 
                 ST_X(location) as longitude, 
                 ST_Y(location) as latitude, 
                 amount, reported_time 
          FROM `animals`";

if ($data !== null && isset($data['lat'], $data['lng'])) {
    $lat = (float)$data['lat'];
    $lng = (float)$data['lng'];
    $distance = isset($data['distance']) ? (int)$data['distance'] : 5000;

    $query = "SELECT id, animal_type, danger_level, 
                     ST_X(location) as longitude, 
                     ST_Y(location) as latitude, 
                     amount, reported_time, 
                     ST_Distance_Sphere(location, ST_GeomFromText(?,4326)) AS distance_meters 
              FROM `animals` 
              WHERE ST_Distance_Sphere(location, ST_GeomFromText(?,4326)) <= ?
              ORDER BY distance_meters ASC";
}

$stmt = mysqli_prepare(db, $query);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare database statement"]);
    exit;
}

if (isset($lat, $lng, $distance)) {
    $pointString = "POINT($lng $lat)";
    mysqli_stmt_bind_param($stmt, "ssi", $pointString, $pointString, $distance);
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$animals = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($animals);
mysqli_stmt_close($stmt);

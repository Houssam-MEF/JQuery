<?php
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');

if (isset($_GET['action']) && $_GET['action'] == 'getCountries') {
    $query = "SELECT id, name FROM country";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $countries = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($countries);
}

if (isset($_GET['action']) && $_GET['action'] == 'getRegions') {
    $paysId = $_GET['countryId'];

    $query = "SELECT id, name FROM state WHERE country_id = :countryId";
    $statement = $pdo->prepare($query);
    $statement->execute(['countryId' => $paysId]);
    $regions = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($regions);
}

if (isset($_GET['action']) && $_GET['action'] == 'getVilles') {
    $regionId = $_GET['stateId'];

    $query = "SELECT id, name FROM city WHERE state_id = :stateId";
    $statement = $pdo->prepare($query);
    $statement->execute(['stateId' => $regionId]);
    $villes = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($villes);
}
?>

<?php
include 'icl/listitems.inc.php';
function searchitems() {
    $page = $_GET['page'] ?? 1; // 1 pages are 1 indexed
    $wynnItemUrl = 'https://api.wynncraft.com/v3/item/search?page='.$page; // DO NOT ADD BACKSLASH AT THE END!

    $ch = curl_init($wynnItemUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    
    $obj = [];
    $obj['query'] = $_GET['query'] ?? null;
    $obj['type'] = $_GET['type'] ?? [];
    $obj['tier'] = $_GET['tier'] ?? [];
    $obj['attackSpeed'] = $_GET['attackSpeed'] ?? [];
    $obj['levelRange'] = $_GET['levelRange'] ?? [0, 200];
    $obj['professions'] = $_GET['professions'] ?? [];
    $obj['identifications'] = $_GET['identifications'] ?? [];
    $obj['majorIds'] = $_GET['majorIds'] ?? [];
    
    $data = json_encode($obj); 

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if (curl_errno($ch)) { die('CURL error: ' . curl_error($ch)); }

    curl_close($ch);

    $results = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON response.');
    }
    return listitems($results);
}
?>

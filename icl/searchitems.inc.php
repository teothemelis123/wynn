<?php
include 'icl/listitems.inc.php';
function searchitems() {
    $page = $_GET['page'] ?? 1; // 1 pages are 1 indexed
    $data = file_get_contents('php://input');
    //$jsondecoded = json_decode($json, true);
    //print_r($jsondecoded);
    //die();
    $wynnItemUrl = 'https://api.wynncraft.com/v3/item/search?page='.$page; // DO NOT ADD BACKSLASH AT THE END!

    $curl = curl_init($wynnItemUrl);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($curl);
    if (curl_errno($curl)) { die('CURL error: ' . curl_error($curl)); }

    curl_close($curl);

    $results = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON response.');
    }
    listitems($results);
}
?>

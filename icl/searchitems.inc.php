<?php
function searchitems() {
    $itemname = $_GET['itemname'];
    $wynnItemUrl = 'https://api.wynncraft.com/v3/item/search/'.$itemname;

    $ch = curl_init($wynnItemUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) { die('CURL error: ' . curl_error($ch)); }

    curl_close($ch);

    $itemdata = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON response.');
    }
    var_dump($itemdata);
}
?>

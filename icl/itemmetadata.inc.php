<?php
function itemmetadata() {
    $wynnItemUrl = 'https://api.wynncraft.com/v3/item/metadata'; // DO NOT ADD BACKSLASH AT THE END!
    $ch = curl_init($wynnItemUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) { die('CURL error: ' . curl_error($ch)); }

    curl_close($ch);

    return json_decode($response, true);
}

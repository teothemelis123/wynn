<?php
include 'icl/listidentifications.inc.php';
function deleteidentification() {
    $identificationtoremove = $_GET['identification'] ?? 0;
    $currentidentifications = $_GET['currentidentifications'];
    $currentmajoridentifications = $_GET['currentmajoridentifications'];
    $decodedcurridents = json_decode($currentidentifications);
    
    // if it exists, we remove it
    foreach($decodedcurridents as $i => $currident) {
        if ($currident == $identificationtoremove) {
            array_splice($decodedcurridents, $i, 1);
            break;
        }
    }
    listidentifications($decodedcurridents, json_decode($currentmajoridentifications));
}

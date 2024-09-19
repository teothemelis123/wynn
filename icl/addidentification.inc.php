<?php
include 'icl/listidentifications.inc.php';
function addidentification() {
    $identification = $_GET['identification'] ?? 0;
    if (!$identification) print_r("NO IDENT UH OH HOW TF DO I HANDLE THIS ERROR?!@#?!@#?");

    $currentidentifications = $_GET['currentidentifications'];
    $decodedcurridents = json_decode($currentidentifications);
    
    // If you want the serverside to validate that the user is not searching
    // for the same identification twice, you can uncomment this
    //
    //if (!in_array($identification, $decodedcurridents)) {
    //    array_push($decodedcurridents, $identification);
    //}
    array_push($decodedcurridents, $identification);

    listidentifications($decodedcurridents);
}

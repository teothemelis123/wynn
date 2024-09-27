<?php
include 'icl/listidentifications.inc.php';
function addmajoridentification() {
    $identification = $_GET['identification'] ?? 0;
    if (!$identification) print_r("NO IDENT UH OH HOW TF DO I HANDLE THIS ERROR?!@#?!@#?");
    $currentidentifications = $_GET['currentidentifications'];
    $currentmajoridentifications = $_GET['currentmajoridentifications'];
    $currentmajoridentificationsdecoded = json_decode($currentmajoridentifications);
    array_push($currentmajoridentificationsdecoded, $identification);
    listidentifications(json_decode($currentidentifications), $currentmajoridentificationsdecoded);
}

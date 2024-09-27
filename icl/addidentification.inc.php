<?php
include 'icl/listidentifications.inc.php';
function addidentification() {
    $identification = $_GET['identification'] ?? 0;
    if (!$identification) print_r("NO IDENT UH OH HOW TF DO I HANDLE THIS ERROR?!@#?!@#?");
    $currentmajoridentifications = $_GET['currentmajoridentifications'];
    $currentidentifications = $_GET['currentidentifications'];
    $currentidentificationsdecoded = json_decode($currentidentifications);
    array_push($currentidentificationsdecoded, $identification);
    listidentifications($currentidentificationsdecoded, json_decode($currentmajoridentifications));
}

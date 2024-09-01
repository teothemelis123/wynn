<?php
    $cmd = $_GET['cmd'];
    switch ($cmd) {
        case 'searchitems': include 'icl/searchitems.inc.php'; searchitems(); break;
    }
?>

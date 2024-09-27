<?php
$cmd = $_GET['cmd'];
switch ($cmd) {
    case 'searchitems': include 'icl/searchitems.inc.php'; searchitems(); break;
    case 'addidentification': include 'icl/addidentification.inc.php'; addidentification(); break;
    case 'deleteidentification': include 'icl/deleteidentification.inc.php'; deleteidentification(); break;
    case 'addmajoridentification'; include 'icl/addmajoridentification.inc.php'; addmajoridentification(); break;
    case 'deletemajoridentification': include 'icl/deletemajoridentification.inc.php'; deletemajoridentification(); break;
}

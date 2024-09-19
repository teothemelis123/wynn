<?php
// takes in a array, but spits out a encoded array
function listidentifications($identifications = array()) {
    ?>
    <p class="header">chosen identifications</p>
    <?php
    foreach ($identifications as $identname) {
    ?>
        <div>
        <a href=# onclick="deleteidentification('<?php echo $identname; ?>'); return false">[x]</a> <a><?php echo $identname ?></a>
        </div>
    <?php
    }
    ?>
        <textarea id="identificationsdata" style="display: none"><?php echo json_encode($identifications) ?></textarea>
    <?php
}

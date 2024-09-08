<?php
include 'icl/itemmetadata.inc.php';
function listfilteroptions() {
    $metadata = itemmetadata();
    #$identifications = $metadata['identifications'];
    $filters = $metadata['filters'];
    $types = $filters['type'];
?>
<button onclick="searchitems()">Apply filters</button>

<div id="types">
    <legend>Please select a type filter:</legend>

    <?php
    foreach ($types as $typeidx => $type) {
    ?>

      <input type="checkbox" id="type_<?php echo $typeidx; ?>" name="typefilter" value="<?php echo $type; ?>"/>
      <label for="type_<?php echo $typeidx; ?>"><?php echo $type; ?></label>

    <?php
        } // foreach
    ?>
</div>
<?php
}


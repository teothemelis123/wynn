<?php
include 'icl/itemmetadata.inc.php';
function listfilteroptions() {
    $metadata = itemmetadata();
    $advancedfilters = $metadata['filters']['advanced'];
    #$identifications = $metadata['identifications'];
    $filters = $metadata['filters'];
    $types = $filters['type'];
?>
<button onclick="searchitems()">Apply filters</button>

<div id="types">
    <legend>Please select a type filter:</legend>

    <?php
    foreach ($types as $typeidx => $type) { // show default categories (armor, accessories tools, etc)
    ?>

      <input onclick="mainfilterclicked(this);"type="checkbox" class="filter" id="type_<?php echo $typeidx; ?>" name="typefilter" value="<?php echo $type; ?>"/>
      <label for="type_<?php echo $typeidx; ?>"><?php echo $type; ?></label>

    <?php
        } // foreach
    ?>
    <div id="advancedcategories">
        <?php 
        foreach ($advancedfilters as $name => $arr) {
        // we need the attackspeed div to be the same as the weapon one, since
        // they should both be visible when the user clicks the weapon category
            $containername = $name;
            switch ($containername) {
                case "attackSpeed": $containername = "weapon"; break;
                case "crafting": $containername = "ingredient"; break;
                case "gathering": $containername = "material"; break;
            }
            if ($containername == "attackSpeed") $containername = "weapon";
            ?>
            <div class="<?php echo $containername; ?>_advancedfiltercontainer hidden">
            <?php
            switch ($name) {
            // attackspeed should be grouped with the weapon checkbox, so we 
            // ensure we use the weapon name for our div if we are on
            // attackspeed
                case 'attackSpeed': $name = "checkbox_attackSpeed"; break;
            // the material checkbox maps to the gathering from meta data so we
            // remap it here
                case 'gathering': $name = "checkbox_profession"; break;
            // same goes for crafing and ingredients
                case 'crafting': $name = "checkbox_profession"; break;
                default: $name = "checkbox_".$name; break;
            }
            ?>
                <?php
                foreach ($arr as $key => $val) {
                    ?>
                    <input type="checkbox" 
                           class="advancedfilter <?php echo $name;?>" 
                           id="advancedtype_<?php echo $key; ?>" 
                           name="typefilter" 
                           value="<?php echo $val; ?>"
                    />
                    <label for="advancedtype_<?php echo $key; ?>"><?php echo $val; ?></label>
                    <?php 
                } // inner for each
                ?>
            </div> <!--advanced filter div close-->
        <?php
        } // outer for each
        ?>
    </div> <!--advanced categories-->
</div <!--types div-->
<?php
}

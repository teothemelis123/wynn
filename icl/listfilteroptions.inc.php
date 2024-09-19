<?php
include 'icl/itemmetadata.inc.php';
include 'icl/cleaninfo.inc.php';
include 'icl/listidentifications.inc.php';
function listfilteroptions() {
    $metadata = itemmetadata();
    $advancedfilters = $metadata['filters']['advanced'];

    $identifications = $metadata['identifications'];
    $majorids = $metadata['majorIds'];

    $identifications = array_merge($identifications, $majorids);

    $filters = $metadata['filters'];
    $types = $filters['type'];
    $tiertypes = $filters['tier']; // ['items'] and ['ingredients'] are in tier
    $levelRange = $filters['levelRange']; // ['items'] and ['ingredients'] are in tier
?>
<div id="identificationscontainer">
    <div id="identificationsinputcontainer">
        <label for="identificationsinput" class="header">Search identifications:</label>
        <input id="identificationsinput" onkeyup="autocompleteident(); return false"></input>
    </div>

    <div id="identificationssubcontainer">
        <div id="identificationslist">
            <p class="header">identifications</p>
            <?php
            foreach ($identifications as $ident) {
            ?>
                <a class="hidden" href=# onclick="addidentification(this); return false;"><?php echo $ident; ?></a>
            <?php
            }
            ?>
        </div>
        <div id="selectedidentificationslist">
            <?php listidentifications(); ?>
        </div>
    </div>
</div>

<div id="types">
    <div class="optioncontainer">
        <p>ingredient tiers:</p>
        <div class="flex">
        <?php
            foreach ($tiertypes['ingredients'] as $val) {
                ?>
                    <span class="itemtier zoom" onclick="togglebox(this);"><?php echo $val; ?></span>
                <?php 
            } // inner for each
        ?>
        </div>
    </div>
    <div class="optioncontainer">
        <p>item tiers:</p>
        <div class="flex">
        <?php
            foreach ($tiertypes['items'] as $val) {
                ?>
                        <span class="itemtier zoom" onclick="togglebox(this);"><?php echo $val; ?></span>
                <?php 
            } // inner for each
        ?>
        </div>
    </div>
    
    <div class="optioncontainer">
        <p>level range</p>
        <div id="levelrangecontainer">
            <input type="number" id="levelrangemin" class="range" name="levelrangemin" value="0" min="0" max="<?php echo $levelRange['items'];?>" />
            to
            <input type="number" id="levelrangemax" class="range" name="levelrangemax" value="<?php echo $levelRange['items'];?>" min="0" max="<?php echo $levelRange['items'];?>" />
        </div>
    </div>

    <div class="optioncontainer">
        <p>Filters:</p>
        <div class="flex">
        <?php
        foreach ($types as $typeidx => $type) { // show default categories (armor, accessories tools, etc)
        ?>

          <span onclick="togglebox(this); mainfilterclicked(this);" class="filter zoom" id="type_<?php echo $typeidx; ?>" name="typefilter"><?php echo $type; ?></span>

        <?php
            } // foreach
        ?>
        </div>
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
                <div class="<?php echo $containername; ?>_advancedfiltercontainer hidden advancedfiltercontainer">
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
                    foreach ($arr as $val) {
                        ?>
                        <div onclick="togglebox(this)" class="zoom advancedfilter <?php echo $name;?>" id="<?php echo $val; ?>" ><?php echo cleaninfo($val); ?></div>
                        <?php 
                    } // inner for each
                    ?>
                </div> <!--advanced filter div close-->
            <?php
            } // outer for each
            ?>
        </div> <!--advanced categories-->
    </div>
</div> <!--types div-->
<?php
}

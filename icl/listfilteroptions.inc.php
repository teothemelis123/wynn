<?php
include 'icl/itemmetadata.inc.php';
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
<button onclick="searchitems()">Apply filters</button>

<div id="identificationscontainer">
    <label for="identificationsinput">identification:</label>
    <input id="identificationsinput" onkeyup="autocompleteident(); return false"></input>

    <div id="identificationslist">
        <?php
        foreach ($identifications as $ident) {
        ?>
            <a class="hidden" href=# onclick="addtoidents(this); return false;"><?php echo $ident; ?></a>
        <?php
        }
        ?>
    </div>
</div>
<p>current idents:</p>
<textarea id="identsearchlist">[]</textarea>

<div id="types">
    <div>
    <p>ingredient tiers:</p>
    <?php
        foreach ($tiertypes['ingredients'] as $key => $val) {
            ?>
                    <input type="checkbox" class="itemtier" id="ingredienttier_<?php echo $key; ?>" value="<?php echo $val; ?>" />
                    <label for="ingredienttier_<?php echo $key; ?>"><?php echo $val; ?></label>
            <?php 
        } // inner for each
    ?>
    </div>
    <div>
    <p>item tiers:</p>
    <?php
        foreach ($tiertypes['items'] as $key => $val) {
            ?>
                    <input type="checkbox" class="itemtier" id="itemtier_<?php echo $key; ?>" value="<?php echo $val; ?>" />
                    <label for="itemtier_<?php echo $key; ?>"><?php echo $val; ?></label>
            <?php 
        } // inner for each
    ?>
    </div>
    
    <div id="levelrangecontainer">
        <p>level range</p>
        <input type="number" id="levelrangemin" class="range" name="levelrangemin" value="0" min="0" max="<?php echo $levelRange['items'];?>" />
        to
        <input type="number" id="levelrangemax" class="range" name="levelrangemax" value="<?php echo $levelRange['items'];?>" min="0" max="<?php echo $levelRange['items'];?>" />
    </div>
    <div>
    </div>

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

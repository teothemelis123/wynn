<?php
include "cleaninfo.inc.php";
function listitems($results) {
    if (isset($results['Error'])) exit();
    $controller = $results['controller'];
    $prevpage = $controller['previous'];
    $currpage = $controller['current'];
    $nextpage = $controller['next']; 
    $totalpages = $controller['pages']; 
    $items = $results['results'];
    ?>
    <div id="itemcards">
    <?php
    $textcolor = "rgb(255, 255, 255)";
    $glowing = false;
    foreach ($items as $item) {
        if (isset($item['rarity'])) {
            $boxshadow = "rgb(0, 0, 0)";
            $glowing = false;
            switch($item['rarity']) {
                case 'normal': $textcolor = "rgb(255, 255, 255)"; break; 
                case 'unique': $textcolor = "rgb(252, 252, 84)"; break;
                case 'rare': $textcolor = "rgb(255, 80, 232)"; break;
                case 'legendary': $textcolor = "rgb(80, 253, 255)"; break;
                case 'fabled': $textcolor = "rgb(246, 62, 62)"; $boxshadow = "rgb(246, 62, 62, 0.6)" ; break;
                case 'set': $textcolor = "rgb(56, 229, 37)"; break;
                case 'mythic': $textcolor = "rgb(164, 57, 192)"; $boxshadow = "rgb(164, 57, 192, 0.6)"; $glowing = true; break;
                default: $textcolor = "rgb(255, 255, 255)"; break;
            }
    }
    ?>
    <div class="itemcard<?php if ($glowing) echo ' glowing'; ?>" style="box-shadow: 6px 6px <?php echo $boxshadow; ?>">
    <?php
        if (isset($item["internalName"])) {
            ?>
                <p class="internalName<?php if ($glowing) echo ' glowing'; ?>" style="color: <?php echo $textcolor; ?>"><?php echo cleaninfo($item["internalName"]); ?></p> 
            <?php
        }

        if (isset($item["attackSpeed"])) {
            ?>
                <p class="attackSpeed"><?php echo cleaninfo($item["attackSpeed"]); ?></p> 
            <?php
        }

        if (isset($item["base"])) {
            ?>
            <div class="base">
            <?php
                forEach($item["base"] as $dmgtype => $dmgval) {
                    if (is_array($dmgval)) {
                ?>
                    <p><?php echo cleaninfo($dmgtype)." ".$dmgval["min"].'-'.$dmgval["max"]; ?></p> 
                    <?php
                    } else {
                    ?>
                    <p><?php echo cleaninfo($dmgtype)." ".$dmgval; ?></p> 
                    <?php
                    }
                    ?>
                <?php
                }
            ?>
            </div>
            <?php
        }
        if (isset($item["averageDps"])) {
            ?>
                <p class="averageDps"><?php echo 'average DPS: '.$item["averageDps"]; ?></p> 
            <?php
        }
        if (isset($item["requirements"])) {
            ?>
            <div class="requirements">
            <?php
            $requirements = $item["requirements"];
            if (isset($requirements["classRequirement"])) {
                ?>
                    <p><?php echo 'Class Req: '.$requirements["classRequirement"]; ?></p> 
                <?php
            }
            if (isset($requirements["level"])) {
                ?>
                    <p><?php echo 'Combat Lv. Min: '.$requirements["level"]; ?></p> 
                <?php
            }
            if (isset($requirements["strength"])) {
                ?>
                    <p><?php echo 'Strength Min: '.$requirements["strength"]; ?></p> 
                <?php
            }
            ?>
            </div>
            <?php
        }
        if (isset($item["identifications"])) {
            ?>
            <div class="identifications">
            <?php
            forEach($item["identifications"] as $identype => $idenval) {
                if (is_array($idenval)) {
                    ?>
                        <p><?php echo $idenval["min"]." to ".$idenval["max"]." ".cleaninfo($identype); ?></p> 
                    <?php
                } else {
                    ?>
                        <p><?php echo $idenval." ".cleaninfo($identype); ?></p> 
                    <?php
                }
            }
            ?>
            </div>
            <?php
        }

        if (isset($item["powderSlots"])) {
            ?>
                <p class="powderSlots">[<?php echo $item["powderSlots"]; ?>] Powder slots</p> 
            <?php
        }

        if (isset($item["rarity"])) {
            ?>
                <p class="rarity<?php if ($glowing) echo ' glowing'; ?>" style="color: <?php echo $textcolor; ?>"><?php echo $item["rarity"]; ?> Item</p> 
            <?php
        }

        if (isset($item["lore"])) {
            ?>
                <p class="lore"><?php echo $item["lore"]; ?></p> 
            <?php
        }
?>
    </div> <!--item card-->
<?php
        
    } // foreach outer
?>
    </div> <!-- item cards (item card container) -->
    <div id="pagenavigation">
        <a href=# onclick="searchitems(<?php echo ($prevpage ?? $currpage) ?>); return false">prev</a>
        <?php
            for ($i = 1; $i < 11; $i++) {
                $thispage = $currpage + $i;
                if ($thispage > $totalpages) break; // dont allow links to pages past the page limit
            ?>
            <a href=# onclick="searchitems(<?php echo $thispage ?>);"><?php echo $thispage ?></a>
                
            <?php
                
            } // for
        ?>
        <a href=# onclick="searchitems(<?php echo ($nextpage ?? $currpage) ?>); return false;">next</a>
    </div>
<?php
}

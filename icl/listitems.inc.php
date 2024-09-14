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
    foreach ($items as $item) {
    ?>
    <div class="itemcard">
    <?php
        $textcolor = "";
        if (isset($item['rarity'])) {
            $textcolor = $item['rarity'];
        }
        if (isset($item["internalName"])) {
            ?>
                <p class="internalName <?php echo $textcolor; ?>"><?php echo cleaninfo($item["internalName"]); ?></p> 
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
                <p class="rarity <?php echo $textcolor; ?>"><?php echo $item["rarity"]; ?> Item</p> 
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

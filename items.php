<!DOCTYPE html>
<html lang="en">
<?php
include 'icl/listfilteroptions.inc.php';
?>

<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wynn items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0px;
            margin: 0px;
        }
        #itemmetadata {
            display: none
        }

        #query {
            margin: 10px;
        }

        #pagenavigation {
            display: flex;
            justify-content: space-evenly;
            margin-top: 100px;
            margin-bottom: 100px;
            margin-left: auto;
            margin-right: auto;
            width: 500px;
            font-size: 26px;
        }

        p {
            margin: 0;
            padding: 0;
        }
        
        #itemcards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }
        .itemcard {
             width: 300px;
             height: 600px;
             background: orange;
             border: 2px solid black;
        }
        .internalName{
            margin-top: 20px;
        }
        .base, .requirements, .identifications, .powderslots{
            margin-top: 10px;
        }
        .hidden {
            display: none;
        }

        .range {
            width: 40px;
        }

        .ident {
            display: block;
        }

    </style>
</head>

<body>
<a href="index.php">Home</a>

<input id="query" onkeyup="searchitems(); return false;" placeholder="Item name"></input>
<div id="filters"><?php listfilteroptions(); ?></div>
<div id="iteminfo"></div>

<script>
    function gid(str) {
        return document.getElementById(str);
    }

    function searchitems(page) {
        var query = encodeURI(gid('query').value) || undefined;
        var attackSpeed = []; // attack speed only
        var professions = []; // advanced crafting, and advanced gathering
        var types = []; // everything else
        var skipfilter = {}; // keeps track of main filters to not add to types
        var levelRange = [];
        var identifications = JSON.parse(gid("identsearchlist").value);
        var tier = [];
        var typeselements = document.getElementsByClassName('advancedfilter');
        for (var t of typeselements) {
            if (t.checked) {
                if (t.classList.contains('checkbox_attackSpeed')) {
                    attackSpeed.push(t.value);
                } else if (t.classList.contains('checkbox_profession')) {
                    professions.push(t.value);
                } else {
                    // for weapon, armor, accessory, tome, tool...
                    // lets say we have weapon checked AND bow checked, we must
                    // omit weapon from our types array otherwise it overrules
                    // the bow option. same with ,armor ,accessory tome, and tool
                    // if a subclass is selected, we must ignore the main checkbox
                    //
                    // first gather advanced filters, and have a flag to block
                    // normal filters when gathering advanced ones
                    var classes = t.className.split(' ');
                    for (var c of classes) {
                        if (c.includes("checkbox_")) { // if this class contains checkbox_
                            // we grab what checkbox it is under to disable it
                            var maincheckboxname = c.split("_")[1];
                            skipfilter[maincheckboxname] = true;
                        }
                    }
                    types.push(t.value);
                }
            }
        }

        // add the main checkboxes if sub checkboxes have not been added
        typeselements = document.getElementsByClassName('filter');
        for (var t of typeselements) {
            // if its checked, and there is no sub checkbox checked we add it
            if (t.checked && !skipfilter[t.value]) types.push(t.value);
        }

        levelRange[0] = parseInt(gid('levelrangemin').value, 10);
        levelRange[1] = parseInt(gid('levelrangemax').value, 10);

        
        var tierelements = document.getElementsByClassName('itemtier');
        for (var t of tierelements) {
            // if its checked, and there is no sub checkbox checked we add it
            if (t.checked) tier.push(t.value);
        }
        //console.log("types: "+types);
        //console.log("professions: "+professions);
        //console.log("attackSpeed: "+attackSpeed);
        //console.log("==================================================");
        
        //if (query && query.length < 3) {
        //    gid("iteminfo").innerHTML = ""; 
        //    return;
        //}

        $.ajax({
            type: 'GET',
            url: 'services.php',
            data: { 
                page: page,
                cmd: 'searchitems',  
                query: query,
                type: types,
                attackSpeed: attackSpeed,
                identifications: identifications,
                professions: professions,
                levelRange: levelRange,
                tier: tier
            },
            success: function (response) {
                gid("iteminfo").innerHTML = response;
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function autocompleteident() {
        var userinput = (gid('identificationsinput').value).toLowerCase();
        var ul = gid('identificationslist'); 
        var li = ul.getElementsByTagName("li");
        var amountshown = 0;
        var amountcap = 5;
        for (var i = 0; i < li.length; i++) {
            var a = li[i].getElementsByTagName("a")[0];
            li[i].style.display = "none";
        }
        for (var i = 0; i < li.length; i++) {
            var a = li[i].getElementsByTagName("a")[0];
            var txt = (a.textContent || a.innerText).toLowerCase();
            if (txt.includes(userinput)) {
               li[i].style.display = "block"; 
                amountshown++;
            }
            if (amountshown > amountcap) return;
        }
    }

    function addtoidents(d) {
        var val = gid('identsearchlist').value;
        var data = JSON.parse(val);
        data.push(d.innerText);
        gid('identsearchlist').innerText = JSON.stringify(data); 
    }

    function mainfilterclicked(d) {
        var filters = document.getElementsByClassName(d.value+'_advancedfiltercontainer');
        for (var i = 0; i < filters.length; i++) {
            if (d.checked) {
                filters[i].style.display = 'block';
            } else {
                filters[i].style.display = 'none'; // hide the div
                // set all checkboxes in that div to false
                var inputs = filters[i].getElementsByTagName('input');
                for (var j = 0; j < inputs.length; j++) {
                inputs[j].checked = false; 
                }
            }
        }

    }

function debounce(func, delay) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    const debouncedSearch = debounce(searchitems, 300);


</script>
</body>

</html>

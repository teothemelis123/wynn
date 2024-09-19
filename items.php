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
            font-family: 'Brush Script MT', cursive;
            padding: 20px;
            margin: 0px;
        }
        
        #maindiv {
            border-radius: 15px;
            background: rgba(165, 165, 165);
            padding: 20px;
        }
        p {
            margin: 0;
            padding: 0;
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

        #itemcards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            color: rgba(220, 220, 220);
        }

        .optioncontainer {
            display: inline-block;
            margin: 10px;
            padding: 20px;
            text-align: center;
            border-radius: 15px;
            background: rgba(120, 120, 120);
        }


        .optioncontainer > p {
            color: white;
        }

        .fadeout {
          visibility: hidden;
          opacity: 0;
          transition: opacity 250ms ease-in, visibility 0ms ease-in 250ms;
        }

        .fadein {
          visibility: visible;
          opacity: 1;
          transition-delay: 0ms;
        }

        .itemcard {
            width: 30vh;
            background: rgba(28, 0, 16);
            font-size: 18px;
            box-shadow: 4px 4px #000000;
            border-radius: 15px;
            border: 2px solid black;
            padding: 15px;
            margin: 15px;
        }

        .internalName, .attackSpeed {
            text-align: center;
        }

        .internalName{
            margin-top: 30px;
        }

        .base, .requirements, .identifications, .powderslots {
            margin-top: 20px;
        }

        .hidden {
            display: none;
            min-height: 50px;
        }

        .range {
            width: 40px;
        }

        .ident {
            display: block;
        }

        .zoom {
            padding: 10px 20px;
            margin: 20px 10px;
            background: rgba(200, 200, 200);
            transition: transform .2s;
            text-align: center;
            border-radius: 15px;
            transition: all 0.3s ease; /* Transition for all properties */
        }

        .zoom.transitioned {
            background-color: rgba(50, 50, 50);
            color: white;
        }

        .advancedfilter {
            margin-top: 10px;
        }

        .advancedfiltercontainer {
            margin-top: 10px;
            min-height: 50px;
        }

        .zoom:hover {
            cursor: pointer;
            transform: scale(1.15);
        }

        .glowing{
          animation: glowingbg 1.5s 0s linear infinite alternate;
        }

        @keyframes glowingbg{
          from   {background:rgb(28, 0, 16)}
          to     {background:rgba(84, 7, 112)}
        }

        .flex {
            display: flex;
        }

        
    </style>
</head>

<body>

<div id="maindiv">
    <a href="index.php">Home</a>
    <input id="query" onkeyup="itemnametyped(); return false;" placeholder="Item name"></input>
    <div id="filters"><?php listfilteroptions(); ?></div>
    <div id="iteminfo"></div>
</div>

<script src="nano.js"></script>
<script>
    function itemnametyped() {
        if (this.timer) clearTimeout(this.timer);
        this.timer = setTimeout(function() { searchitems(); }, 500); 
    }

    function togglebox(d) {
        d.classList.toggle('transitioned');
        d.toggled = !d.toggled;
        searchitems(); 
    }
    function gid(str) {
        return document.getElementById(str);
    }

    function searchitems(page) {
        var items = gid('itemcards');

        if (items) items.style.filter = "blur(5px)";

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
            if (t.toggled) {
                if (t.classList.contains('checkbox_attackSpeed')) {
                    attackSpeed.push(t.id);
                } else if (t.classList.contains('checkbox_profession')) {
                    professions.push(t.innerHTML);
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
                    types.push(t.innerHTML);
                }
            }
        }

        // add the main checkboxes if sub checkboxes have not been added
        typeselements = document.getElementsByClassName('filter');
        for (var t of typeselements) {
            // if its checked, and there is no sub checkbox checked we add it
            if (t.toggled && !skipfilter[t.innerHTML]) types.push(t.innerHTML);
        }

        levelRange[0] = parseInt(gid('levelrangemin').value, 10);
        levelRange[1] = parseInt(gid('levelrangemax').value, 10);

        
        var tierelements = document.getElementsByClassName('itemtier');
        for (var t of tierelements) {
            // if its checked, and there is no sub checkbox checked we add it
            if (t.toggled) tier.push(t.innerHTML);
        }

        var data = {
                page: page,
                query: query,
                type: types,
                attackSpeed: attackSpeed,
                identifications: identifications,
                professions: professions,
                levelRange: levelRange,
                tier: tier
        }
        var dataencoded = JSON.stringify(data);
        //nano.js
        ajxpgn('iteminfo', 'services.php?cmd=searchitems', 0, 0, dataencoded);
    }
    searchitems();

    function autocompleteident() {
        var userinput = (gid('identificationsinput').value).toLowerCase();
        var div = gid('identificationslist'); 
        var atags = div.getElementsByTagName("a");
        var amountshown = 0;
        var amountcap = 5;
        for (const a of atags) {
            a.style.display = "none";
        }
        for (const a of atags) {
            var txt = (a.textContent || a.innerText).toLowerCase();
            if (txt.includes(userinput)) {
               a.style.display = "block"; 
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
        var filters = document.getElementsByClassName(d.innerHTML+'_advancedfiltercontainer');
        for (var i = 0; i < filters.length; i++) {
            if (d.toggled) {
                filters[i].style.display = 'flex';
            } else {
                filters[i].style.display = 'none'; // hide the div
                // set all checkboxes in that div to false
                var els = filters[i].getElementsByTagName('div');
                for (var j = 0; j < els.length; j++) {
                    if (els[j].toggled) togglebox(els[j]);
                }
            }
        }

    }

</script>
</body>

</html>

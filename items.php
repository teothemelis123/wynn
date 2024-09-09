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
        .internalName {
            margin-top: 20px;
        }
        .base {
            margin-top: 10px;
        }
        .requirements {
            margin-top: 10px;
        }
        .identifications {
            margin-top: 10px;
        }
        .powderSlots {
            margin-top: 10px;
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
        var type = [];
        var types = gid('types').getElementsByTagName('input');
        for (var i = 0; i < types.length; i++) {
            if (types[i].checked) type.push(types[i].value);
        }
        
        //if (query.length < 3) {
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
                type: type,
            },
            success: function (response) {
                gid("iteminfo").innerHTML = response;
            },
            error: function (error) {
                console.log(error);
            }
        });
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

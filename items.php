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
            width: 100vw;
            font-family: Arial, sans-serif;
        }
        #itemmetadata {
            display: none
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

    function searchitems() {
  //   "query": [str],
  //   "type": [str, list],
  //   "tier": [int, list, str],
  //   "attackSpeed": [str, list],
  //   "levelRange": [int, list],
  //   "professions": [str, list],
  //   "identifications": [str, list],
  //   [
  //   [
    //]
  //   "majorIds": [str, list],
        var query = encodeURI(gid('query').value) || undefined;
        var type = [];
        var types = gid('types').getElementsByTagName('input');
        for (var i = 0; i < types.length; i++) {
            if (types[i].checked) type.push(types[i].value);
        }
        
        //var tier = encodeURI(gid('tier').value);
        //var attackSpeed = encodeURI(gid('attackSpeed').value);
        //var levelRange = encodeURI(gid('levelRange').value);
        //var professions = encodeURI(gid('professions').value);
        //var identifications = encodeURI(gid('identifications').value);
        //var majorIds = encodeURI(gid('majorIds').value);

        // Here i am doing something similar to their website in which you have to put at least 3 letters in.

        //if (query.length < 3) {
        //    gid("iteminfo").innerHTML = ""; 
        //    return;
        //}

        $.ajax({
            type: 'GET',
            url: 'services.php',
            data: { 
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

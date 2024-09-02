<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wynn items</title>
    <style>
        body {
            width: 100vw;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
<a href="index.php">Home</a>

<form onsubmit="searchitems(); return false;">
<input id="itemname" placeholder="Item name"></input>
<input type="submit" value="Search"></input>
</form>

<div id="iteminfo"> </div>

<script>
    function gid(str) {
        return document.getElementById(str);
    }

    function searchitems() {
        const itemname = encodeURI(gid('itemname').value);
        if (itemname=="") return;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            gid("iteminfo").innerHTML = this.responseText;
        }
        xhttp.open("GET", "services.php?cmd=searchitems&itemname="+itemname, true);
        xhttp.send();
    }


</script>
</body>

</html>

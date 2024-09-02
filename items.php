<!DOCTYPE html>
<html lang="en">

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
    </style>
</head>

<body>
<a href="index.php">Home</a>

<input id="itemname" onkeyup="searchitems(); return false;" placeholder="Item name"></input>


<div id="iteminfo"> </div>

<script>
    function gid(str) {
        return document.getElementById(str);
    }

    // function searchitems() {
    //     const itemname = encodeURI(gid('itemname').value);
    //     if (itemname=="") return;
    //     const xhttp = new XMLHttpRequest();
    //     xhttp.onload = function() {
    //         gid("iteminfo").innerHTML = this.responseText;
    //     }
    //     xhttp.open("GET", "services.php?cmd=searchitems&itemname="+itemname, true);
    //     xhttp.send();
    // }


    function searchitems() {
        var itemname = encodeURI(gid('itemname').value);

        //Here i am doing something similar to their website in which you have to put at least 3 letters in.

        if (itemname.length < 3) {
            gid("iteminfo").innerHTML = ""; 
            return;
        }

        $.ajax({
            type: 'GET',
            url: 'services.php',
            data: { 
                cmd: 'searchitems',  
                itemname: itemname
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

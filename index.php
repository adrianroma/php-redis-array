
<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

foreach (glob("./*/*.php") as $filename)
{
include $filename;
}

$CORE    = new app_core();

$GENERAL = new general();

$DATA = new app_data($CORE,$GENERAL);

$CACHE = new app_redis($CORE, $GENERAL);

$ACTION = new app_action($DATA,$CACHE);


?>



<?php if(1==0): ?>
<input type="button" value="update" onclick="action();" >

<script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>

<script>


// implement JSON.stringify serialization







function action(){
    
    JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = '"'+v+'"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : '"' + n + '":') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
    };

    var tmp = {one: 1, two: "2"};
    string_json = JSON.stringify(tmp); // '{"one":1,"two":"2"}'
    
    console.log(string_json);
    
    new Ajax.Request('/updatate?set='+string_json, {
    onSuccess: function(response) {
        console.log(response);
    // Handle the response content...
    }
});
    
    
}




    
</script>

<?php endif; ?>
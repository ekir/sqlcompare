<head>
<title>SQLcompare</title>
</head>
<body topmargin=0 leftmargin=0 rightmargin=0 style="background-color: red">
<div style="position: relative; display: inline" id="database_select_box">
<select id="database_select">
</select>
</div>
<input type='button' value='Image' onclick="do_image()">
<input type='button' value='Compare' onclick="do_compare()">
<input type='button' value='Clear' onclick="do_clear()">
<div id="console" style="position: absolute; top: 40px; bottom: 0px; width: 100%; background: #dddddd; overflow: auto">
</div>
</body>
<script language="javascript" src="gethttp.js"></script>
<script language="javascript">
    var console=document.getElementById("console");
    var database_select;
    var database_select_box=document.getElementById("database_select_box");

    function update_database_select_box() {
        var selected_db;
        if(database_select!=undefined) {
            selected_db=database_select.value;
            database_select_box.innerHTML=syncHTTP("gen_database_select.php");
            database_select=document.getElementById("database_select");
            set_selected_value(database_select,selected_db);
        } else {
            database_select_box.innerHTML=syncHTTP("gen_database_select.php");
            database_select=document.getElementById("database_select");
        }
    }

    function set_selected_value(select_object,new_value) {
        for(i=0;i<=select_object.options.length-1;i++) {
            if(select_object.options[i].value==new_value) {                
                select_object.selectedIndex=i;
            }
        }    
    }

    function do_image() {
        console.innerHTML="Imageing started... Please wait";
        console.innerHTML=syncHTTP("do_image.php?dbname="+database_select.value);
        update_database_select_box();
    }

    function do_compare() {
        console.innerHTML="Comparing started... Please wait";
        console.innerHTML=syncHTTP("do_compare.php?dbname="+database_select.value);
    }

    function do_clear() {
        console.innerHTML="Clearing started... Please wait";
        console.innerHTML=syncHTTP("do_clear.php?dbname="+database_select.value);
        update_database_select_box();
    }

    update_database_select_box();
</script>
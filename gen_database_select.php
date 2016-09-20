<?
require_once("settings.php");
mysql_connect($config->host, $config->username, $config->password);


/* Makes a query and puts the result in an array of PHP objects */
function query2array($query)
{
 $return_array=array();
 $result=mysql_query($query);
 while($tmp_object=mysql_fetch_object($result))
 {
   array_push($return_array,$tmp_object);
 }
 return($return_array);
}

function right_test($instring,$substr) {
    if(strlen($instring) < strlen($substr)) {
        return(false);
    }
    $right_part=substr($instring,strlen($instring)-strlen($substr),strlen($substr));
    // echo $right_part."<br>"; // For debuggning
    if($right_part==$substr) {
            return(true);
    }
    return(false);
   
}

function get_original_databases() {
    global $database_array;
    $return_array=array();
    foreach($database_array as $database) {
        if(!right_test($database,"_image")) {
            array_push($return_array,$database);
        }
    }
    return($return_array);
}

function has_image($target_database) {
    global $database_array;
    foreach($database_array as $database) {
        if($database==$target_database."_image") {
            return(true);
        }
    }
    return(false);
}

function database_displayname($target_database) {
    if(has_image($target_database)) {
        return($target_database." (imaged)");
    } else {
        return($target_database);
    }
}

$database_array=array();

$database_data_array=query2array("SHOW DATABASES");

foreach($database_data_array as $database_data) {
    array_push($database_array,$database_data->Database);
}

$orginal_database_array=get_original_databases($database_array);

foreach($orginal_database_array as $database) {
    $database_list.="<option value='".$database."'>".database_displayname($database)."</option>";
}

?>
<select id="database_select">
<?=$database_list?>
</select>
<?
require_once("settings.php");
mysql_connect($config->host, $config->username, $config->password);

$do_debug=0;

// Do a mysql query with optional debug output
function do_query($query) {
    global $do_debug;
    if($do_debug) {
        echo $query."<br><br>";
    }
    return(mysql_query($query));
}

$dbname=$_GET["dbname"];

// Creates image database
do_query("DROP DATABASE ".$dbname."_image");

echo "Clearing database-image done";

?>
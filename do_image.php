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

/* Makes a query and puts the result in an array of PHP objects */
function query2array($query)
{
 $return_array=array();
 $result=do_query($query);
 while($tmp_object=mysql_fetch_object($result))
 {
   array_push($return_array,$tmp_object);
 }
 return($return_array);
}

$dbname=$_GET["dbname"];


// Creates image database
do_query("DROP DATABASE ".$dbname."_image");
do_query("CREATE DATABASE ".$dbname."_image");


// Get tables of database to copy
mysql_select_db($dbname);
$table_array=query2array("SHOW TABLES");

foreach($table_array as $table) {
    $tablecolumn="Tables_in_".$dbname;
    $tablename=$table->$tablecolumn;
    echo "<div>Copying table ".$tablename."<br></div>";
    do_query("CREATE TABLE ".$dbname."_image.".$tablename." SELECT * FROM ".$dbname.".".$tablename);
}


echo "Copy done";

?>
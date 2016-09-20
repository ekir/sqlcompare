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

/* Prints the information of a php object or array. Good for debuggning! */
function object_output($obj)
{
 echo "<pre>".print_r($obj,true)."</pre>";
}

function object_diff($object1, $object2) {
    object_output($object1);
    object_output($object2);

    foreach($object1 as $key => $value) 
    {
        if($object1->$key!=$object2->$key) {
            echo $key." differs <br>";
            echo $key.": ".$object1->$key."<br>";
            echo $key.": ".$object2->$key."<br>";
            echo "<br>";
        }
    }
}

function compare_table_data($tablename,$tabledata1, $tabledata2) {
    echo "<div>";
    echo "<strong>Comparing table ".$tablename."</strong><br>";

    // Checks the number of rows 
    $numdiff=sizeof($tabledata1)-sizeof($tabledata2);
    if($numdiff!=0) {
        echo "1: ".sizeof($tabledata1)."<br>";
        echo "2: ".sizeof($tabledata2)."<br>";
        echo $numdiff." as been added<br>";
    }

    // Loops through all rows
    foreach($tabledata1 as $key => $rowdata1) {
        if($rowdata1==$tabledata2[$key]) {
            //echo "ja<br>";
            continue;
        }
        echo $key.":<br>";

       
        if(isset($tabledata2[$key])) {
            // Changed;
            echo "Changed<br>";
            object_diff($rowdata1, $tabledata2[$key]);
        } else {
            // Added
            echo "Added<br>";
            object_output($rowdata1);
        }
    }
    echo "</div>";

}

function compare_table($tablename) {
    global $dbname;
    $tabledata1=array();
    $tabledata2=array();

    unset($tabledata1);
    unset($tabledata2);

    mysql_select_db($dbname);
    $tabledata1=query2array("SELECT * FROM ".$tablename);
    mysql_select_db($dbname."_image");
    $tabledata2=query2array("SELECT * FROM ".$tablename);

    compare_table_data($tablename,$tabledata1,$tabledata2);


}

$dbname=$_GET["dbname"];

mysql_select_db($dbname);

$table_array=query2array("SHOW TABLES");


foreach($table_array as $table) {
    $tablecolumn="Tables_in_".$dbname;
    $tablename=$table->$tablecolumn;
    compare_table($tablename);
}
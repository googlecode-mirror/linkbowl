<?php

try
{
  //create or open the database
  $con = new SQLiteDatabase('./database/urls.db', 0666, $error);
}
catch(Exception $e)
{
  die($error);
}


$de= mysql_real_escape_string($_GET["decode"]);

$sql = "select * from URLS where short='$de'";


if($result = $con->query($sql, SQLITE_BOTH, $error))
{
        $row = $result->fetch();
	$res=$row['url'];
	header("location:$res");


}


?>

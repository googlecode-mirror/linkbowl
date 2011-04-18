<?php

require_once('config.php');

if ($enable_authentication) {
	if ($_SERVER['PHP_AUTH_USER'] != $username && $_SERVER['PHP_AUTH_PW'] != $password) {
	    header('WWW-Authenticate: Basic realm="'.$title.'"');
	    header('HTTP/1.0 401 Unauthorized');
	    echo '401 Unauthorized';
	    exit;
	}
}


try
{
  //create or open the database
  $con = new SQLiteDatabase('./database/urls.db', 0666, $error);
}
catch(Exception $e)
{
  die($error);
}

/*
$query = ' CREATE TABLE urls (id INTEGER PRIMARY_KEY AUTO_INCREMENT, url TEXT, short TEXT); ';
         
if(!$con->queryExec($query, $error))
{
  die($error);
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<!-- more apps ar http://devlup.com or http://projects.devlup.com -->
<style type="text/css">
<!--

body {
	font: 14px/170% 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, Sans-Serif;
	margin: 50px 20px 0px 20px; padding: 0; 
	text-align: left;
	background: #fff url('./images/shadow.png') repeat-x;
}

a {
        font-weight: bold;
        color: #000;
        text-decoration: none;
}

a:hover {
        text-decoration: underline;
}

.small {
	font-size: 10px;
}

.header {
        font-size: 36px;
        width: 100%;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
}
.footer {
        width: 100%;
        text-align: justify;
}
.pages {
        width: 100%;
        text-align: center;
}
.content {
        width: 100%;
        text-align: left;

}

td {
	padding: 3px;
}

table {
	width: 100%;
}

div#popup
{
    position:absolute;
    display:none;
    top:200px;
    left:50%;
    width:400px; 
    margin-left:-200px;
    border:1px solid #000; 
    padding:20px;
    background-color: #fff;
}


-->
</style>
</head>

<body>

<div class=header><img src=images/logo.png><br><br><strong>url list</strong></div>

<?php
	$page = intval($_GET['page']);
	if($page <= 0) {
		$page = 1;
	}
	$sql = "SELECT Count(*) FROM urls"; 
        if($result = $con->query($sql, SQLITE_BOTH, $error))
        {
                if($row = $result->fetch())
                {
                        $total_rows = $row[0];
                }
        }
        $p = 1;
	$prev_page=$page - 1;
        $next_page=$page + 1;

	echo "<div class=pages><span class=small>"; 
	echo "<a href=url_list.php><<</a> ";

	if($prev_page > 0) {
		echo "<a href=url_list.php?page=$prev_page><</a> ";
	}

        while($i < $total_rows) {
                echo "<a href=url_list.php?page=$p>$p</a>&nbsp ";
                $i = $i + $per_page;
                $p++;
        }
	$p--;
	if($next_page < $p) {
		echo "<a href=url_list.php?page=$next_page>></a> ";
	}
	echo "<a href=url_list.php?page=$p>>></a> ";
	echo "</span></div>";
?>

<table>
<tr><td><strong>ID</strong></td><td><strong>Shortcut</strong></td><td><strong>URL</strong></td><td><strong>Created</strong></td><td></td></tr>
<?php
	if(isset($_GET['del'])) {
		$del = intval($_GET['del']);
		$sql = "delete from urls where id=$del";
		if(!$con->queryExec($sql, $error)) {
			echo "Something went wrong, maybe that ID doesn't exist?<br><h2>ERROR:</h2>";
                        die($error);
		} 
	}

	$list_length = sizeof($nouns);

	if($page > 0) {
		$end = $page * $per_page;
		$start = $end - $per_page;
	} else {
		$end = $per_page;
		$start = 0;
	}

	$sql = "select * from urls limit $start,$end";
        if($result = $con->query($sql, SQLITE_BOTH, $error))
        {
                while($row = $result->fetch()) {
			$url=$row['url'];	
			$shorturl=$row['short'];
			$id=$row['id'];
			$datetime=date("m/d/Y H:i:s", $row['date']);
			echo "<tr><td>$id.</td><td><a href=$base_path/$shorturl>$shorturl</a></td><td>$url</td><td><span class=small>$datetime</span></td><td><center><a href=./url_list.php?del=$id><img src=images/delete.png></a></center></td></tr>";
		} 
	}


?>
</table>

<center>
<span class=small>
<a 
    href="./delete.php" 
    onClick="document.getElementById('popup').style.display = 'block'; return false;"
>Purge database</a>

</span>
</center>

<div id="popup">
    <h2> STOP! </h2>
    <p>Are you sure you want to go to delete <strong>EVERYTHING</strong> in the database? All shortcuts previously created will cease to function!</p>
    <p> 
	<center>
        <a onclick="document.location='./delete.php'; return false;">
            Yes
        </a> - 
        <a onclick="document.getElementById('popup').style.display = 'none'; return false;">
            No
        </a>
	</center>
    </p>
</div>


</body></html>


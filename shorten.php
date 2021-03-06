<?php

require_once('config.php');

try
{
  //create or open the database
  $con = new SQLiteDatabase('./database/urls.db', 0666, $error);
}
catch(Exception $e)
{
  die($error);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<style type="text/css">
<!--

body {
	font: 14px/170% 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, Sans-Serif;
	margin: 50px 0px 0px 0px; padding: 0; 
	text-align: center;
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
.content {
        width: 100%;
        text-align: center;

}

-->
</style>
</head>

<body>

<?php

        $adjective_length = sizeof($adjectives);
        $noun_length = sizeof($nouns);
	$total_ids = $adjective_length * $noun_length;


	$sql = "select * from urls order by date desc limit 1";
	if($result = $con->query($sql, SQLITE_BOTH, $error))
	{
        	while($row = $result->fetch()) {
	        	$id = $row['id'];
		}
		if (!is_numeric($id)) {
                	$id = 0;
                } else {
			$id++;
		}
	}
	
	$urlinput=mysql_real_escape_string($_POST['url']);
	$customword=mysql_real_escape_string($_POST['customword']);
	if(!(ctype_alnum($customword)) && $customword != '') {
		die("Please use only numbers and letters in your custom word");	
	}

	if(!(strpos($urlinput, 'http://') === 0 || strpos($urlinput, 'https://') === 0)) {
		$urlinput="http://$urlinput";
	}

        if($customword != '') {
                $sql = "select * from urls where short='$customword' limit 1";
        } else {
                $sql = "select * from urls where url='$urlinput' limit 1";
        }
	if($result = $con->query($sql, SQLITE_BOTH, $error))
        {
                if($row = $result->fetch()) {
			if($customword != '') {
                		echo "Oops, that word is already taken. Try again!<br>";	
        		} else {	
				$shorturl=$row['short'];
				$note = "I found that URL in my database, the code above was generated on ".date("m/d/Y @ H:i:s",$row['date']);;
				echo "Your speakable URL is <a href=$base_path/$shorturl>$base_path/$shorturl</a><br>";
			}
		} else {
			if (isValidURL($urlinput)) {
				if($customword != '') {
					$shorturl=$customword;
					$note="Chances are your word is safe, I won't let someone overwrite it on purpose<br> However, there could be a 1 in ".number_format($total_ids)." chance it could be recycled by an autogenerated phrase";
				} else {
					$shorturl=get_short_url($id);
					$note="This address should be safe for awhile. I'll generate ".number_format($total_ids)." new phrases before I reuse yours";
				}
				$sql = "replace into URLS ('id','url','short','date') values('$id','$urlinput','$shorturl','".time()."')";
				if(!$con->queryExec($sql, $error)) {die($error);}
				echo "Your speakable URL is <a href=$base_path/$shorturl>$base_path/$shorturl</a><br>";
			} else {
				echo "Thats not much of a URL, maybe you should try again?<br>";
			}
		}
		echo "<span class=small>$note</span><br>";
	}

function get_short_url($id) {
	global $nouns, $adjectives;
	$adjective_length = sizeof($adjectives);
        $noun_length = sizeof($nouns);
	$noun_index = $id % $noun_length;
        $adjective_index = $id % $adjective_length;
	/*
	echo "ID: $id<br>";
	echo "NOUNS: $noun_length<br>";
        echo "ADJECTIVES: $adjective_length<br>";
	echo "NOUN_INDEX: $noun_index<br>";
        echo "ADJECTIVE_INDEX: $adjective_index<br>";
	echo "WORD: ".$adjectives[$adjective_index].$nouns[$noun_index]."<br><br>";
	*/
	return $adjectives[$adjective_index].$nouns[$noun_index];
		
}

function isValidURL($url)
{
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}


echo "<span class=small>$disclaimer</span>";
?>

</body></html>


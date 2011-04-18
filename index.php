<?php

require_once('config.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<!-- more apps ar http://devlup.com or http://projects.devlup.com -->
<style type="text/css">
<!--
#form1 p {
text-align:center;
}

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
	padding-top: 20px;
        font-size: 10px;
}

.header {
	font-size: 36px;
	font-weight: bold;
	width: 100%;
	text-align: center;
	padding-top: 20px;
	padding-bottom: 25px;
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

<div class="header"><img src=images/<?php echo $logo; ?>><br><br><?php echo $title; ?></div>
<div class="content">
<form id="form1" name="form1" method="post" action="shorten.php">

<center>
<table>
<tr>
<td>URL</td><td><span class=small>Custom Word (opt)</span></td><td></td>
</tr>
<tr> 
<td><input type="text" name="url" id="url"  size="45"  /></td><td><input type="text" name="customword" id="url"  size="12"  /></td><td><input type="submit" name="Submit" id="Submit" value="Go" /></td>
</tr>
</table>
</center>
</form>
<span class=small>
<br>
Enter a URL full of slashes, dots dashes. This will make it easy to remember, say out loud or type into a mobile phone.
<?php

if($show_url_list_link) {
	echo "<p><a href='./url_list.php'>See whats in the bowl</a>";
}

?>
</span>

</div>

<div class="footer">
</div>
</body>
</html>

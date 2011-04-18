<?php

require_once("config.php");

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

<div class=header><img src=images/logo.png><br><br><strong>Setup</strong></div>

<?php

try
{
  //create or open the database
  $con = new SQLiteDatabase('./database/urls.db', 0666, $error);
}
catch(Exception $e)
{
  echo "Something went wrong. The ./database directory does not exists or has the wrong permissions. It should be writeable by the webserver. <br> Refresh this page when you've fixed the problem.<h2>ERROR:</h2>";
  die($error);
}


$query = ' CREATE TABLE urls (id INTEGER UNIQUE, url TEXT, short TEXT UNIQUE, date INTEGER); ';

if(!$con->queryExec($query, $error))
{
  echo "Something went wrong. Maybe you're already completed setup? If not, try deleting database/urls.db<br><h2>ERROR:</h2>";
  die($error);
}

echo "<strong>SUCCESS!</strong> Database created, you should be good to go.<br>See config.php to customize your installation. <h2><a href=./>Click here to continue</a></h2>";

?>

</body>
</html>

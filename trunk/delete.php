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


$sql = "delete from URLS;";



if(!$con->queryExec($sql, $error))
{
  echo "Something went wrong. Maybe you're already completed setup? If not, try deleting database/urls.db<br><h2>ERROR:</h2>";
  die($error);
}

echo "<strong>SUCCESS!</strong> The URL database has been cleared. Hope you really meant to do that! <p><a href=./url_list.php>Click here to continue</a></h2>";

?>

</body>
</html>

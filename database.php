<?php
$DB_name = "my_tommasomorganti";
if (function_exists(mysql_connect)) {
  $link = mysql_connect($server, $username, $password);
  mysql_set_charset('utf8');
  $db = mysql_select_db($DB_name, $link) or die("Errore");
} else {
  echo "No MySQL Connection";
}
?>

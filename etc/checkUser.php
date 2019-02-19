<?php
require '../database.php';
$usrchk = $_GET['username'];

if (mysql_num_rows(mysql_query("SELECT * FROM users WHERE username='$usrchk'")) == 0) {
  echo "non esiste";
} else {
  echo "esiste";
}
?>

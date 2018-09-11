<?php
$tablename = isset($_GET['name']) ? $_GET['name'] : die('ERROR! ID not found!');
echo "Edit " . $tablename . "Done Table Edited" ;
?>
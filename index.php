<?php

// include database and object files
error_reporting(0);
include_once 'classes/database.php';
include_once 'classes/user.php';
include_once 'initial.php';
error_reporting(0);
// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 5; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query limit clause

// instantiate database and user object
$user = new Report($db);

// include header file
$page_title = "Users";
include_once "header.php";

// create user button
echo "<div class='right-button-margin'>";
echo "<a href='create.php' class='btn btn-primary pull-right'>";
echo "<span class='glyphicon glyphicon-plus'></span> Create Table";
echo "</a>";
echo "</div>";
error_reporting(0);
// select all users
$prep_state = $user->getAllUsers($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
$num = $prep_state->rowCount();
$id=1;

// check if more than 0 record found
if($num>=0){

    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>TableName</th>";
    echo "<th>Field</th>";
    echo "<th>Datatype</th>";
    echo "</tr>";

    while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

        extract($row); //Import variables into the current symbol table from an array

        echo "<tr>";

        echo "<td>$row[tablename]</td>";
        echo "<td>$row[field]</td>";
        echo "<td>$row[datatype]</td>";
        echo "<td>";
        // edit user button
        echo "<a href='edit1.php?name=" .$row[tablename]."' class='btn btn-warning left-margin'>";
        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
        echo "</a>";

        // delete user button
        echo "<a href='delete1.php?tablename=" . $row[tablename] . "' class='btn btn-danger delete-object'>";
        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
        echo "</a>";

        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    // include pagination file
    include_once 'pagination.php';
}

// if there are no user
else{
    echo "<div> No User found. </div>";
    }
?>


<?php
include_once "footer.php";
?>
<?php

// set page headers
$page_title = "Create User";
include_once "header.php";

// read user button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-info pull-right'>";
        echo "<span class='glyphicon glyphicon-list-alt'></span> List Tables ";
    echo "</a>";
echo "</div>";

// get database connection
include_once 'classes/database.php';
include_once 'initial.php';


// check if the form is submitted
if ($_POST){

    // instantiate user object
    include_once 'classes/user.php';
    $user = new Report($db);

	$tablename = $_POST['tablename'];
	$field =$_POST['field'];
	$datatype =$_POST['datatype'];
	$mysqli = new mysqli("localhost", "root", "", "reports");
 
if ($mysqli ==  false) {
    die("ERROR: Could not connect. ".$mysqli->connect_error);
}
 foreach( $field as $row =>$fields) {
        $query ="INSERT INTO reports (tablename, field, datatype) VALUES ( '". $tablename."','".$fields."','".$datatype[$row]."' )";
        $mysqli->query($query);
    }
	 
     
$mysqli->close();
	
	
    // set user property values
    $user->tablename = htmlentities(trim($_POST['tablename']));
    $user->field= htmlentities($_POST['field']);
    $user->datatype= htmlentities($_POST['datatype']);


    // if the user able to create
    if($user->create()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Success! Table is created.";
        echo "</div>";
    }

    // if the user unable to create
    else{
	 foreach( $field as $v => $p ){
	 echo "the field is ".$p."and the datatype is" .$datatype[$v]. "done";
	 }
	  
	 
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Error! Unable to create user.";
        echo "</div>";
    }
}
?>

<!-- Bootstrap Form for creating a user -->
<form action='create.php' role="form" method='post'>

    <table class='table table-hover table-responsive table-bordered'>
	<tbody>
        
            <td>Name of the Table</td>
            <td><input type='text' name='tablename'  class='form-control' placeholder="Enter Table Name" required></td>
		<table class='table table-hover table-responsive table-bordered' id ='dataTable'>
        <tr>
		    <td> Field </td>
			<td><input type='text' name='field[]' class='form-control' placeholder="FieldName" required></td>
            <td>
                <?php
                    echo "<select class='form-control' name='datatype[]'>";
                        echo "<option>--- Select DataType ---</option>";
                        echo "<option>Text</option>";
						echo "<option>Number</option>";
                       echo "<option>Date</option>";
                    echo "</select>";

                ?>
            </td>
        </tr>
		</table>
		  </tbody>
    </table>
	<input type="button" class="btn btn-primary" value="Add Field"  onClick="addRow('dataTable')" />
	 <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> Create
                </button>	
</form>

<script>
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	                      // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i <colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		}	
}
</script>

<?php
include_once "footer.php";
?>


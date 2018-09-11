<?php

class Report
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "reports";

    // object properties
    public $id;
    public $tablename;
    public $field;
    public $datatype;
    public function __construct($db)
    {
        $this->db_conn = $db;
    }


    function create()
    {
return true;
}
    // for pagination
    public function countAll()
    {
        $sql = "SELECT id FROM " . $this->table_name . "";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); //Returns the number of rows affected by the last SQL statement
        return $num;
    }


    function update()
    {
        $sql = "UPDATE " . $this->table_name . " SET firstname = :firstname, lastname = :lastname, email = :email, mobile = :mobile, category_id  = :category_id  WHERE id = :id";
        // prepare query
        $prep_state = $this->db_conn->prepare($sql);


        $prep_state->bindParam(':firstname', $this->firstname);
        $prep_state->bindParam(':lastname', $this->lastname);
        $prep_state->bindParam(':email', $this->email);
        $prep_state->bindParam(':mobile', $this->mobile);
        $prep_state->bindParam(':category_id', $this->category_id);
        $prep_state->bindParam(':id', $this->id);

        // execute the query
        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function delete($id)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id = :id ";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->bindParam(':id', $this->id);

        if ($prep_state->execute(array(":id" => $_GET['id']))) {
            return true;
        } else {
            return false;
        }
    }


    function getAllUsers($from_record_num, $records_per_page)
    {
        $sql = "SELECT tablename,field,datatype FROM " . $this->table_name . " ORDER BY tablename ASC LIMIT ?, ?";


        $prep_state = $this->db_conn->prepare($sql);


        $prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
        $prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);


        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
    }

    // for edit user form when filling up
    function getUser()
    {
        $sql = "SELECT firstname, lastname, email, mobile, category_id FROM " . $this->table_name . " WHERE id = :id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->bindParam(':id', $this->id);
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->email = $row['email'];
        $this->mobile = $row['mobile'];
        $this->category_id = $row['category_id'];
    }


}








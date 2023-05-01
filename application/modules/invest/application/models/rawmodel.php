
<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class DetailModel extends CI_Model
{
    public function test_join()
$tname= "startet";
    //$db1 = $this->load->database('database1', TRUE);

// Connect to second database
$db2 = $this->load->database('schemesdb', TRUE);

// Define the tables
$table1 = $this->db->dbprefix('users1');
$table2 = $db2->dbprefix($tname);

// Execute the join query
$query = $db1->query("SELECT * FROM $table1 JOIN $table2 ON $table1.column = $table2.column");
$result = $query->result_array();
}



?>
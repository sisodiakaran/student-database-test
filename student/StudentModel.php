<?php

/**
 * Description of StudentModel
 *
 * @author Karan S Sisodia <karansinghsisodia@gmail.com>
 */
class StudentModel {
    public $tstring;
    
    private $db;
    private $table = "students";
 
    public function __construct(){
//        $this->tstring = "The string has been loaded through the template.";
        $this->template = "tpl/template.php";
	$this->_connect_db();
    }
    
    private function _connect_db() {
	$this->db = mysqli_connect("localhost", "admin_sdbt", "a2ZDCEfwU4", "admin_sdbt");

	if (mysqli_connect_errno()) {
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
    }
    
    public function get_all_students() {
	$sql = "SELECT * FROM " . $this->table;
	$result = $this->db->query($sql);
	$data = array();
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
		$data[] = $row;
	    }
	}
	$this->db->close();
	return $data;
    }
    
    public function save($data = NULL) {
	if(!is_null($data)){
	    $keys = "(".implode(",", array_keys($data)).")";
	    $values = "('".implode("','", array_values($data))."')";
	    
	    $sql = "INSERT INTO " . $this->table . " " . $keys . " VALUES " . $values;

	    if ($this->db->query($sql) === TRUE) {
		$last_id = $this->db->insert_id;;
		$this->db->close();
		return $last_id;
	    } else {
		return "Error: " . $sql . "<br>" . $conn->error;
	    }

	}
    }
    
    public function update($condition, $data) {
	
    }
    
    public function delete($condition) {
	$sql = "DELETE FROM " . $this->table . " WHERE id=" . $condition;

	if ($this->db->query($sql) === TRUE) {
	    return TRUE;
	} else {
	    return FALSE;
	}
    }

}

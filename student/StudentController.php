<?php

/**
 * Description of StudentController
 *
 * @author Karan S Sisodia <karansinghsisodia@gmail.com>
 */
class StudentController {
    private $model;
 
    public function __construct($model) {
        $this->model = $model;
    }
    
    public function index() {
	$this->model->tstring = $this->model->get_all_students();
    }
    
    public function save() {
	if(isset($_POST)){
	    try {
		$result = $this->model->save($_POST);
	    } catch (Exception $ex) {
		throw new Exception("Unable to add student");
	    }
	    
	    $output = array(
		'status' => 'success',
		'data' => $result
	    );
	}
	header('Content-Type: application/json');
	echo json_encode($output);
	exit();
    }
    
    public function delete() {
	if(isset($_POST)){
	    try {
		$result = $this->model->delete($_POST['id']);
	    } catch (Exception $ex) {
		throw new Exception("Unable to delete student");
	    }
	    
	    $output = array(
		'status' => $result ? 'success' : 'error',
		'data' => $_POST['id']
	    );
	}
	header('Content-Type: application/json');
	echo json_encode($output);
	exit();
    }
}

<?php
ini_set('display_startup_errors',1);
ini_set("display_errors", "1");
error_reporting(E_ALL);

$page = isset($_GET['page']) ? $_GET['page']: 'student';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if (!empty($page)) {

    $data = array(
	'student' => array('model' => 'StudentModel', 'view' => 'StudentView', 'controller' => 'StudentController')
    );

    foreach ($data as $key => $components) {
	if ($page == $key) {
	    require_once $key . "/" . $components['model'] . ".php";
	    require_once $key . "/" . $components['view'] . ".php";
	    require_once $key . "/" . $components['controller'] . ".php";
	    
	    $model = $components['model'];
	    $view = $components['view'];
	    $controller = $components['controller'];
	    break;
	}
    }

    if (isset($model)) {
	$m = new $model();
	$c = new $controller($m);
	$c->{$action}();
	$v = new $view($m, $c);
	echo $v->output();
    }
}

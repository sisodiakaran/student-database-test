<?php

$page = $_GET['page'];

if (!empty($page)) {

    $data = array(
	'student' => array('model' => 'StudentModel', 'view' => 'StudentView', 'controller' => 'StudentController')
    );

    foreach ($data as $key => $components) {
	if ($page == $key) {
	    $model = $components['model'];
	    $view = $components['view'];
	    $controller = $components['controller'];
	    break;
	}
    }

    if (isset($model)) {
	$m = new $model();
	$c = new $controller($model);
	$v = new $view($model);
	echo $v->output();
    }
}

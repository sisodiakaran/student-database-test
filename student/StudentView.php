<?php

/**
 * Description of StudentView
 *
 * @author Karan S Sisodia <karansinghsisodia@gmail.com>
 */
class StudentView {
    private $model;
 
    public function __construct($model, $controller) {
        $this->controller = $controller;
        $this->model = $model;
    }
 
    public function output(){
        $data = $this->model->tstring;
        require_once($this->model->template);
    }
}

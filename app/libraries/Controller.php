<?php
// load model and views
// Load session helper
require_once '../app/helpers/session_helper.php';
class Controller
{
    // Load Model
    public function model($model) 
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }
    // Load views
    public function view($view, $data = [])

    {
         extract($data);
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once('../app/views/' . $view . '.php');
        } else {
            die('View does not exist');
        }
    }
}

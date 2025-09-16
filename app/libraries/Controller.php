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

 
public function repository($repository) {
    // Sanitize the repository name to prevent directory traversal attacks
    $repository = filter_var($repository, FILTER_SANITIZE_STRING);

    // Check if the file exists in the repositories directory
    if (file_exists(APPROOT . '/repositories/' . $repository . '.php')) {
        require_once APPROOT . '/repositories/' . $repository . '.php';

        // Check if the class exists
        if (class_exists($repository)) {
            // Pass the database connection to the repository's constructor
            return new $repository(new Database);
        }
    }
    // If the repository class or file does not exist, throw an error
    die('Repository does not exist.');
}
}

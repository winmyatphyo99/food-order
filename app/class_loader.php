<?php

require_once "config/config.php";
require_once "helpers/url_helper.php";
require_once "helpers/message_helper.php";
require_once "helpers/UserValidator.php";
require_once "helpers/session_helper.php";
// require_once "helpers/middleeware_helper.php";


// require_once "libraries/Database.php";
// require_once "libraries/Core.php";
// require_once "libraries/Controller.php";

spl_autoload_register(function ($class) {
    $directories = [
        
        'libraries/',
        'controllers/',
        'models/'
    ];

     // Get the base directory of the project
    $baseDir = dirname(__DIR__) . '/';


    // Loop through the directories to find and load the class file
    foreach ($directories as $dir) {
        $file = __DIR__ . '/' . $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

});

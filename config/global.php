<?php
    define('URI', $_SERVER['REQUEST_URI']);
    define("CONTROLLER", "Tasks");
    define("ACTION", "Index");
    define('ROOT', $_SERVER['DOCUMENT_ROOT']);
    define('HOST', '');//LOCAL -> Change before deploying
    define('CORE', 'core/');
    define('CONTROLLERS', 'controllers/');
    define('MODELS', 'models/');
    define('VIEWS', 'views/');
    define('SERVICE_URL', 'http://localhost/services/taskservice.php'); //LOCAL -> Change before deploying
?>
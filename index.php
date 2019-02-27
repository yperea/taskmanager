<?php
    session_start();
    
    require_once("config/global.php");
    require_once("core/Router.php");
    require_once("helpers/utils.php");

    //echo "Api Key: " . $_SESSION['apiKey'];
    $router     = new Router();

    $controllerName = $router->controller . "Controller";
    $actionName     = $router->action;
    $params         = $router->params;

    /*
    echo "Controller Name: $controllerName <br />";
    echo "Action Name: $actionName <br />";
    echo "Params: "; 
    print_r($params) . "<br />";
    
    echo print_r($_SERVER);
    */
    
    require_once(CONTROLLERS . "{$controllerName}.php");

    $controller = new $controllerName();
    $controller->$actionName($params);
?>
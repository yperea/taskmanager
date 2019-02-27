<?php
    require_once("View.php");


    abstract class Controller 
    {
        protected $view;
        protected $controllerName;

        
        protected function view($viewName = null, $model = null, $params = array())
        {
            $this->view = new View($this->controllerName, $viewName, $model, $params);
        }
/*
        protected function isSessionValid() {

            //$current_url   = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            $result = true;
    
            // If the session vars aren't set, try to set them with a cookie
            if (!isset($_SESSION['userId'])) 
            {
                $result = false;
            }
    
            return $result;
        }
*/
    }
?>
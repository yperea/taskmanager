<?php

    class View 
    {
        protected $template;
        protected $controllerName;
        protected $viewName;
        protected $messages;
        protected $params;
        protected $model;

        public function __construct($controllerName, $viewName, $model, $params) 
        {
            $this->controllerName   = $controllerName;
            $this->viewName         = $viewName;
            $this->model            = $model;
            $this->params           = $params;
            $this->render();
        }

        protected function render() 
        {
            if (class_exists($this->controllerName)) 
            {
                $this->template = $this->getContentTemplate();
                echo $this->template;
            } 
            else 
            {
                throw new Exception("{$this->controllerName} does not exist.", 1);
            }
        }

        protected function getContentTemplate() 
        {
            //Convention over Configuration
            $directoryViewName = str_replace('Controller', '', $this->controllerName);
            $viewName = $this->viewName;
            $filePath =  VIEWS . "{$directoryViewName}/{$viewName}";

            if (is_file($filePath)) 
            {
                $model = $this->model;
                $params = extract($this->params);
                ob_start();
                require_once($filePath);
                $template = ob_get_contents();
                ob_end_clean();
                return $template;
            } 
            else 
            {
                throw new Exception("$filePath does  not exist", 1);
            }
        }
    }
    
?>
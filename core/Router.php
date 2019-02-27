<?php
    class Router 
    {
        private $uri;
        private $controller;
        private $action;
        private $params;


        public function __construct()
        {
            $this->__set("uri", explode('/', URI));
            $this->__set("controller", $this->__get("uri"));
            $this->__set("action", $this->__get("uri"));
            $this->__set("params", $this->__get("uri"));
        }

        public function __get($name)
        {
            return $this->$name;
        }

        public function __set($name, $value)
        {
            switch ($name) 
            {
                case 'controller':
                    $hostArray = explode("/", HOST);
                    $position = count($hostArray);
                    $this->$name = !empty($value[$position])? ucfirst($value[$position]) : CONTROLLER;
                    break;
                    
                case 'action':
                    $hostArray = explode("/", HOST);
                    $position = count($hostArray) + 1;
                    $this->$name = !empty($value[$position])? ucfirst($value[$position]) : ACTION;
                    break;

                case 'params':
                    $hostArray = explode("/", HOST);
                    $position = count($hostArray) + 2;
                    $params = array();
                    $explodedParams = !empty($value[$position])? explode('&',$value[$position]) : array();

                    foreach ($explodedParams as $paramSet) {
                        $paramsPair = explode('=', $paramSet);
                        $params[$paramsPair[0]] = (!empty($paramsPair[1])?$paramsPair[1]:"");
                    }

                    $this->$name = $params;
                    break;

                default:
                    $this->$name = $value;
                    break;
            }
        }
    }
?>
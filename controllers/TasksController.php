<?php
    require_once("composer/vendor/autoload.php");
    require_once("core/Controller.php");


    /**
     * Class controller for tasks operations.
     */
    class TasksController extends Controller 
    {

        private $task;
        private $composerClient;
        private $userId;
        private $apiKey;


        /**
         * Initializes name of the controller, instance variables for the class
         * and Guzzle Client for REST implementation.
         */
        public function __construct() 
        {
            $this->controllerName = __CLASS__;
            $this->userId = !empty($_SESSION['userId'])?$_SESSION['userId']:0;
            $this->apiKey = !empty($_SESSION['apiKey'])?$_SESSION['apiKey']:'';

            //Guzzle Client
            $this->composerClient = new GuzzleHttp\Client();
            $this->url = SERVICE_URL;
        }

        /**
         * Call the index page.
         */
        public function index($params = null) 
        {
            parent::view("index.php"); 
        }


        /**
         * Calls the page that lists the tasks of the user
         */
        public function list($params = null) 
        {
            validateAccess();

            $userId     = $this->userId;
            $apiKey     = $this->apiKey;
            try 
            {
                $response = $this->composerClient->request("GET", $this->url, 
                            ['query'=> 
                                [
                                    'apiKey'=>$apiKey,
                                    'type'=>'tasks'
                                ]
                            ]);
        
                $response_body = $response->getBody();
                $tasks = json_decode($response_body);
            }
            catch (RequestException $ex)
            {
                echo "HTTP Request failed\n";
                echo "<pre>";
                print_r($ex->getRequest());
                echo "</pre>";
                
                if ($ex->hasResponse()) 
                {
                    echo $ex->getResponse();
                }        
            }
    
            parent::view("list.php", $tasks); 
        }


        /**
         * Calls the page that display a specific task
         */
        public function get($params = null) 
        {
            validateAccess();

            switch ($_SERVER['REQUEST_METHOD']) 
            {
                case 'POST':

                    $id         = $_POST['id'];
                    $userId     = $this->userId;
                    $apiKey     = $this->apiKey;

                    try 
                    {
                        $response = $this->composerClient->request("GET", $this->url, 
                                    ['query'=> 
                                        [
                                            'apiKey'=>$apiKey,
                                            'type'=>'tasks',
                                            'id'=>$id
                                        ]
                                    ]);
                
                        $response_body = $response->getBody();
                        $task = json_decode($response_body);
                    }
                    catch (RequestException $ex)
                    {
                        echo "HTTP Request failed\n";
                        echo "<pre>";
                        print_r($ex->getRequest());
                        echo "</pre>";
                        
                        if ($ex->hasResponse()) 
                        {
                            echo $ex->getResponse();
                        }        
                    }
                    parent::view("get.php", $task);   
                    break;
                
                case 'GET':
                    parent::view("get.php");
                    break;

                default:
                    break;
            }
        }


        /**
         * Calls the page that creates a specific task
         */
        public function create ($params = null) 
        {
            validateAccess();

            switch ($_SERVER['REQUEST_METHOD']) 
            {
                case 'POST':

                    $description = $_POST['description'];
                    $userId = $this->userId;
                    $apiKey = $this->apiKey;

                    try 
                    {
                        $response = $this->composerClient->request("POST", $this->url, 
                                    ['form_params'=>
                                        [
                                            'description'=>$description,
                                            'apiKey'=>$apiKey
                                        ]
                                    ]);
                
                        $response_body = $response->getBody();
                        $decoded_body = json_decode($response_body);

                    }
                    catch (RequestException $ex)
                    {
                        echo "HTTP Request failed\n";
                        echo "<pre>";
                        print_r($ex->getRequest());
                        echo "</pre>";
                        
                        if ($ex->hasResponse()) 
                        {
                            echo $ex->getResponse();
                        }        
                    }

                    parent::view("create.php", $decoded_body);
                    break;
                
                case 'GET':
                    parent::view("create.php");
                    break;

                default:
                    break;
            }
        }


        /**
         * Calls the page that updates a specific task
         */
        public function update($params = array())
        {
            validateAccess();

            switch ($_SERVER['REQUEST_METHOD']) 
            {
                case 'POST':
                    $userId      = $this->userId;
                    $apiKey      = $this->apiKey;
                    $id          = $_POST['id'];
                    $description = $_POST['description'];

                    try 
                    {
                        $response = $this->composerClient->request("PUT", $this->url, 
                                    ['form_params'=>
                                        [
                                            'id'=>$id,
                                            'description'=>$description,
                                            'apiKey'=>$apiKey
                                        ]
                                    ]);
                
                        $response_body = $response->getBody();
                        $task = json_decode($response_body);
                    }
                    catch (RequestException $ex)
                    {
                        echo "HTTP Request failed\n";
                        echo "<pre>";
                        print_r($ex->getRequest());
                        echo "</pre>";
                        
                        if ($ex->hasResponse()) 
                        {
                            echo $ex->getResponse();
                        }        
                    }

                    parent::view("update.php", $task);
                    break;

                case 'GET':
                    extract($params);
                    $userId = $this->userId;
                    $apiKey = $this->apiKey;

                    if (empty($id)) {
                        header("location:/". HOST ."tasks/list");
                    }

                    try 
                    {
                        $response = $this->composerClient->request("GET", $this->url, 
                                    ['query'=> [
                                            'id'=>$id,
                                            'apiKey'=>$apiKey,
                                            'type'=>"tasks"]
                                    ]);
                
                        $response_body = $response->getBody();
                        $task = json_decode($response_body);
                    }
                    catch (RequestException $ex)
                    {
                        echo "HTTP Request failed\n";
                        echo "<pre>";
                        print_r($ex->getRequest());
                        echo "</pre>";
                        
                        if ($ex->hasResponse()) 
                        {
                            echo $ex->getResponse();
                        }        
                    }

                    parent::view("update.php", $task, $params);
                    break;

                default:
                    break;
            }
        }


        /**
         * Calls the page that deletes a specific task
         */
        public function delete($params) 
        {
            validateAccess();
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $userId      = $this->userId;
                    $apiKey      = $this->apiKey;
                    $id          = $_POST['id'];

                    try 
                    {
                        $response = $this->composerClient->request("DELETE", $this->url, 
                                    ['form_params'=>
                                        [
                                            'id'=>$id,
                                            'apiKey'=>$apiKey
                                        ]
                                    ]);
                
                        $response_body = $response->getBody();
                        $task = json_decode($response_body);
                    }
                    catch (RequestException $ex)
                    {
                        echo "HTTP Request failed\n";
                        echo "<pre>";
                        print_r($ex->getRequest());
                        echo "</pre>";
                        
                        if ($ex->hasResponse()) 
                        {
                            echo $ex->getResponse();
                        }        
                    }

                    parent::view("delete.php", $task);
                    break;

                case 'GET':
                    extract($params);
                    $userId = $this->userId;
                    $apiKey = $this->apiKey;
                                        
                    if (empty($id)) {
                        header("location:/". HOST ."tasks/list");
                    }
                    
                    try 
                    {
                        $response = $this->composerClient->request("GET", $this->url, 
                                    ['query'=> 
                                        [
                                            'id'=>$id,
                                            'apiKey'=>$apiKey,
                                            'type'=>"tasks"
                                        ]
                                    ]);
                
                        $response_body = $response->getBody();
                        $task = json_decode($response_body);
                    }
                    catch (RequestException $ex)
                    {
                        echo "HTTP Request failed\n";
                        echo "<pre>";
                        print_r($ex->getRequest());
                        echo "</pre>";
                        
                        if ($ex->hasResponse()) 
                        {
                            echo $ex->getResponse();
                        }        
                    }

                    parent::view("delete.php", $task, $params);
                    break;
                    
                default:
                    break;
            }
        }

        /**
         * Calls the page that displays the tasks statistics.
         */
        public function stats($params = null) 
        {
            validateAccess();
            $userId     = $this->userId;
            $apiKey     = $this->apiKey;

            try 
            {
                $response = $this->composerClient->request("GET", $this->url, 
                            ['query'=> 
                                [
                                    'apiKey'=>$apiKey,
                                    'type'=>'statistics'
                                ]
                            ]);

                $response_body = $response->getBody();
                $tasks = json_decode($response_body);
            }
            catch (RequestException $ex)
            {
                echo "HTTP Request failed\n";
                echo "<pre>";
                print_r($ex->getRequest());
                echo "</pre>";
                
                if ($ex->hasResponse()) 
                {
                    echo $ex->getResponse();
                }        
            }
    
            parent::view("stats.php", $tasks); 
        }
        
    }
?>
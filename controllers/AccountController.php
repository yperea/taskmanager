<?php
    require_once('core/Controller.php');
    require_once("models/User.php");
   
    
    /**
     * Class controller for user account operations.
     */
    class AccountController extends Controller 
    {
        private $user;


        /**
         * Initializes name of the controller and instance variables for the class.
         */
        public function __construct() 
        {
            $this->user = new User();
            $this->controllerName = __CLASS__;
        }

        /**
         * Log into the application.
         */
        public function login($params = null) 
        {
            switch ($_SERVER['REQUEST_METHOD']) 
            {
                case 'POST':

                    $username = $_POST['userName'];
                    $password = $_POST['password'];
                    $user     = $this->user->signIn($username, $password);

                    if ($user->getId() != 0) 
                    {
                        $user->syncSession();
                        header("location:/". HOST ."tasks/index");
                    } 
                    else 
                    {
                        parent::view("login.php", $user);
                    }
                    break;
                
                case 'GET':
                    parent::view("login.php");
                    break;

                default:
                    break;
            }
        }


        /**
         * Register users to the application.
         */
        public function signup($params = null)
        {
            switch ($_SERVER['REQUEST_METHOD']) 
            {
                case 'POST':
                    $userName = $_POST['username'];
                    $password = $_POST['password'];
                    $passwordConfirmation = $_POST['password2'];

                    $user = $this->user->signUp($userName, $password, $passwordConfirmation);

                    if ($user->getId() != 0) 
                    {
                        $user = $user->getUser($user->getId());
                        $user->syncSession();
                        header("location:/". HOST ."tasks/index");
                    } 
                    else 
                    {
                        parent::view("signup.php", $user);
                    }
                    break;
                case 'GET':
                    parent::view("signup.php");
                    break;

                default:
                    # code...
                    break;
            }
        }


        /**
         * Generates the API key for the users.
         */
        public function apikey($params = null)
        {
            validateAccess();
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $userId = $_SESSION['userId'];
                    $user = $this->user->getUser($userId);
                    $user->generateApiKey();
                    $user->syncSession();

                    parent::view("apikey.php", $user);

                    break;

                case 'GET':
                    $userId = $_SESSION['userId'];
                    $user = $this->user->getUser($userId);

                    parent::view("apikey.php", $user);

                    break;
                
                default:
                    # code...
                    break;
            }
        }


        /**
         * Close the session of the application.
         */
        public function logout($params = null)
        {
            $this->user->closeSession();
            header("location:/". HOST ."tasks/index");
        }
    }
?>
<?php
    require_once(__DIR__."/../data/UserDBContext.php");


    /**
     *  Handles user account operations for the site
     * 
     *  @author Yesid Perea
     **/
    class User 
    {
		protected $id;
		protected $userName;
		protected $password;
		protected $password2;
		protected $apiKey;
        protected $createDate;
        protected $messages;

        
        /**
         * Constructor of the class
         */
        public function __construct($apiKey = null) 
        {
            $this->error = false;
            $this->messages = array();
            $this->dbContext = new UserDBContext();
            
            if (!empty($apiKey)) 
            {
                $this->getUserByApiKey($apiKey);
            }
        }   
        
        /**
         * Sets the id.
         * 
         * @param id of the user.
         */
        public function setId ($id) 
        {
			$this->id =  $id;
		}
		
        /**
         * Sets the username.
         * 
         * @param username of the account.
         */
        public function setUserName ($userName) 
        {
			$this->userName =  $userName;
		}
		
        /**
         * Sets the password for the account.
         * 
         * @param password of the account.
         */
        public function setPassword ($password) 
        {
			$this->password =  $password;
		}
		
        /**
         * Sets the password confirmations for sign up.
         * 
         * @param password confirmation.
         */
        public function setPassword2 ($password) 
        {
			$this->password2 =  $password;
		}

        /**
         * Sets the creations date for the account.
         * 
         * @param password of the account.
         */
        public function setCreateDate ($createDate) 
        {
			$this->createDate = $createDate;
		}

        /**
         * Sets the API key for the account.
         * 
         * @param apikey of the account.
         */
        public function setApiKey ($apiKey) 
        {
			$this->apiKey = $apiKey;
		}

        /**
         * Returns the id of the account.
         * 
         * @return id of the account.
         */
        public function getId () 
        {
			return $this->id;
		} 
		
        /**
         * Returns the username of the account.
         * 
         * @return username of the account.
         */
        public function getUserName () 
        {
			return $this->userName;
		} 
		
        /**
         * Returns the password of the account.
         * 
         * @return password of the account.
         */
        public function getPassword () 
        {
			return $this->password;
		} 
		
        /**
         * Returns the creation date of the account.
         * 
         * @return createdate of the account.
         */
        public function getCreateDate () 
        {
			return $this->createDate;
		} 

        /**
         * Returns the API key of the account.
         * 
         * @return apikey of the account.
         */
        public function getApiKey () 
        {

			return $this->apiKey;
		}

        /**
         * Returns a messages array of the operations.
         * 
         * @return messages array.
         */
        public function getMessages () 
        {
			return $this->messages;
		}

        /**
         * Returns the user object for a given id.
         * 
         * @param id of the account.
         * @return user object.
         */
        public function getUser($id) 
        {
            $this->setId($id);

            if (!$this->error) 
            {
                $results  = $this->dbContext->readById($id);

                if(count($results) > 0)
                {
                    $result = $results[0];
                    $this->userName = $result['username'];
                    $this->apiKey = $result['apikey'];
                    $this->createDate = $result['created'];
                }
                else
                {
                    $this->messages[] = "No records found for Id: $id.";
                }
            }
            return $this;
        }

        /**
         * Returns the user object for a given api key.
         * 
         * @param apikey of the account.
         * @return user object.
         */
        public function getUserByApiKey($apiKey) 
        {
            $this->setApiKey($apiKey);
            if (!$this->error) 
            {
                $results  = $this->dbContext->readByApiKey($apiKey);
                if(count($results) > 0)
                {
                    $result = $results[0];
                    $this->id = $result['id'];
                    $this->userName = $result['username'];
                    $this->apiKey = $result['apikey'];
                    $this->createDate = $result['created'];
                }
                else
                {
                    $this->messages[] = "No records found for Api Key: $apiKey.";
                }
            }
            return $this;
        }

        /**
         * Returns the user object once is created.
         * 
         * @param userName username for the account.
         * @param password password for the account.
         * @param password2 password confirmation for the sign up.
         * @return user object.
         */
        public function signUp ($userName, $password, $password2) 
        {
            $error = true;

            $this->setUserName($userName);
            $this->setPassword($password);
            $this->setPassword2($password2);

            if (!$this->error) 
            {
                if ($password == $password2) 
                {
                    $rows = $this->dbContext->readByUserName($userName);

                    if(count($rows) == 0)
                    {
                        $apiKey = uniqid();
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
                        $this->id = $this->dbContext->create($userName, $hashedPassword, $apiKey);
                        $error = false;
                    }
                    else
                    {
                    $this->messages[] = "The username is already taken.";
                    }
                }
                else
                {
                    $this->messages[] = "The password and its confirmation has to be equals.";
                }
            }
            else 
            {
                $this->messages[] = "Sorry, you must enter a valid data.";
            }
            return $this;
		}

        /**
         * Returns the user object once has signed in.
         * 
         * @param userName username for the account.
         * @param password password for the account.
         * @return user object.
         */
		public function signIn ($userName, $password) {
			
			$result = false;
            $this->setUserName($userName);
            $this->setPassword($password);

            if(!$this->error) 
            {
                $rows = $this->dbContext->readByUserName($userName);

                if(count($rows) == 1)
                {
                    $account = $rows[0];
                    $hashed_password = $account['password'];

                    if (password_verify($this->password, $hashed_password)) 
                    {
						$this->id		    = $account['id'];
						$this->userName     = $account['username'];
                        $this->createDate 	= $account['created'];
                        $this->apiKey       = $account['apikey'];

                        $result = true;
                    }
                    else 
                    {
                        $this->messages[] = "Sorry, you must enter a valid password to log in.";
                    }
                }
                else 
                {
                    $this->messages[] = "Sorry, you must enter a valid username and password to log in.";
                }
            }
            return $this;
        }

        /**
         * Returns the user object updated with the new API key generated.
         * 
         * @return user object.
         */
		public function generateApiKey() {

            $apiKey = uniqid();
            
            $rows = $this->dbContext->update($this->id, $apiKey);

            if ($rows != 0) 
            {
                return $this->getUser($this->id);
            } 
            else
            {
                $this->messages[] = "Api key generation error.";
            }

            return $this;
		}
        

        /**
         * Updates session variables with the most recent information of the user.
         */
        public function syncSession()
        {
            $_SESSION['userId']     = $this->getId();
            $_SESSION['userName']   = $this->getUserName();
            $_SESSION['apiKey']     = $this->getApiKey();
        }


        /**
         * Closes the session variables.
         */
        public function closeSession() 
        {
            if (isset($_SESSION['userId']))
            {
		        // Delete the session vars by clearing the $_SESSION array
                $_SESSION = array();
		        // Destroy the session
		        session_destroy();
		    }
		}        
	}
?>

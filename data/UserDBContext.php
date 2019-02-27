<?php
    require_once(__DIR__."/../config/database.php");

    /**
     * Handles the database operations for the User model.
     * 
     * @author Yesid Perea
     */
    class UserDBContext 
    {
        private $driver;
        private $host;
        private $user;
        private $password;
        private $database;
        private $charset;
        private $messages;


        /**
         * Constructor of the class.
         * Initializes database connection variables.
         */
        public function __construct() 
        {
            $this->driver   = DRIVER;
            $this->host     = DBHOST;
            $this->database = DATABASE;
            $this->user     = DBUSER;
            $this->password = DBPASS;
            $this->charset  = CHARSET;
        }

       
        /**
         * Returns the database connection.
         * 
         * @return connection object to the database. 
         */
        public function getConnection () 
        {
            switch ($this->driver) {
                case 'mysql':
                    $dsn = "{$this->driver}:host={$this->host};dbname={$this->database}";                   
                    $connection = new PDO($dsn, $this->user, $this->password);
                    break;
                
                default:
                    $dsn = "{$this->driver}:host={$this->host};dbname={$this->database}";                   
                    $connection = new PDO($dsn, $this->user, $this->password);
                    break;
            }
            return $connection;
        }

        /**
         * Returns messages of database operations.
         * 
         * @return messages array with the results of the database operations. 
         */
        public function getmessages()
        {
            return !empty($this->messages) ? $this->messages: array();
        }


        /**
         * Creates a user.
         * 
         * @param userName username for the account.
         * @param password password for the account.
         * @return id of the last record created.
         */
        public function create ($userName, $password, $apiKey) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql   = "INSERT INTO users (`username`, `password`, `apikey`) 
                      VALUES (:username, :password, :apikey)";
            try 
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":username", $userName);
                $query->bindParam(":password", $password);
                $query->bindParam(":apikey", $apiKey);
                $query->execute();

                $id    = $dbc->lastInsertId();
                $this->messages[] = "Last record Id: {$id}";

                if ($this->initializeCounters($id) == 0) 
                {
                    $this->messages[] = "Counter initialization error ocurred.";
                }
                return $id;
            }
            catch (Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }


        /**
         * Updates a User.
         * 
         * @param id of the user to update.
         * @param apikey of the user.
         * @param password of the user.
         * @return number of rows updated.
         */
        public function update($id, $apiKey=null, $password=null) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $setArray = array();
            $sql = " UPDATE users";
            $whereClause = " WHERE id = :id";

            if (!empty($apiKey)) 
            {
                $setArray[]	= "apikey = :apikey";
            }
            if (!empty($password)) 
            {
                $setArray[]	= "password = :password";
            }
            $setClause    = implode (', ', $setArray);

            try
            {
                if (!empty(trim($setClause)))
                {
                    $sql .= " SET $setClause" . $whereClause ;
                    $query = $dbc->prepare($sql);

                    if (!empty($apiKey)) 
                    {
                        $query->bindParam(":apikey", $apiKey);
                    }
        
                    if (!empty($password)) 
                    {
                        $query->bindParam(":password", $password);
                    }

                    $query->bindParam(":id", $id);
                    $query->execute();
                    $rows = $query->rowCount();
                    $this->messages[] = "{$rows} records updated.";
                    return $rows;
                }
            }
            catch (Exception $exception)
            {
                echo $exception->getMessage();
                $this->messages[] = $exception->getMessage();
            }
        }

        /**
         * Deletes a user.
         * 
         * @param id of the user to delete.
         * @return number of rows deleted.
         */
        public function delete($id) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "DELETE FROM users WHERE id = :id";

            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":id", $id);
                $query->execute();
                $rows = $query->rowCount();
                $this->messages[] = "{$rows} records deleted.";
                return $rows;
            }
            catch (Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }

        
        /**
         * Gets a user object for a given Id.
         * 
         * @param id of the user to find.
         * @return results array with the user found.
         */
        public function readById($id) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql   = "SELECT `id`, `username`, `password`, `created`, `apikey` 
                      FROM users WHERE id = :id LIMIT 1";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":id", $id);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            }
            catch(Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }


        /**
         * Gets a user object for a given username.
         * 
         * @param username of the user to find.
         * @return results array with the user found.
         */
        public function readByUserName($userName) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql   = "SELECT `id`, `username`, `password`, `created`, `apikey` 
                      FROM users WHERE username = :userName LIMIT 1";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":userName", $userName);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            }
            catch(Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }
        
        /**
         * Gets a user object for a given API key.
         * 
         * @param apikey of the user to find.
         * @return results array with the user found.
         */
        public function readByApiKey($apiKey) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql   = "SELECT `id`, `username`, `password`, `created`, `apikey` 
                      FROM users WHERE apikey = :apiKey LIMIT 1";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":apiKey", $apiKey);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            }
            catch(Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }


        /**
         * Gets all the users.
         * 
         * @return results array with the users found.
         */
        public function readAll() 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT `id`, `description` FROM tasks";

            try
            {
                $query = $dbc->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_CLASS, "User");
                return $results;
            }
            catch(Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }


	    /**
	     * Insert a record for the user to initialize the tasks Statistics.
         * 
         * @param userid id of the user.
	     */
        public function initializeCounters ($userId) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO tasks_statistics (user_id) VALUES (:userId); ";

            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":userId", $userId);
                $query->execute();
                return $query->rowCount();
            }
            catch(Exception $exception)
            {
                return 0;
            }
		}
    }
?>
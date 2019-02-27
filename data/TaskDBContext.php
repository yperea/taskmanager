<?php
    require_once(__DIR__."/../config/database.php");
    require_once("ITaskManager.php");


    /**
     * Handles the database operations for the Task model.
     * 
     * @author Yesid Perea
     */
    class TaskDBContext implements ITaskManager
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
         * Creates a task for the user.
         * 
         * @param userId id of the user owner of the task.
         * @param description of the task.
         * @return id of the last record created.
         */
        public function create ($description, $userId) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql   = "INSERT INTO tasks (`description`, `user_id`) 
                      VALUES (:description, :userId)";
            try 
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":description", $description);
                $query->bindParam(":userId", $userId);
                $query->execute();

                $id    = $dbc->lastInsertId();
                $this->messages[] = "Last record Id: {$id}";

                if ($this->logStatistics("create", $userId) == 0) {
                    $this->messages[] = "Log error ocurred.";
                }

                return $id;
            }
            catch (Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }


        /**
         * Updates a task for the user.
         * 
         * @param id of the task to update.
         * @param userId of the user owner of the task.
         * @param description of the task.
         * @return number of rows updated.
         */
        public function update($id, $description, $userId) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE tasks 
                    SET `description` = :description
                    WHERE id = :id and user_id = :userId";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":userId", $userId);
                $query->bindParam(":description", $description);
                $query->execute();

                $rows = $query->rowCount();
                $this->messages[] = "{$rows} records updated.";

                if ($rows > 0) 
                {
                    if ($this->logStatistics("update", $userId) == 0) 
                    {
                        $this->messages[] = "Log error ocurred.";
                    }
                }
                return $rows;
            }
            catch (Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }

        /**
         * Deletes a task for the user.
         * 
         * @param id of the task to delete.
         * @param userId of the user owner of the task.
         * @return number of rows deleted.
         */
        public function delete($id, $userId) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "DELETE FROM tasks WHERE id = :id and user_id = :userId";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":userId", $userId);
                $query->execute();

                $rows = $query->rowCount();
                $this->messages[] = "{$rows} records deleted.";

                if ($rows > 0) 
                {
                    if ($this->logStatistics("delete", $userId) == 0) 
                    {
                        $this->messages[] = "Log error ocurred.";
                    }
                }

                return $rows;

            }
            catch (Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }
        
        /**
         * Gets a task for a given Id and User Id.
         * 
         * @param id of the task to find.
         * @param userId of the user owner of the task.
         * @return results array with the tasks found.
         */
        public function read($id, $userId) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql   = "SELECT `id`, `description` FROM tasks 
                      WHERE id = :id and user_id = :userId LIMIT 1";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":userId", $userId);
                $query->execute();

                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                
                if ($this->logStatistics("read", $userId) == 0) 
                {
                    $this->messages[] = "Log error ocurred.";
                }
                return $results;
            }
            catch(Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }

        /**
         * Gets all of tasks for a given User Id.
         * 
         * @param userId of the user owner of the task.
         * @return results array with the tasks found.
         */
        public function readAll($userId) 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT `id`, `description` FROM tasks 
                    WHERE user_id = :userId";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":userId", $userId);
                $query->execute();
                
                $results = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($this->logStatistics("readall", $userId) == 0) 
                {
                    $this->messages[] = "Log error ocurred.";
                }
                return $results;
            }
            catch(Exception $exception)
            {
                $this->messages[] = $exception->getMessage();
            }
        }

        /**
         * Gets the tasks statistics for all users.
         * 
         * @return results array with the tasks statistics.
         */
        public function readStats() 
        {
            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT s.user_id, u.username, s.create_counter, s.read_counter, 
                           s.readall_counter, s.update_counter, s.delete_counter
                    FROM tasks_statistics s INNER JOIN users u ON s.user_id = u.id";
            try
            {
                $query = $dbc->prepare($sql);
                $query->bindParam(":userId", $userId);
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
	     * Increment the task statistic given a counter name and user id.
         * 
         * @param counterName to increment.
         * @param userId id of the user that owns the task.
         * @return number of records updated.
	     */
        public function logStatistics ($counterName, $userId) 
        {

            $dbc = $this->getConnection();
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE tasks_statistics ";
            $whereClause = "WHERE user_id = :userId";

            switch ($counterName) 
            {
                case 'create':
                    $setClause = "SET create_counter = create_counter + 1 ";
                    break;
                case 'read':
                    $setClause = "SET read_counter = read_counter + 1 ";
                    break;
                case 'readall':
                    $setClause = "SET readall_counter = readall_counter + 1 ";
                    break;
                case 'update':
                    $setClause = "SET update_counter = update_counter + 1 ";
                    break;
                case 'delete':
                    $setClause = "SET delete_counter = delete_counter + 1 ";
                    break;
                default:
                    break;
            }

            try
            {
                if(!empty($setClause)) 
                {
                    $sql .= $setClause . $whereClause ;
                    $query = $dbc->prepare($sql);
                    $query->bindParam(":userId", $userId);
                    $query->execute();

                    return $query->rowCount();
                }
            }
            catch(Exception $exception)
            {
                return 0;
            }
		}
    }
?>
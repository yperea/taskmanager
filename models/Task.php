<?php
    require_once(__DIR__."/../data/TaskDBContext.php");


    /**
     *  Handles Tasks operations.
     * 
     *  @author Yesid Perea
     **/
    class Task 
    {
        private $id;
        private $description;
        private $userId;
        private $messages;
        private $error;
        private $tasks;
        private $dbContext; 


        /**
         * Constructor of the class
         */
        public function __construct($apiKey = null) 
        {
            $this->error = false;
            $this->messages = array();
            $this->dbContext = new TaskDBContext();
        }


        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
            if (empty($id)) 
            {
                $this->error = true;
                $this->messages[] = "Id required.";
                return;
            }
            $this->id = $id;
        }
        

        /**
         * Get the value of id
         */ 
        public function getId()
        {
            return $this->id;
        }


        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
            return $this->description;
        }


        /**
         * Set the value of description
         *
         * @param description of the task.
         * @return  self
         */ 
        public function setDescription($description)
        {
            if (empty($description)) 
            {
                $this->error = true;
                $this->messages[] = "Field description required.";
                return;
            }
            $this->description = $description;
        }


        /**
         * Set the value of user id
         *
         * @param userid of the owner of the task.
         * @return  self
         */ 
        public function setUserId($userId)
        {
            if (empty($userId)) 
            {
                $this->error = true;
                $this->messages[] = "User Id required.";
                return;
            }
            $this->userId = $userId;
        }
        

        /**
         * Get the value of user id
         */ 
        public function getUserId()
        {
            return $this->userId;
        }


        /**
         * Get the value of Messages
         */ 
        public function getMessages()
        {
            return !empty($this->messages) ? $this->messages: array();
        }


        /**
         * Get the tasks
         */ 
        public function getTasks()
        {
            return !empty($this->tasks) ? $this->tasks: array();
        }


        /**
         * Creates a task.
         * 
         * @param description Task description.
         * @return task Task object.
         */         
        public function create($description, $userId)
        {
            $this->setDescription($description);
            $this->setUserId($userId);

            if (!$this->error) 
            {
                $result = $this->dbContext->create($description, $userId);
                $this->id = $result;
                $this->messages[] = "Last record Id: {$this->id}";
            }
            return json_encode($result, JSON_PRETTY_PRINT);
        }


        /**
         * Updates a task.
         * 
         * @param id Task id.
         * @param description Task description.
         * @return task Task updated.
         */         
        public function update($id, $description, $userId)
        {
            $this->setId($id);
            $this->setDescription($description);
            $this->setUserId($userId);

            if (!$this->error) 
            {
                $result = $this->dbContext->update($id, $description, $userId);
                $this->messages[] = "{$result} records updated.";
            }
            return json_encode($result, JSON_PRETTY_PRINT);
        }


        /**
         * Deletes a task for given Id and User Id. 
         * 
         * @param id Task id.
         * @return task Task deleted with the result message.
         */         
        public function delete($id, $userId)
        {
            $this->setId($id);
            $this->setUserId($userId);

            if (!$this->error) 
            {
                $result = $this->dbContext->delete($id, $userId);
                $this->messages[] = "{$result} records deleted.";
                $this->id = null;
            }
            return json_encode($result, JSON_PRETTY_PRINT);
        }


        /**
         * Get a task for a given Id and User Id.
         * 
         * @param id Task id.
         * @return task Task for the Id given.
         */         
        public function get($id, $userId)
        {
            $this->setId($id);
            $this->setUserId($userId);

            $results = array();

            if (!$this->error) {
                
                $results = $this->dbContext->read($id, $userId);

                if(count($results) > 0)
                {
                    $result = $results[0];
                    $this->description = $result['description'];
                }
                else
                {
                    $this->messages[] = "No records found for Id: $id.";
                }
            }
            return json_encode($results, JSON_PRETTY_PRINT);
        }


        /**
         * Get the tasks associated to the User Id.
         * 
         * @return tasks Collection of Tasks.
         */         
        public function getAll($userId)
        {
            $this->setUserId($userId);

            $result = array();

            if (!$this->error) 
            {
                $result = $this->dbContext->readAll($userId);
                
                if(count($result) == 0)
                {
                    $this->messages[] = "No records found.";
                }
                
            }
            return json_encode($result, JSON_PRETTY_PRINT);
        }
       

        /**
         * Get the task statistics for all users.
         * 
         * @return statistics Collection of Tasks statistics.
         */         
        public function getStatistics()
        {
            $result = array();

            if (!$this->error) 
            {
                $result = $this->dbContext->readStats();
                
                if(count($result) == 0)
                {
                    $this->messages[] = "No records found.";
                }
            }
            return json_encode($result, JSON_PRETTY_PRINT);
        }
    }
?>
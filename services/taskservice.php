<?php
    require_once("../models/Task.php");
    require_once("../models/User.php");

    $httpVerb = $_SERVER['REQUEST_METHOD']; // HTTP VERB: POST, GET, PUT, DELETE

    switch ($httpVerb) {


        case 'GET': // Return a set of tasks
            header("content-type:application/json");
            $task = new Task();
               
            if (isset($_GET['apiKey'])) 
            {
                $user = new User($_GET['apiKey']);

                if (isset($_GET['type'])) 
                {
                    if ($_GET['type'] == "statistics") 
                    {
                        // Returns the tasks statistics.
                        echo $task->getStatistics(); 
                    } 
                    else 
                    {
                        $userId = $user->getId();
    
                        if (isset($_GET['id'])) 
                        {
                            $id = $_GET['id'];

                            // Returns a specific task.
                            echo $task->get($id, $userId); 
                        } 
                        else 
                        {
                            // Returns all the the tasks of a user.
                            echo $task->getAll($userId); 
                        }
                    }
                 }
                 else 
                 {
                    throw new Exception("Invalid GET request parameters.");
                 }
            }
            else 
            {
                throw new Exception("Invalid Api Key.");
            }
            break;


        case 'POST': // Creates a task.

            if (isset($_POST['apiKey'])) 
            {
                $user = new User($_POST['apiKey']);
                
                if (isset($_POST['description'])) 
                {
                    $task = new Task();
                    $description = $_POST['description'];
                    $userId = $user->getId();

                    // Returns the id of the task created
                    echo $task->create($description, $userId); 
                } 
                else 
                {
                    throw new Exception("Invalid POST request parameters");
                }
            }
            else 
            {
                throw new Exception("Invalid Api Key.");
            }
            break;

            
        case 'PUT': // Updates a task
            parse_str(file_get_contents("php://input"), $requestVars);

            if (isset($requestVars['apiKey'])) 
            {
                $user = new User($requestVars['apiKey']);
            
                if (isset($requestVars['id'])
                    && isset($requestVars['description'])) 
                {
                    $task = new Task();
                    $userId = $user->getId();
                    $id = $requestVars['id'];
                    $description = $requestVars['description'];

                    // Returns the number of tasks updated
                    echo $task->update($id, $description, $userId); 
                } 
                else 
                {
                    throw new Exception("Invalid PUT request parameters");
                }
            }
            else 
            {
                throw new Exception("Invalid Api Key.");
            }
        
            break;
        
        
        case 'DELETE': // Deletes a task
            parse_str(file_get_contents("php://input"), $requestVars);

            if (isset($requestVars['apiKey'])) 
            {
                $user = new User($requestVars['apiKey']);
            
                if (isset($requestVars['id'])) 
                {
                    $task = new Task();
                    $userId = $user->getId();
                    $id = $requestVars['id'];

                    // Returns the number of the tasks deleted.
                    echo $task->delete($id, $userId); 
                } 
                else 
                {
                    throw new Exception("Invalid DELETE request parameters");
                }
            }
            else 
            {
                throw new Exception("Invalid Api Key.");
            }
            break;

        default:
            # code...
            break;
    }

?>
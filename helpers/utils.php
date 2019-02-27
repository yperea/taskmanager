<?php
    function validateAccess() 
    {
        if (!isset($_SESSION['userId'])) 
        {
            header("location:/". HOST ."tasks/index");
        }
    }
?>
<?php
    function validateAccess() 
    {
        if (!isset($_SESSION['userId'])) 
        {
            header("location:/". HOST ."tasks/index");
        }
    }

    //xss mitigation functions
    function xssSafe($data, $encoding='UTF-8')
    {
        return htmlspecialchars($data,ENT_QUOTES | ENT_HTML5, $encoding);
    }

    function xssEcho($data)
    {
        echo xssSafe($data);
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Task Manager Service">
    <meta name="author" content="Yesid Perea">
    <title>Task Manager - <?=$title?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous" />

  </head>

  <body class="bg-light">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="/<?=HOST.CONTROLLER?>/index">Task Manager Portal</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">
        <?php if (isset($_SESSION['userId'])) : ?>
          <li class="nav-item active">
            <a class="nav-link" href="/<?=HOST.CONTROLLER?>/index">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/<?=HOST.CONTROLLER?>/stats">Statistics</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown08" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Task Manager</a>
            <div class="dropdown-menu" aria-labelledby="dropdown08">
              <a class="dropdown-item" href="/<?=HOST.CONTROLLER?>/list">Task List</a>
              <a class="dropdown-item" href="/<?=HOST.CONTROLLER?>/create">New Task</a>
              <a class="dropdown-item" href="/<?=HOST.CONTROLLER?>/get">Get Task</a>
            </div>
          </li>
          <?php endif; ?>
        </ul>

        <!-- Right menu navigation bar -->    
        <ul class="navbar-nav justify-content-end">
          <?php if (!isset($_SESSION['userId'])) : ?>
            <li class="nav-item"><a class="nav-link" href="/<?=HOST."account"?>/signup"> Sign Up</a></li>
            <li class="nav-item"><a class="nav-link" href="/<?=HOST."account"?>/login"> Login</a></li>
          <?php else : ?>
            <li class="nav-item"><a class="nav-link" href="/<?=HOST."account"?>/apikey"> API Key</a></li>          
            <li class="nav-item"><a class="nav-link" href="/<?=HOST."account"?>/logout"> Log Out (<?= xssEcho($_SESSION['userName'])?>)</a></li>
          <?php endif; ?>
        </ul>        
      </div>
    </nav>
  
    <div class="container">
      <div class="py-5 text-center">
        <h2><?=$title?></h2>
      </div>

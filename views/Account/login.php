<?php 
    $title = "Log In";
    require_once("views/shared/header.php");    

    if (isset($model)) 
    {
        $messages    = $model->getMessages();
    }

?>

<div class="row">
    <div class="col-md-12 order-md-1">
        
        <?php if (!empty($messages)) : ?>
        <div class="alert alert-warning" role="alert">
            <ul>
                <?php foreach ($messages as $message) : ?>
                    <li><?= $message;?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif;?>
        

        <form class="needs-validation"
            method="post"
            action=""
            novalidate>

            <div class="mb-3">
              <label for="userName">User Name:</label>
              <input type="userName"
                     class="form-control"
                     id="userName"
                     name="userName"
                     placeholder="Enter your username"
                     value="<?=!empty($userName)? $userName : "";?>"
                     required />
              <small class="text-muted"></small>
              <div class="invalid-feedback" style="width: 100%;">
                Please enter a username.
              </div>
            </div>

            <div class="mb-3">
              <label for="password">Password</label>
              <input type="password"
                     class="form-control"
                     id="password"
                     name="password"
                     placeholder="Password"
                     value=""
                     maxlength="30"
                     required />
              <div class="invalid-feedback">
                Please enter your password.
              </div>
            </div>

            <br />
            <button class="btn btn-primary btn-lg btn-block"
                    type="submit"
                    name="submit">Submit</button>
        </form>
    </div>
</div>

<?php require_once ("views/shared/footer.php"); ?>
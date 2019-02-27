<?php 
    $title = "API Key Generator";
    require_once("views/shared/header.php");    

    if (isset($model)) 
    {
        $userId     = $model->getId();
        $apikey     = $model->getApiKey();
        $messages   = $model->getMessages();
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
            action="">

            <input type="hidden" 
                   name="apikey" 
                   id="apikey" 
                   value="<?=!empty($apikey)? $apikey : "";?>"
                   />

            <div class="mb-3">
              <label for="apikey">Api Key:</label>
              <input type="text"
                     class="form-control"
                     id="apikey"
                     name="apikey"
                     value="<?=!empty($apikey)? $apikey : "";?>"
                     readonly />
              <small class="text-muted"></small>
              <div class="invalid-feedback" style="width: 100%;">
                Please enter an apikey.
              </div>
            </div>

            <br />
            <button class="btn btn-primary btn-lg btn-block"
                    type="submit"
                    name="submit">Generate a new API KEY</button>
        </form>
    </div>
</div>

<?php require_once ("views/shared/footer.php"); ?>
<?php 
    $messages = array();
    if (isset($model)) 
    {
        if ( count($model)>0) 
        {
            $id          = $model[0]->id;
            $description = $model[0]->description;
        } 
        else 
        {
            $messages[] = "No records found.";
        }
    }

    $title = "Get Task";
    require_once("views/shared/header.php");    
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

            <div class="mb-3">
                <label for="id">Id</label>
                <input type="text"
                        class="form-control"
                        id="id"
                        name="id"
                        placeholder="Task id..."
                        value="<?=!empty($id)? $id : "";?>"
                         />
                <div class="invalid-feedback" style="width: 100%;">
                    Please enter the task id.
                </div>
            </div>

            <div class="mb-3">
                <label for="description">Description</label>
                <input type="text"
                        class="form-control"
                        id="description"
                        name="description"
                        placeholder="Task description..."
                        value="<?=!empty($description)? $description : "";?>"
                        readonly />
            </div>

            <br />
            <button class="btn btn-primary btn-lg btn-block"
                    type="submit"
                    name="submit">Submit</button>
        </form>

    </div>
</div>

<?php require_once ("views/shared/footer.php"); ?>
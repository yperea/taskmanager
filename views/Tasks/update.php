<?php 
    $title = "Updating Task";
    require_once("views/shared/header.php");    

    $displayForm = false;
    $messages = array();

    if (isset($model)) 
    {
        
        if (gettype($model[0]) == "object") {
            $id          = $model[0]->id;
            $description = $model[0]->description;
            $displayForm = true;
        } else {
            $rowsAffected     = $model;
            $messages[] = "{$rowsAffected} records updated.";
        }
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

        <?php if ($displayForm) : ?>
            <form class="needs-validation"
                method="post"
                action="">

                <div class="mb-3">
                    <label for="id">Id</label>
                    <input type="text"
                            class="form-control"
                            id="id"
                            name="id"
                            value="<?=!empty($id)? $id : "";?>"
                            readonly />
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <input type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            placeholder="Task description..."
                            value="<?=!empty($description)? xssEcho($description) : "";?>"
                            />
                    <div class="invalid-feedback" style="width: 100%;">
                        Please enter a description for the task.
                    </div>
                </div>

                <br />
                <button class="btn btn-primary btn-lg btn-block"
                        type="submit"
                        name="submit">Update Task</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once ("views/shared/footer.php"); ?>
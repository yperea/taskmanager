<?php 
    $title = "Create a Task";
    require_once("views/shared/header.php");    

    if (!empty($model)) 
    {
        $id = $model;
        $messages[] = "Task Id [<b>{$id}</b>] created.";
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
                   name="userId"
                   id="userId"
                   value="1" />

            <div class="mb-3">
                <label for="description">Description</label>
                <input type="text"
                        class="form-control"
                        id="description"
                        name="description"
                        placeholder="Task description..."
                        value="<?=!empty($description)? $description : "";?>"
                         />
                <div class="invalid-feedback" style="width: 100%;">
                Please enter a description for the task.
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
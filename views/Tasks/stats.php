<?php
    $title = "Tasks Statistics";
    require_once("views/shared/header.php");
?>

<div class="row">
    <div class="col-md-12 order-md-1">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">User</th>
                    <th scope="col">Create</th>
                    <th scope="col">Read</th>
                    <th scope="col">Read All</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $task) : ?>
                <tr>
                    <!--<th scope="row"><?/*= htmlspecialchars($task->username, ENT_QUOTES, 'UTF-8');*/?></th>-->
                    <th scope="row"><?= xssEcho($task->username)?></th>
                    <td><?= $task->create_counter;?></td>
                    <td><?= $task->read_counter;?></td>
                    <td><?= $task->readall_counter;?></td>
                    <td><?= $task->update_counter;?></td>
                    <td><?= $task->delete_counter;?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>
</div>

<?php require_once ("views/shared/footer.php"); ?>
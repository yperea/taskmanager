<?php 
    $title = "List of Tasks";
    require_once("views/shared/header.php");
?>

<div class="row">
    <div class="col-md-12 order-md-1">

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Description</th>
                <th class="text-center" scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $task) : ?>
                <tr>
                <th scope="row"><?= $task->id;?></th>
                <td><?= xssEcho($task->description);?></td>
                <td class="text-center"><a href="/<?=HOST?>tasks/update/id=<?= $task->id;?>">Edit</a></td>
                <td class="text-center"><a href="/<?=HOST?>tasks/delete/id=<?= $task->id;?>">Delete</a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>
</div>

<?php require_once ("views/shared/footer.php"); ?>
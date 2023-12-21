<?php
ob_start();
?>

<section class="sectionView">

    <div id="modalDelete" class="modal">
        <div>
            <p>Voulez-vous vraiment suprimer votre liste ?</p>
            <p>Vous allez perdre toute vos tâches associées !</p>
            <div>
                <button type="button" id="btnUndoDel" name="button">Annuler</button>
                <form class="formDelete" action="/dashboard/<?php echo escape($todo->getName()); ?>/delete"
                    method="post">
                    <input type="hidden" name="idList" value="<?php echo escape($todo->getId()); ?>">
                    <button type="submit" name="button">Supprimer</button>
                </form>
            </div>
        </div>
    </div>

    <div class="viewList">
        <div class="top">
            <div class="enleveTodolist">
                <div class="showEdit">
                    <p class="nameList">
                        <?php echo escape($todo->getName()); ?>
                    </p>
                    <p class="hoverInfo">Edit Tache</p>
                </div>
            </div>

            <div class="afficheInput hiddenEdit">
                <form class="formEdit" action="/dashboard/<?php echo escape($todo->getName()); ?>" method="post">
                    <div class="labelInput">
                        <label for="nameTodo"><i class="fas fa-pen"></i></label>
                        <input type="text" name="nameTodo"
                            value="<?php echo old("nameTodo") ? old("nameTodo") : escape($todo->getName()); ?>"
                            placeholder="edit todo">
                    </div>
                    <button type="submit" name="button"><i class="fas fa-check"></i></button>
                </form>
                <p id="btnDeleteList"><i class="fas fa-trash"></i></p>
            </div>

            <span class="error">
                <?php echo error("nameTodo"); ?>
            </span>
        </div>

        <div class="separateur"></div>

        <div class="bottom">

            <div class="blockTask">
                <?php
                foreach ($todo->tasks() as $task) {
                    ?>
                    <div class="task">
                        <?php if ($task->getCheckTask() == "no") {
                            ?>
                            <h2>
                                <?= escape($task->getName()); ?>
                            </h2>
                            <form
                                action="/dashboard/<?= escape($todo->getName()); ?>/task/<?= escape($task->getName()); ?>/check"
                                method="post">
                                <input type="hidden" name="nameList" value="<?= $todo->getName(); ?>">
                                <input type="hidden" name="task_id" value="<?= escape($task->getId()); ?>">
                                <input type="hidden" name="check" value="<?= escape($task->getCheckTask()); ?>">
                                <button class="btnCheckTrue">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        <?php } else {
                            ?>
                            <h2 class="check">
                                <?= escape($task->getName()); ?>
                            </h2>
                            <form
                                action="/dashboard/<?= escape($todo->getName()); ?>/task/<?= escape($task->getName()); ?>/check"
                                method="post">
                                <input type="hidden" name="nameList" value="<?= $todo->getName(); ?>">
                                <input type="hidden" name="task_id" value="<?= escape($task->getId()); ?>">
                                <input type="hidden" name="check" value="<?= escape($task->getCheckTask()); ?>">
                                <button class="btnCheckFalse">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        <?php }
                        ?>
                    </div>
                    <div class="afficheInput hiddenEdit">
                        <form class="formEdit" action="/dashboard/<?php echo escape($task->getName()); ?>" method="post">
                            <div class="labelInput">
                                <label for="nameTodo"><i class="fas fa-pen"></i></label>
                                <input type="text" name="nameTodo"
                                    value="<?php echo old("nameTodo") ? old("nameTodo") : escape($task->getName()); ?>"
                                    placeholder="edit todo">
                            </div>
                            <button type="submit" name="button"><i class="fas fa-check"></i></button>
                        </form>
                        <p id="btnDeleteTask"><i class="fas fa-trash"></i></p>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="blockForm">
                <form action="/dashboard/task/nouveau" method="post">
                    <i class="iconTask fas fa-tasks"></i>
                    <input type="text" name="nameTask" value="<?php echo old("nameTask"); ?>" placeholder="create task">
                    <input type="hidden" name="nameList" value="<?php echo $todo->getName(); ?>">
                    <input type="hidden" name="list_id" value="<?php echo $todo->getId(); ?>">
                    <button type="submit" name="button"><i class="fas fa-plus"></i></button>
                </form>
                <span class="error">
                    <?php echo error("nameTask"); ?>
                </span>
            </div>
        </div>
    </div>
</section>



<script>
    let showEdit = document.getElementsByClassName('showEdit');

    let enleveTodolist = document.getElementsByClassName('enleveTodolist');
    let afficheInput = document.getElementsByClassName('afficheInput');

    Array.from(showEdit).map(function (element, index) {
        element.addEventListener('click', function () {
            enleveTodolist[index].style.display = 'none';
            afficheInput[index].style.display = 'flex';
        })
    })

    let btnDelete = document.getElementById('btnDeleteList');
    let btnUndoDel = document.getElementById('btnUndoDel');
    let modalDelete = document.getElementById('modalDelete');

    btnDelete.addEventListener('click', function () {
        console.log(2);
        modalDelete.style.display = 'flex';
    });

    btnUndoDel.addEventListener('click', function () {
        console.log(2);
        modalDelete.style.display = 'none';
    });

    const titres = document.querySelectorAll(".task > h2");
    titres.forEach(titre => {
        const edit = titre.parentElement.nextSibling.nextSibling;
        const task = titre.parentElement;
        titre.addEventListener("click", () => {
            const tasks = document.getElementsByClassName("task");
            const edits = document.getElementsByClassName("afficheInput");
            Array.from(edits).forEach(e => {
                e.classList.add("hiddenEdit")
            });
            Array.from(tasks).forEach(e => {
                e.classList.remove("hiddenEdit");
            });
            edit.classList.remove("hiddenEdit");
            task.classList.add("hiddenEdit");
        })
    });

</script>

<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';

<?php
session_start();
$title = "Todo list";
$login = true;
$is_error = false;
$doSomething = false;


if (@$_SESSION["login"]) {
    // TODO: change to getting from DB

    require 'db1.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $task = $_POST['task'] ?? "";
        $action = $_POST['action'] ?? "";
        $id = $_POST['id'];
        $checkTask = $_POST['chekTask'];


        if ($action == "add") {
            if (!empty($task)) {
                $sqlInsert = "INSERT INTO tasks (task) VALUES ('$task')";
                mysqli_query($db1, $sqlInsert);
                header('Location: index.php');
                exit();
            } else {
                $is_error = true;
            }
        } else if ($action == "update") {
            function updateTack($checkTask, $id, $db1)
            {
                $sqlUpdate = "UPDATE tasks SET chek='$checkTask' WHERE id=" . $id;
                mysqli_query($db1, $sqlUpdate);
            }
            updateTack($checkTask, $id, $db1);


        } else if ($action == "delete") {
            $sqlDelete = "DELETE FROM tasks WHERE id=" . $id;
            mysqli_query($db1, $sqlDelete);
            header('Location: index.php');
            exit();
        }

    }
} else {
    header('Location: login.php');
    exit();
}


require_once "header.php";
?>
<div class="container">
    <div>
        <?php
        if ($is_error) {
            echo '<div style="color: red">We have error</div>';
        }
        if ($doSomething) {
            echo '<div style="color: green">Done</div>';
        }
        ?>

    </div>
    <div class="todo">
        <h1>Todo list</h1>
        <form action="/" method="post" name="todoForm">
            <input type="hidden" name="action" id="task" value="add">
            <input type="text" name="task">
            <input type="submit" value="Send">
            <input type="hidden" name="id" id="taskId" class="qqq" value="">
            <input type="hidden" name="chekTask" id="chekTask" value="0">
            <h1>Task</h1>
            <div class="listTask" id="main">
                <?php
                $sqlSelect = "SELECT * FROM tasks";
                $tasks = mysqli_query($db1, $sqlSelect) or die(mysqli_error($db1));

                $i = 1;
                while ($row = mysqli_fetch_array($tasks)) { ?>
                    <div class="oneTask" id="<?php echo $row['id'] ?>">
                        <input class="chek" type="checkbox"
                               value="" <?php echo ($row["chek"] ? "checked" : "");?>>
                        <p <?php if ($row["chek"]) {
                            echo 'style="text-decoration: line-through"';
                        }
                        ?>><?php echo $row["task"]; ?></p>
                        <button class="btn"></button>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
        </form>

    </div>
    <div class="logout">
        <button id="buttonLogout" onclick="window.location.href='logout.php'">Logout</button>
    </div>
</div>

<script>
    function changeId(e) {
        let input = document.getElementById('taskId');
        const id = e.target.parentElement.getAttribute('id')
        input.setAttribute('value', id);
        document.forms['todoForm'].submit();
    }

    document.getElementById('main').addEventListener('click', (e) => {
        if (e.target.classList.contains('btn')) {
            document.getElementById('task').value = "delete"
            changeId(e)
        }
        if (e.target.classList.contains('chek')) {
            document.getElementById('task').value = "update"
            if (e.target.checked) {
                document.getElementById('chekTask').value = '1';
            } else {
                document.getElementById('chekTask').value = '0';
            }


            changeId(e)
        }
    });


</script>

<?php
require_once "footer.php";
?>

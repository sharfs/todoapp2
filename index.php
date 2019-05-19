<?php
    $errors = "";
//connect to database
    $db = mysqli_connect('localhost', 'root', '', 'todoapp');

    if(isset($_POST['submit'])){
        $task = $_POST['task'];
        if(empty($task)){
            $errors = "You must input a task.";
        }else{
            mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
            header('location: index.php');
        }
    }

    //delete task
    if(isset($_GET['del_task'])){
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
        header('location: index.php');
    }

    $tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY task");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="heading">
    <h2>My To-Do List:</h2>
    </div>

    <form method="POST" action="index.php">
        <?php if (isset($errors)){ ?>
            <p><?php echo $errors; ?></p>
           <?php  }?>
        <input type="text" name="task" class="task_input">
        <button type="submit" class="task_btn" name="submit">Add Task</button>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Task</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1;
                while($row = mysqli_fetch_array($tasks)){ ?>
                   
                   <tr>
                    <td><?php echo $i?></td>
                    <td class="task"><?php echo $row['task'];?></td>
                    <td class="delete">
                        <a href="index.php?del_task= <?php echo $row['id'];?>">x</a>
                    </td>
                </tr>

               <?php $i++; } ?>
                
            </tbody>

        </table>
    
    </form>
</body>
</html>
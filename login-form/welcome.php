<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>


<?php
    $errors = "";
//connect to database
    $db = mysqli_connect('localhost', 'sharfaa', 'sharfaa', 'reg');
    require_once "config.php";

    if(isset($_POST['submit'])){
        $due = $_POST['duedate'];
        $task = $_POST['task'];
        $username = $_SESSION["username"];
        if(empty($task)){
            $errors = "You must input a task.";
        }else{
            mysqli_query($db, "INSERT INTO tasks (task, duedate) VALUES ('$task', '$due')");
            header('location: welcome.php');
        }
    }

    // if(isset($_POST['submit'])){
    //     $due = $_POST['due'];
    //     if(empty($due)){
    //         $errors = "You must input a task.";
    //     }else{
    //         mysqli_query($db, "INSERT INTO tasks (duedate) VALUES ('$due')");
    //         header('location: index.php');
    //     }
    // }

    //delete task
    if(isset($_GET['del_task'])){
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
        header('location: welcome.php');
    }

    $tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY task");
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>To-Do List</title>
    <link rel="stylesheet" type="text/css" href="css/stylist.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to your To-Do List.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
    <div class="heading">
    <h2>My To-Do List:</h2>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php if (isset($errors)){ ?>
            <p><?php echo $errors; ?></p>
           <?php  }?>
        <input type="text" name="task" class="task_input">
        <input type="date" id="start" name="duedate" class="task_input" min="2019-05-21" max="2019-12-31" required>
        <!-- <input type="date" name="due" class="task_input"> -->
        <button type="submit" class="task_btn" name="submit">Add Task</button>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Task</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1;
                while($row = mysqli_fetch_array($tasks)){ ?>
                   
                   <tr>
                    <td><?php echo $i?></td>
                    <td class="task"><?php echo $row['task'];?></td>
                    <td class="due"><?php echo $row['duedate'];?></td>
                    <td class="delete">
                        <a href="welcome.php?del_task= <?php echo $row['id'];?>">x</a>
                    </td>
                </tr>

               <?php $i++; } ?>
                
            </tbody>

        </table>
    
    </form>
</body>
</html>
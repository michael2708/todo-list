<?php
    $error = "";

    $con = mysqli_connect('localhost', 'root', '', 'todo');

    if ($con -> connect_error) {
        echo "Failed to connect to MySQL: " . $con -> connect_error;
        exit();
    }


    if (isset($_POST['submit'])) {
        $task = $_POST['task'];
        if (empty($task)) {
            $error = "enter a task description";
        }else {
            mysqli_query($con, "INSERT INTO tasks(task) VALUES ('$task')");
            header('location: index.php');
        }
        
    }

    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
        mysqli_query($con, "DELETE FROM tasks WHERE id=$id");
        header('location: index.php');
    }

    $tasks = mysqli_query($con, "SELECT * FROM tasks")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Application</title>
</head>
<body>
    <h2>Todo Application</h2>
    <form action="index.php" method="post">
    <?php if (isset($error)) { ?>
        <h3><?php echo $error; ?></h3>
    <?php } ?>

        <input type="text" name="task">
        <button type="submit" name="submit">Add</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Task</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
            <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['task']; ?></td>
            <td>
                <a href="index.php?del_task=<?php echo $row['id']; ?>">x</a>
            </td>
        </tr>
        <?php $i++ ;} ?>
            
        </tbody>
    </table>
</body>
</html>
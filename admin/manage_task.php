<?php
require_once '../Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managed task</title>
</head>
<body>
    <h3>Managed task</h3><br>
    <table class="table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Task Id</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sno = 1;
        $query = "SELECT * FROM tasks";
        $query_run = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($query_run)){
            ?>
            <tr>
                <td><?php echo $sno;?></td>
                <td><?php echo $row['tid'];?></td>
                <td><?php echo $row['description'];?></td>
                <td><?php echo $row['start_date'];?></td>
                <td><?php echo $row['end_date'];?></td>
                <td><?php echo $row['status'];?></td>
                <td>
                    <a href="edit_task.php?id=<?php echo $row['tid'];?>">Edit</a> |
                    <a href="delete_task.php?id=<?php echo $row['tid'];?>">Delete</a>
                </td>
            </tr>
            <?php
            $sno++;
        }
        ?>
        </tbody>
    </table>
</body>
</html>

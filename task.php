<?php
session_start();
// Include the Database.php file which contains the database connection code
require_once 'Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
    <h3>Your Tasks</h3><br>
    <table class="table" >
        <tr>
            <th>s.no</th>
            <th>Task id</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $sno=1;
        $query = "select * from tasks where uid = $_SESSION[uid]";
        $query_run = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($query_run)){
            ?>
            <tr>
                <td><?php echo $sno;?></td>
                <td><?php echo $row['tid'];?></td>
                <td><?php echo $row['description'];?></td>
                <td><?php echo $row['start_date'];?></td>
                <td><?php echo $row['end_date'];?></td>
                <td><?php echo $row['status'];?></td>
                <td><a href="update_status.php?id=<?php echo $row['tid'];?>">Update</a></td>
            </tr>
            <?php
            $sno++;
        }
        ?>
    </table>
    
</body>
</html>
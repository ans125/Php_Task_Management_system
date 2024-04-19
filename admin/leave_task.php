<?php
require_once '../Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managed Task</title>
</head>
<body>
    <h3>Managed task</h3><br>
    <table class="table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>User</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sno = 1;
        $query = "SELECT * FROM leaves";
        $query_run = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($query_run)){
            ?>
            <tr>
                <td><?php echo $sno;?></td>
                <?php 
                $query1 = "SELECT name FROM users WHERE uid = $row[uid]";
                $query_run1 = mysqli_query($conn, $query1);
                while($row1 = mysqli_fetch_assoc($query_run1)){
                    ?>
                <td><?php echo $row1['name'];?></td>
                <?php
                }
                ?>
                <td><?php echo $row['subject'];?></td>
                <td><?php echo $row['message'];?></td>
                <td><?php echo $row['status'];?></td>
                <td>
                    <a href="approve_leave.php?id=<?php echo $row['lid'];?>">APPROVED</a> |
                    <a href="reject_leave.php?id=<?php echo $row['lid'];?>">REJECT</a>
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

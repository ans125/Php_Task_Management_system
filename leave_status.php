<?php
// Start the session
session_start();

// Include the Database class
require_once 'Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>TMS</title>
</head>
<body>
<h3>Managed task</h3><br>
<div class="row">
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
        // Counter for serial number
        $sno = 1;

        // Prepare and execute query to fetch user's leaves
        $query = "SELECT * FROM leaves WHERE uid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_SESSION['uid']);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch leaves and display in the table
        while($row = $result->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo $sno;?></td>
                <td><?php echo $_SESSION['uid'];?></td> <!-- Display user ID -->
                <td><?php echo htmlspecialchars($row['subject']);?></td> <!-- Escape HTML characters -->
                <td><?php echo htmlspecialchars($row['message']);?></td> <!-- Escape HTML characters -->
                <td><?php echo htmlspecialchars($row['status']);?></td> <!-- Escape HTML characters -->
                <td><!-- Action buttons can be added here --></td>
            </tr>
            <?php
            $sno++;
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

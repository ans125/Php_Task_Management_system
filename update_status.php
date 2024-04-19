<?php
// Include Database class
require_once 'Database.php';

try {
    // Create a new instance of the Database class and establish connection
    $database = new Database();
    $conn = $database->getConnection();

    // Check if the form for editing task status is submitted
    if(isset($_POST['edit_task'])){
        // Prepare SQL statement to update task status
        $query = "UPDATE tasks SET status = ? WHERE tid = ?";
        $stmt = $conn->prepare($query);
        // Bind parameters to the prepared statement
        $stmt->bind_param("si", $_POST['status'], $_GET['id']);

        // Execute the statement
        if($stmt->execute()){
            // Task status updated successfully, redirect to admin dashboard
            echo "<script type='text/javascript'>
                alert('Status updated successfully');
                window.location.href = 'user_dashboard.php';
                </script>";
            exit(); // Exit to prevent further execution
        } else {
            // Throw an exception if task status update fails
            throw new Exception("Task status update failed.");
        }
    }

    // Fetch task details based on task ID
    $query = "SELECT * FROM tasks WHERE tid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

} catch (Exception $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>TMS</title>
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <h3 class="fa fa-solid fa-list">Update Task Status</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 m-auto">
            <br>
            <h3>Update the task status</h3>
            <form action="" method="post">
                <div class="form-group">
                    <!-- Hidden input field to store task ID -->
                    <input type="hidden" name="id" class="form-control" value="<?php echo $_GET['id']; ?>" required>
                </div>
                <div class="form-group">
                    <!-- Dropdown for selecting task status -->
                    <select name="status" class="form-control">
                        <option>--Select--</option>
                        <option>In-Progress</option>
                        <option>Complete</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-warning" name="edit_task" value="Update">
            </form>
            <a href="task.php" class="btn btn-danger">Back to home</a>
        </div>
    </div>
</body>
</html>

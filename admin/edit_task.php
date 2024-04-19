<?php
// Include Database class
require_once '../Database.php';

try {
    // Create a new instance of the Database class and establish connection
    $database = new Database();
    $conn = $database->getConnection();

    // Check if the form for editing task is submitted
    if(isset($_POST['edit_task'])){
        // Prepare SQL statement to update task details
        $query = "UPDATE tasks SET uid = ?, description = ?, start_date = ?, end_date = ? WHERE tid = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters to the prepared statement
        $stmt->bind_param("isssi", $_POST['id'], $_POST['description'], $_POST['start_date'], $_POST['end_date'], $_GET['id']);

        // Execute the statement
        if($stmt->execute()){
            // Task updated successfully, redirect to admin dashboard
            echo"<script type='text/javascript'>
            alert('Task Updated successfull');
            window.location.href = 'admin_dashboard.php';
            </script>";
            exit();
        } else {
            // Throw an exception if task update fails
            throw new Exception("Task update failed.");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>TMS</title>
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <h3 class="fa fa-solid fa-list">TMS EDIT TASK</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 m-auto">
            <br>
            <h3>Edit the task</h3>
            <form action="" method="post">
                <div class="form-group">
                    <!-- Hidden input field to store task ID -->
                    <input type="hidden" name="id" class="form-control" value="<?php echo $_GET['id']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Select User:</label>
                    <select class="form-control" name="id" required>
                        <option>-Select-</option>
                        <?php
                        // Fetch user data for dropdown
                        $query = "SELECT uid, name FROM users";
                        $result = $conn->query($query);
                        while($row1 = $result->fetch_assoc()){
                            echo "<option value='{$row1['uid']}'>{$row1['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" cols="30" rows="10" class="form-control" placeholder="Edit the description" required><?php echo $row['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Start Date:</label>
                    <input type="date" class="form-control" name="start_date" value="<?php echo $row['start_date']; ?>" required>
                </div>
                <div class="form-group">
                    <label>End Date:</label>
                    <input type="date" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>" required>
                </div>
                <input type="submit" class="btn btn-warning" name="edit_task" value="Update">
            </form>
        </div>
    </div>
</body>
</html>

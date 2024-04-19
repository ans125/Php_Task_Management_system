<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Task</title>
</head>
<body>
    <h3>Create a new task</h3>
    <div class="row">
        <div class="col-md-6">
            <form action="" method="post">
                <div class="form-group">
                    <label>Select User:</label>
                    <select class="form-control" name="id">
                        <option value="-1">-Select-</option>
                        <?php
                        // Include Database class
                        require_once '../Database.php';

                        try {
                            // Create a new instance of the Database class and establish connection
                            $database = new Database();
                            $conn = $database->getConnection();

                            // Fetch users from database
                            $query = "SELECT uid, name FROM users";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Display users in dropdown
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['uid']}'>{$row['name']}</option>";
                            }
                        } catch (Exception $e) {
                            // Handle database errors
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control" placeholder="Mention the task"></textarea>
                </div>
                <div class="form-group">
                    <label>Start Date:</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="form-group">
                    <label>End Date:</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                <input type="submit" class="btn btn-warning" name="create_task" value="Create">
            </form>
        </div>
    </div>
</body>
</html>

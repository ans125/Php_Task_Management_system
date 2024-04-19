<?php
// Include Database class
require_once '../Database.php';

try {
    // Create a new instance of the Database class and establish connection
    $database = new Database();
    $conn = $database->getConnection();

    // Check if the task ID is provided in the URL
    if(isset($_GET['id'])) {
        // Prepare SQL statement to delete task
        $query = "DELETE FROM tasks WHERE tid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET['id']);
        
        // Execute the statement
        if($stmt->execute()) {
            // Task deleted successfully
            echo "<script type='text/javascript'>
                alert('Task deleted successfully');
                window.location.href = 'admin_dashboard.php';
                </script>";
            exit(); // Exit to prevent further execution
        } else {
            // Throw an exception if task deletion fails
            throw new Exception("Task deletion failed.");
        }
    } else {
        // Redirect to admin dashboard if task ID is not provided
        header("Location: admin_dashboard.php");
        exit();
    }
} catch (Exception $e) {
    // Handle database errors
    echo "<script type='text/javascript'>
        alert('Error: ".$e->getMessage()."');
        window.location.href = 'admin_dashboard.php';
        </script>";
    exit();
}





// require_once '../Database.php';

// // Create a new instance of the Database class and establish connection
// $database = new Database();
// $conn = $database->getConnection();
// $query = "delete from tasks where tid = $_GET[id]";
// $query_run = mysqli_query($conn,$query);
// if($query_run){
//     echo"<script type='text/javascript'>
//     alert('Task Updated successfull');
//     window.location.href = 'admin_dashboard.php';
//     </script>";
// }
// else{
//     echo"<script type='text/javascript'>
//     alert('Task faild');
//     window.location.href = 'admin_dashboard.php';
//     </script>";
// }
?>
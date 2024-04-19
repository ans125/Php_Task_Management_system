<?php
session_start();
if(isset($_SESSION['email'])){

require_once 'Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();

if(isset($_POST['submit_leave'])){
    // Sanitize user input to prevent SQL injection
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $uid = $_SESSION['uid']; // Access session variable

    // Prepare the SQL statement using a prepared statement
    $query = "INSERT INTO leaves VALUES (null, ?, ?, ?, 'No Action')";
    $stmt = $conn->prepare($query);
    // Bind parameters to the statement
    $stmt->bind_param("iss", $uid, $subject, $message);
    
    // Execute the statement
    if($stmt->execute()){
        echo "<script type='text/javascript'>
                alert('Leave successfully updated');
                window.location.href = 'user_dashboard.php';
                </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Leave failed to work');
                window.location.href = 'user_dashboard.php';
                </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dashboard.css">
    <!-- jQuery code -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#user_task").click(function(){
                $("#main_content").load("task.php");
            });
        });
        // for apply_leave
        $(document).ready(function(){
            $("#applyleave").click(function(){
                $("#main_content").load("apply_leave.php");
            });
        });
        // for leave_status
        $(document).ready(function(){
            $("#leave_status").click(function(){
                $("#main_content").load("leave_status.php");
            });
        });
        </script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-md-6 text-right">
                    <div class="user-details">
                        <span>Email: <?php echo $_SESSION['email'] ?></span>
                        <span>Name:  <?php echo $_SESSION['name'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- /Header -->

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Side Menu -->
            <div id="side-menu" class="col-md-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="user_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="user_task" >Task Details</a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" id="applyleave">Apply Leave</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="leave_status">Leave Status</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /Side Menu -->

            <!-- Main Content Area -->
            <div id="main_content" class="col-md-9">
                <div class="instructions">
                    <h2>Instructions for Employees</h2>
                    <ul>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, reprehenderit.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, reprehenderit.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, reprehenderit.</li>
                    </ul>
                </div>
            </div>
            <!-- /Main Content Area -->
        </div>
    </div>
    <!-- /Main Content -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
else{
    header("Location: user_login.php");
}